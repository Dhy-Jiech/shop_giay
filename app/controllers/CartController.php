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
            $variantId = $_POST['variant_id'] ?? 0;

            // Debug
            error_log("CartController::add - product_id: $productId, quantity: $quantity, variant_id: $variantId");

            if ($productId > 0 && $variantId > 0) {
                $cartModel = $this->model('Cart');
                $cartId = $this->getCartId();
                
                $result = $cartModel->addItem($cartId, $productId, $quantity, $variantId);
                
                if ($result) {
                    $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng';
                } else {
                    $_SESSION['error'] = 'Không thể thêm sản phẩm vào giỏ hàng';
                }
            } else {
                $_SESSION['error'] = 'Thiếu thông tin sản phẩm';
            }
        }
        $this->redirect('cart/index');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;

            if ($productId > 0 && $quantity > 0) {
                $cartModel = $this->model('Cart');
                $cartId = $this->getCartId();
                $cartModel->updateItem($cartId, $productId, $quantity);
                $_SESSION['success'] = 'Đã cập nhật số lượng';
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
            $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        }
        $this->redirect('cart/index');
    }
}