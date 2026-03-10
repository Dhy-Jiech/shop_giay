<?php

class CartController extends Controller
{

    private function getCartId()
    {
        $cartModel = $this->model('Cart');
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        return $cartModel->getOrCreateCart($userId, $sessionId);
    }

    public function index()
    {
        $cartModel = $this->model('Cart');
        $cartId = $this->getCartId();

        $items = $cartModel->getItems($cartId);
        $total = $cartModel->getTotal($cartId);

        $this->view('cart/index', [
            'items' => $items,
            'total' => $total,
            'title' => 'Giỏ hàng của bạn - Đớ Store'
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            if ($productId > 0) {
                $cartModel = $this->model('Cart');
                $cartId = $this->getCartId();
                $cartModel->addItem($cartId, $productId, $quantity);
            }
        }
        $this->redirect('cart/index');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;

            if ($productId > 0) {
                $cartModel = $this->model('Cart');
                $cartId = $this->getCartId();
                $cartModel->updateItem($cartId, $productId, $quantity);
            }
        }
        $this->redirect('cart/index');
    }

    public function remove($productId)
    {
        if ($productId) {
            $cartModel = $this->model('Cart');
            $cartId = $this->getCartId();
            $cartModel->removeItem($cartId, $productId);
        }
        $this->redirect('cart/index');
    }
}
