<?php

class OrderController extends Controller
{

    private function getCartId()
    {
        $cartModel = $this->model('Cart');
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        return $cartModel->getOrCreateCart($userId, $sessionId);
    }

    public function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }

        $cartModel = $this->model('Cart');
        $cartId = $this->getCartId();
        $items = $cartModel->getItems($cartId);

        if (empty($items)) {
            $this->redirect('cart/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderModel = $this->model('Order');

            $data = [
                'recipient_name' => trim($_POST['recipient_name']),
                'recipient_phone' => trim($_POST['recipient_phone']),
                'shipping_address' => trim($_POST['shipping_address']),
                'note' => trim($_POST['note']),
                'payment_method' => $_POST['payment_method']
            ];

            if (empty($data['recipient_name']) || empty($data['recipient_phone']) || empty($data['shipping_address'])) {
                $this->view('order/checkout', [
                    'items' => $items,
                    'total' => $cartModel->getTotal($cartId),
                    'error' => 'Vui lòng điền đủ thông tin nhận hàng.',
                    'title' => 'Thanh toán - Đớ Store'
                ]);
                return;
            }

            $orderCode = $orderModel->createOrder($_SESSION['user_id'], $data, $items);

            if ($orderCode) {
                // Clear cart
                $cartModel->clearCart($cartId);
                $this->redirect('order/tracking/' . $orderCode);
            }
            else {
                $this->view('order/checkout', [
                    'items' => $items,
                    'total' => $cartModel->getTotal($cartId),
                    'error' => 'Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại.',
                    'title' => 'Thanh toán - Đớ Store'
                ]);
            }

        }
        else {
            $userModel = $this->model('User');
            $user = $userModel->findById($_SESSION['user_id']);

            $this->view('order/checkout', [
                'items' => $items,
                'total' => $cartModel->getTotal($cartId),
                'user' => $user,
                'title' => 'Thanh toán - Đớ Store'
            ]);
        }
    }

    public function tracking($orderCode = '')
    {
        $orderModel = $this->model('Order');

        // If orderCode is provided via URL
        if ($orderCode) {
            $order = $orderModel->getByOrderCode($orderCode);
            if ($order) {
                $this->view('order/tracking', [
                    'order' => $order,
                    'title' => 'Theo dõi đơn hàng - Đớ Store'
                ]);
                return;
            }
        }

        // If submitted via POST form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = trim($_POST['order_code']);
            $order = $orderModel->getByOrderCode($code);

            if ($order) {
                $this->view('order/tracking', [
                    'order' => $order,
                    'title' => 'Theo dõi đơn hàng - Đớ Store'
                ]);
                return;
            }
            else {
                $this->view('order/tracking', [
                    'error' => 'Không tìm thấy đơn hàng với mã này.',
                    'title' => 'Theo dõi đơn hàng - Đớ Store'
                ]);
                return;
            }
        }

        $this->view('order/tracking', ['title' => 'Theo dõi đơn hàng - Đớ Store']);
    }
}
