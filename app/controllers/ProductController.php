<?php
// app/controllers/ProductController.php

class ProductController extends Controller
{
    public function index()
    {
        $productModel = $this->model('Product');
        $collectionModel = $this->model('Collection');

        // Lấy các tham số từ URL
        $query = $_GET['q'] ?? null;
        $collectionSlug = $_GET['collection'] ?? null;
        $categoryId = $_GET['category'] ?? null;
        $gender = $_GET['gender'] ?? null;
        $minPrice = $_GET['min_price'] ?? null;
        $maxPrice = $_GET['max_price'] ?? null;
        $size = $_GET['size'] ?? null;

        $title = 'Tất cả sản phẩm';

        // Xử lý tìm kiếm
        if ($query) {
            $products = $productModel->search($query);
            $title = 'Tìm kiếm: ' . htmlspecialchars($query);
        } 
        // Xử lý lọc với nhiều tiêu chí
        else if ($collectionSlug || $categoryId || $gender || $minPrice || $maxPrice || $size) {
            $products = $productModel->filter($categoryId, $gender, $collectionSlug, $minPrice, $maxPrice, $size);
            
            // Cập nhật tiêu đề
            if ($collectionSlug) {
                $col = $collectionModel->getBySlug($collectionSlug);
                $title = $col ? $col['name'] : 'Bộ sưu tập';
            } elseif ($gender) {
                $title = ($gender == 'Men') ? 'Giày Nam' : 'Giày Nữ';
            } else {
                $title = 'Danh mục sản phẩm';
            }
        } 
        else {
            $products = $productModel->getAll();
        }

        // Lấy dữ liệu cho sidebar filter
        $collections = $collectionModel->getAll();
        $sizes = $productModel->getAllSizes();
        $sizeCounts = $productModel->countProductsBySize();
        $priceRange = $productModel->getPriceRange();

        // Đếm số lượng theo giới tính
        $genderCounts = [
            'Men' => $productModel->countByGender('Men'),
            'Women' => $productModel->countByGender('Women'),
            'Unisex' => $productModel->countByGender('Unisex')
        ];

        // Đếm số lượng theo collection
        $collectionCounts = [];
        foreach ($collections as $col) {
            $collectionCounts[$col['slug']] = $productModel->countByCollection($col['slug']);
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
            // Thêm các biến đếm
            'genderCounts' => $genderCounts,
            'collectionCounts' => $collectionCounts,
            // Thêm model để dùng trong view (nếu cần)
            'productModel' => $productModel
        ]);
    }

    public function detail($slug)
    {
        $productModel = $this->model('Product');
        $product = $productModel->getBySlug($slug);

        if (!$product) {
            $this->redirect('product/index');
        }

        $this->view('product/detail', [
            'product' => $product,
            'title' => $product['name'] . ' - Đớ Store'
        ]);
    }
}