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
            // Kiểm tra xem có phải AJAX request không
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            
            // Lấy dữ liệu từ request
            if ($isAjax) {
                // Nếu là AJAX, đọc JSON từ input
                $input = json_decode(file_get_contents('php://input'), true);
                $productId = $input['product_id'] ?? $_POST['product_id'] ?? 0;
                $quantity = $input['quantity'] ?? $_POST['quantity'] ?? 0;
            } else {
                // Nếu là form submit thường
                $productId = $_POST['product_id'] ?? 0;
                $quantity = $_POST['quantity'] ?? 0;
            }

            if ($productId > 0 && $quantity > 0) {
                $cartModel = $this->model('Cart');
                $cartId = $this->getCartId();
                
                // Cập nhật số lượng
                $result = $cartModel->updateItem($cartId, $productId, $quantity);
                
                if ($isAjax) {
                    // Nếu là AJAX, trả về JSON
                    header('Content-Type: application/json');
                    
                    if ($result) {
                        // Lấy thông tin giỏ hàng mới nhất
                        $items = $cartModel->getItems($cartId);
                        $total = $cartModel->getTotal($cartId);
                        
                        // Tính tổng tiền của item vừa update
                        $itemTotal = 0;
                        foreach ($items as $item) {
                            if ($item['product_id'] == $productId) {
                                $itemTotal = $item['price'] * $quantity;
                                break;
                            }
                        }
                        
                        echo json_encode([
                            'success' => true,
                            'message' => 'Đã cập nhật số lượng',
                            'data' => [
                                'cart_total' => $total,
                                'item_total' => $itemTotal,
                                'item_count' => count($items),
                                'subtotal' => $total,
                                'total' => $total
                            ]
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Cập nhật thất bại'
                        ]);
                    }
                    exit();
                } else {
                    // Nếu không phải AJAX, redirect như cũ
                    if ($result) {
                        $_SESSION['success'] = 'Đã cập nhật số lượng';
                    } else {
                        $_SESSION['error'] = 'Cập nhật thất bại';
                    }
                }
            }
        }
        
        // Chỉ redirect nếu không phải AJAX
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            $this->redirect('cart/index');
        }
    }

    public function remove($productId)
    {
        // Kiểm tra AJAX request
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if ($productId) {
            $cartModel = $this->model('Cart');
            $cartId = $this->getCartId();
            $result = $cartModel->removeItem($cartId, $productId);
            
            if ($isAjax) {
                header('Content-Type: application/json');
                
                if ($result) {
                    // Lấy thông tin giỏ hàng mới nhất
                    $items = $cartModel->getItems($cartId);
                    $total = $cartModel->getTotal($cartId);
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                        'data' => [
                            'cart_total' => $total,
                            'item_count' => count($items),
                            'subtotal' => $total,
                            'total' => $total
                        ]
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Xóa sản phẩm thất bại'
                    ]);
                }
                exit();
            } else {
                if ($result) {
                    $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
                } else {
                    $_SESSION['error'] = 'Xóa sản phẩm thất bại';
                }
            }
        }
        
        if (!$isAjax) {
            $this->redirect('cart/index');
        }
    }
}