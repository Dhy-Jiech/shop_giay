<?php

class HomeController extends Controller
{
    public function index()
    {
        $productModel = $this->model('Product');
        $collectionModel = $this->model('Collection');

        $featuredProducts = $productModel->getAll(8);
        $collections = $collectionModel->getAll();

        $this->view('home/index', [
            'products' => $featuredProducts,
            'collections' => $collections,
            'title' => 'Trang chủ - Đớ Store'
        ]);
    }

    public function about()
    {
        $this->view('page/about', [
            'title' => 'Về Thương Hiệu Đớ'
        ]);
    }
}