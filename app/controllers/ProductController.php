<?php

class ProductController extends Controller
{
    public function index()
    {
        $productModel = $this->model('Product');
        $collectionModel = $this->model('Collection');

        $query = $_GET['q'] ?? null;
        $collectionSlug = $_GET['collection'] ?? null;

        $products = [];
        $title = 'Tất cả sản phẩm';

        if ($query) {
            $products = $productModel->search($query);
            $title = 'Tìm kiếm: ' . htmlspecialchars($query);
        }
        else if ($collectionSlug) {
            $products = $productModel->getByCollectionSlug($collectionSlug);
            $collection = $collectionModel->getBySlug($collectionSlug);
            $title = $collection ? $collection['name'] : 'Bộ sưu tập';
        }
        else {
            $products = $productModel->getAll();
        }

        $collections = $collectionModel->getAll();

        $this->view('product/index', [
            'products' => $products,
            'collections' => $collections,
            'title' => $title . ' - Đớ Store',
            'currentCollection' => $collectionSlug
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
