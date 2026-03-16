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

    public function news()
    {
        $this->view('page/news', [
            'title' => 'Tin tức & Sự kiện - Đớ Store'
        ]);
    }

    public function contact()
    {
        $this->view('page/contact', [
            'title' => 'Liên hệ với chúng tôi - Đớ Store'
        ]);
    }
}