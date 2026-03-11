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

    /**
     * BƯỚC 1: Hiển thị form chọn size, số lượng
     */
    public function buyNow($productId = null)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
            $_SESSION['redirect_after_login'] = "/shop_giay/order/buyNow/$productId";
            $this->redirect('auth/login');
            return;
        }

        if (!$productId || !is_numeric($productId)) {
            $_SESSION['error'] = 'Sản phẩm không hợp lệ.';
            $this->redirect('product/index');
            return;
        }

        // Lấy thông tin sản phẩm
        $productModel = $this->model('Product');
        $product = $productModel->findById($productId);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm.';
            $this->redirect('product/index');
            return;
        }

        // Lấy biến thể của sản phẩm
        $variantModel = $this->model('ProductVariant');
        $variants = $variantModel->getByProduct($productId);

        // Nếu là POST request (chọn size xong)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->processBuyNowSelection($product, $variants);
        }

        // Hiển thị form chọn size
        $this->view('order/buy-now', [
            'product' => $product,
            'variants' => $variants,
            'title' => 'Chọn phân loại - ' . ($product['name'] ?? 'Sản phẩm')
        ]);
    }

    /**
     * BƯỚC 2: Xử lý chọn size và chuyển sang form nhập thông tin
     */
    private function processBuyNowSelection($product, $variants)
    {
        $variantId = $_POST['variant_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);

        // Validate
        if (!$variantId) {
            $_SESSION['error'] = 'Vui lòng chọn size và màu sắc.';
            $this->redirect('order/buyNow/' . $product['id']);
            return;
        }

        // Tìm variant được chọn
        $selectedVariant = null;
        foreach ($variants as $variant) {
            if ($variant['id'] == $variantId) {
                $selectedVariant = $variant;
                break;
            }
        }

        if (!$selectedVariant) {
            $_SESSION['error'] = 'Phân loại sản phẩm không hợp lệ.';
            $this->redirect('order/buyNow/' . $product['id']);
            return;
        }

        // Kiểm tra tồn kho
        if ($selectedVariant['stock_quantity'] < $quantity) {
            $_SESSION['error'] = 'Sản phẩm không đủ số lượng. Chỉ còn ' . $selectedVariant['stock_quantity'] . ' sản phẩm.';
            $this->redirect('order/buyNow/' . $product['id']);
            return;
        }

        // Tạo item để chuyển sang checkout - CHỈ 1 SẢN PHẨM
        $buyNowItem = [
            [
                'product_id' => $product['id'],
                'variant_id' => $selectedVariant['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'size' => $selectedVariant['size'],
                'color' => $selectedVariant['color'],
                'price' => $selectedVariant['sale_price'],
                'quantity' => $quantity,
                'image' => $product['primary_image'] ?? '/public/images/no-image.png'
            ]
        ];

        // Lưu vào SESSION riêng - KHÔNG ẢNH HƯỞNG GIỎ HÀNG
        $_SESSION['buy_now_items'] = $buyNowItem;

        // Debug log
        error_log("Buy Now Item saved to session: " . print_r($buyNowItem, true));
        error_log("Session ID: " . session_id());

        // CHUYỂN ĐẾN TRANG NHẬP THÔNG TIN GIAO HÀNG
        $this->redirect('order/checkout?type=buy_now');
    }

    /**
     * BƯỚC 3: Hiển thị form nhập thông tin giao hàng và thanh toán
     */
    public function checkout()
    {
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
            $_SESSION['redirect_after_login'] = '/shop_giay/order/checkout';
            $this->redirect('auth/login');
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['customer_id'];
        $userType = isset($_SESSION['user_id']) ? 'user' : 'customer';

        // Lấy thông tin người dùng
        if ($userType == 'user') {
            $userModel = $this->model('User');
            $user = $userModel->findById($userId);
        }
        else {
            $customerModel = $this->model('Customer');
            $user = $customerModel->findById($userId);
        }

        // Kiểm tra xem có phải đang mua ngay không
        $isBuyNow = isset($_GET['type']) && $_GET['type'] == 'buy_now' && isset($_SESSION['buy_now_items']);

        if ($isBuyNow) {
            // Lấy items từ session buy_now
            $items = $_SESSION['buy_now_items'] ?? [];
            $cartId = null;
            $total = 0;

            if (!empty($items)) {
                foreach ($items as $item) {
                    $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                }
            }
            else {
                error_log("OrderController::checkout - Buy Now items missing in session");
                $_SESSION['error'] = 'Không có sản phẩm nào để thanh toán.';
                $this->redirect('product/index');
                return;
            }
        }
        else {
            // Lấy items từ giỏ hàng
            $cartModel = $this->model('Cart');
            $cartId = $this->getCartId();
            $items = $cartModel->getItems($cartId) ?: [];
            $total = $cartModel->getTotal($cartId) ?: 0;

            if (empty($items)) {
                error_log("OrderController::checkout - Cart is empty for CartID: " . $cartId);
                $this->redirect('cart/index');
                return;
            }
        }

        // Xử lý POST request khi submit form checkout
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->processCheckout($items, $total, $isBuyNow, $cartId, $user);
        }

        // Hiển thị form nhập thông tin
        error_log("Checkout items count: " . count($items));
        $this->view('order/checkout', [
            'items' => $items,
            'total' => $total,
            'user' => $user,
            'isBuyNow' => $isBuyNow,
            'promotions' => $this->getActivePromotions(),
            'title' => 'Thông tin giao hàng - Đớ Store'
        ]);
    }

    /**
     * BƯỚC 4: Xử lý form nhập thông tin và tạo đơn hàng
     */
    private function processCheckout($items, $total, $isBuyNow, $cartId = null, $user = null)    {
        error_log("===== PROCESS CHECKOUT START =====");
        error_log("Items: " . print_r($items, true));
        error_log("Total: $total");
        error_log("POST data: " . print_r($_POST, true));

        $orderModel = $this->model('Order');

        $data = [
            'recipient_name' => trim($_POST['recipient_name'] ?? ''),
            'recipient_phone' => trim($_POST['recipient_phone'] ?? ''),
            'shipping_address' => trim($_POST['shipping_address'] ?? ''),
            'note' => trim($_POST['note'] ?? ''),
            'payment_method' => $_POST['payment_method'] ?? 'COD',
            'promo_code' => $_POST['promo_code'] ?? null
        ];

        // Validate dữ liệu
        $errors = [];
        if (empty($data['recipient_name'])) {
            $errors[] = 'Vui lòng nhập tên người nhận.';
        }
        if (empty($data['recipient_phone'])) {
            $errors[] = 'Vui lòng nhập số điện thoại.';
        }
        elseif (!preg_match('/^[0-9]{10,11}$/', $data['recipient_phone'])) {
            $errors[] = 'Số điện thoại không hợp lệ (10-11 số).';
        }
        if (empty($data['shipping_address'])) {
            $errors[] = 'Vui lòng nhập địa chỉ nhận hàng.';
        }

        if (!empty($errors)) {
            $this->view('order/checkout', [
                'items' => $items,
                'total' => $total,
                'errors' => $errors,
                'old_input' => $_POST,
                'isBuyNow' => $isBuyNow,
                'user' => $user,
                'title' => 'Thông tin giao hàng - Đớ Store'
            ]);
            return;
        }

        // Xác định customer_id
        $customerId = $_SESSION['customer_id'] ?? null;

        if (!$customerId) {
            error_log("ERROR: No customer_id in session");
            $this->view('order/checkout', [
                'items' => $items,
                'total' => $total,
                'error' => 'Không tìm thấy thông tin khách hàng. Vui lòng đăng nhập lại.',
                'isBuyNow' => $isBuyNow,
                'user' => $user,
                'title' => 'Thông tin giao hàng - Đớ Store'
            ]);
            return;
        }

        // Xử lý mã khuyến mãi
        $promoCode = trim($_POST['promo_code'] ?? '');
        $discountAmount = 0;
        $promotionId = null;

        if (!empty($promoCode)) {
            $promotionModel = $this->model('Promotion');
            $promoResult = $promotionModel->calculateDiscount($promoCode, $total);
            if ($promoResult['success']) {
                $discountAmount = $promoResult['discount'];
                $promotionId = $promoResult['promo']['id'];
                $promotionModel->incrementUsedCount($promotionId);
            }
        }

        // Tạo đơn hàng - CHỈ TRUYỀN 4 THAM SỐ ĐẦU TIÊN
        $orderCode = $orderModel->createOrder($customerId, $data, $items, $isBuyNow);

        if ($orderCode) {
            // Xóa giỏ hàng hoặc session buy_now
            if ($isBuyNow) {
                unset($_SESSION['buy_now_items']);
            }
            else {
                $cartModel = $this->model('Cart');
                $cartModel->clearCart($cartId);
            }

            $_SESSION['order_success'] = [
                'message' => 'Đặt hàng thành công! Mã đơn hàng của bạn là: ' . $orderCode,
                'order_code' => $orderCode
            ];

            $this->redirect('order/success/' . $orderCode);
        }
        else {
            $this->view('order/checkout', [
                'items' => $items,
                'total' => $total,
                'error' => 'Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại.',
                'isBuyNow' => $isBuyNow,
                'user' => $user,
                'title' => 'Thông tin giao hàng - Đớ Store'
            ]);
        }    }

    public function success($orderCode = '')
    {
        if (empty($orderCode)) {
            $_SESSION['error'] = 'Không tìm thấy mã đơn hàng.';
            $this->redirect('product/index');
        }

        $orderModel = $this->model('Order');
        $order = $orderModel->getByOrderCode($orderCode);

        if (!$order) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng với mã: ' . $orderCode;
            $this->redirect('product/index');
        }

        // Xóa thông báo cũ nếu có
        if (isset($_SESSION['order_success'])) {
            unset($_SESSION['order_success']);
        }

        $this->view('order/success', [
            'order' => $order,
            'title' => 'Đặt hàng thành công - Đớ Store'
        ]);
    }
    public function tracking($orderCode = '')
    {
        $orderModel = $this->model('Order');

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

    private function getProductPrimaryImage($productId)
    {
        $productModel = $this->model('Product');
        $images = $productModel->getImages($productId);
        foreach ($images as $img) {
            if ($img['is_primary']) {
                return $img['image_url'];
            }
        }
        return !empty($images) ? $images[0]['image_url'] : '/public/images/no-image.png';
    }
    private function getActivePromotions()
    {
        try {
            // Kiểm tra file Promotion.php có tồn tại không
            $promotionFile = dirname(__DIR__) . '/models/Promotion.php';
            if (!file_exists($promotionFile)) {
                // Tạo bảng promotions nếu chưa có
                $promotionModel = $this->model('Promotion');
                if ($promotionModel) {
                    $promotionModel->createTable();
                }
                return [];
            }

            $promotionModel = $this->model('Promotion');
            return $promotionModel->getActivePromotions();
        }
        catch (Exception $e) {
            error_log("Error getting promotions: " . $e->getMessage());
            return [];
        }
    }
}