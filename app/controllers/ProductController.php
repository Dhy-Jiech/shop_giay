<?php
// app/controllers/ProductController.php

class ProductController extends Controller
{
    // 1. Khai báo thuộc tính để dùng chung trong toàn bộ Class
    private $productModel;
    private $collectionModel;

    public function __construct()
    {
        // 2. Khởi tạo Model ngay khi Controller được gọi
        $this->productModel = $this->model('Product');
        $this->collectionModel = $this->model('Collection');
    }

    public function index()
    {
        // Lấy các tham số từ URL
        $query = $_GET['q'] ?? null;
        $collectionSlug = $_GET['collection'] ?? null;
        $categoryId = $_GET['category'] ?? null;
        $gender = $_GET['gender'] ?? null;
        $minPrice = $_GET['min_price'] ?? null;
        $maxPrice = $_GET['max_price'] ?? null;
        $size = $_GET['size'] ?? null;

        $title = 'Tất cả sản phẩm';

        // Xử lý tìm kiếm hoặc lọc (Dùng $this->productModel)
        if ($query) {
            $products = $this->productModel->search($query);
            $title = 'Tìm kiếm: ' . htmlspecialchars($query);
        }
        else if ($collectionSlug || $categoryId || $gender || $minPrice || $maxPrice || $size) {
            $products = $this->productModel->filter($categoryId, $gender, $collectionSlug, $minPrice, $maxPrice, $size);

            if ($collectionSlug) {
                $col = $this->collectionModel->getBySlug($collectionSlug);
                $title = $col ? $col['name'] : 'Bộ sưu tập';
            }
            elseif ($gender) {
                $title = ($gender == 'Men') ? 'Giày Nam' : 'Giày Nữ';
            }
            else {
                $title = 'Danh mục sản phẩm';
            }
        }
        else {
            $products = $this->productModel->getAll();
        }

        // Lấy dữ liệu cho sidebar
        $collections = $this->collectionModel->getAll();
        $sizes = $this->productModel->getAllSizes();
        $sizeCounts = $this->productModel->countProductsBySize();
        $priceRange = $this->productModel->getPriceRange();

        // Thống kê số lượng
        $genderCounts = [
            'Men' => $this->productModel->countByGender('Men'),
            'Women' => $this->productModel->countByGender('Women'),
            'Unisex' => $this->productModel->countByGender('Unisex')
        ];

        $collectionCounts = [];
        foreach ($collections as $col) {
            $collectionCounts[$col['slug']] = $this->productModel->countByCollection($col['slug']);
        }

        $this->view('product/index', [
            'products' => $products,
            'collections' => $collections,
            'sizes' => $sizes,
            'sizeCounts' => $sizeCounts,
            'priceRange' => $priceRange,
            'title' => $title . ' - Đớ Store',
            'currentCollection' => $collectionSlug,
            'currentGender' => $gender,
            'currentSize' => $size,
            'currentMinPrice' => $minPrice,
            'currentMaxPrice' => $maxPrice,
            'genderCounts' => $genderCounts,
            'collectionCounts' => $collectionCounts,
            'productModel' => $this->productModel
        ]);
    }

    public function addReview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'product_id' => $_POST['product_id'],
                'customer_name' => htmlspecialchars($_POST['customer_name']),
                'rating' => (int)$_POST['rating'],
                'comment' => htmlspecialchars($_POST['comment'])
            ];

            // Gọi model thông qua $this->productModel (đã khởi tạo ở __construct)
            if ($this->productModel->addReview($data)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }
            else {
                echo "Lỗi không thể gửi đánh giá!";
            }
        }
    }

    public function detail($slug)
    {
        // Tìm sản phẩm bằng Slug
        $product = $this->productModel->findBySlug($slug);

        if (!$product) {
            // Chuyển hướng về trang danh sách nếu không tìm thấy sản phẩm
            header('Location: /shop_giay/product/index');
            exit();
        }

        // Lấy đánh giá thật từ Database
        $reviews = $this->productModel->getReviewsByProductId($product['id']);
        $ratingData = $this->productModel->calculateAverageRating($product['id']);

        $this->view('product/detail', [
            'product' => $product,
            'reviews' => $reviews,
            'ratingData' => $ratingData,
            'title' => $product['name'] . ' - Đớ Store'
        ]);
    }
}