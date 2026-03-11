<?php
// app/models/Order.php

class Order extends Model
{
    protected $table = 'orders';

    /**
     * Tạo đơn hàng mới
     */
    public function createOrder($customerId, $data, $items, $isBuyNow = false, $discountAmount = 0, $promotionId = null, $userId = null)
    {
        try {
            $this->db->beginTransaction();
            error_log("===== CREATE ORDER START =====");
            error_log("Customer ID: $customerId, User ID: $userId");

            // Tính tổng tiền
            $totalAmount = 0;
            foreach ($items as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Tính phí ship (Miễn phí nếu đơn hàng >= 500k)
            $shippingFee = $totalAmount >= 500000 ? 0 : 30000;
            $finalAmount = ($totalAmount - $discountAmount) + $shippingFee;

            // Tạo mã đơn hàng
            $orderCode = 'DO' . time() . rand(100, 999);

            // Thêm vào bảng orders
            $sql = "INSERT INTO orders (
            customer_id, user_id, promotion_id, order_code, total_amount, 
            discount_amount, final_amount, payment_method, payment_status, 
            order_status, shipping_address, customer_name, customer_phone, note
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $customerId,
                $userId,
                $promotionId,
                $orderCode,
                $totalAmount,
                $discountAmount,
                $finalAmount,
                $data['payment_method'],
                'Pending',
                'Pending',
                $data['shipping_address'],
                $data['recipient_name'],
                $data['recipient_phone'],
                $data['note'] ?? ''
            ]);

            if (!$result) {
                $error = $stmt->errorInfo();
                error_log("Order creation failed: " . print_r($error, true));
                if ($this->db->inTransaction())
                    $this->db->rollBack();
                return false;
            }

            $orderId = $this->db->lastInsertId();
            error_log("Order created with ID: " . $orderId);

            // Thêm chi tiết đơn hàng
            $detailSql = "INSERT INTO order_details (order_id, product_variant_id, quantity, unit_price, total_price) 
                      VALUES (?, ?, ?, ?, ?)";
            $detailStmt = $this->db->prepare($detailSql);

            foreach ($items as $item) {
                $variantId = $item['variant_id'] ?? $this->getDefaultVariantId($item['product_id']);
                if (!$variantId) {
                    error_log("No variant found for product: " . $item['product_id']);
                    continue;
                }

                $itemTotal = $item['price'] * $item['quantity'];

                $detailResult = $detailStmt->execute([
                    $orderId,
                    $variantId,
                    $item['quantity'],
                    $item['price'],
                    $itemTotal
                ]);

                if (!$detailResult) {
                    error_log("Order detail insert failed: " . print_r($detailStmt->errorInfo(), true));
                }
            }

            // Thêm lịch sử trạng thái
            // Truyền NULL cho changed_by khi khách hàng đặt đơn (tránh FK violation trên bảng users)
            $this->addOrderHistory($orderId, 'Pending', null, 'Đơn hàng mới được tạo bởi khách hàng');

            $this->db->commit();
            error_log("===== CREATE ORDER SUCCESS: " . $orderCode . " =====");
            return $orderCode;

        }
        catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("===== CREATE ORDER ERROR =====");
            error_log("Message: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy đơn hàng theo mã
     */
    public function getByOrderCode($code)
    {
        $sql = "SELECT * FROM orders WHERE order_code = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$code]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $order['items'] = $this->getOrderItems($order['id']);
            $order['history'] = $this->getOrderHistory($order['id']);
        }
        return $order;
    }

    /**
     * Lấy lịch sử trạng thái đơn hàng
     */
    public function getOrderHistory($orderId)
    {
        $sql = "SELECT h.*, u.full_name as changed_by_name 
                FROM order_status_history h
                LEFT JOIN users u ON h.changed_by = u.id
                WHERE h.order_id = ? 
                ORDER BY h.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết đơn hàng
     */
    private function getOrderItems($orderId)
    {
        $sql = "SELECT od.*, p.name, p.slug, pv.size, pv.color, pi.image_url as primary_image
                FROM order_details od
                JOIN product_variants pv ON od.product_variant_id = pv.id
                JOIN products p ON pv.product_id = p.id
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                WHERE od.order_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy đơn hàng theo user
     */
    public function getByUserId($userId)
    {
        $sql = "SELECT * FROM orders WHERE customer_id = ? ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm lịch sử đơn hàng
     */
    private function addOrderHistory($orderId, $status, $changedBy, $note = '')
    {
        $sql = "INSERT INTO order_status_history (order_id, status, changed_by, note) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$orderId, $status, $changedBy, $note]);
    }

    /**
     * Lấy variant mặc định của sản phẩm
     */
    private function getDefaultVariantId($productId)
    {
        $sql = "SELECT id FROM product_variants WHERE product_id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchColumn();
    }
    /**
 * Lấy đơn hàng theo customer_id
 */
public function getByCustomerId($customerId)
{
    try {
        $sql = "SELECT * FROM orders 
                WHERE customer_id = ? 
                ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$customerId]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Lấy thông tin cơ bản cho mỗi đơn hàng
        foreach ($orders as &$order) {
            $order['item_count'] = $this->getOrderItemCount($order['id']);
        }
        
        return $orders;
    } catch (Exception $e) {
        error_log("GetByCustomerId error: " . $e->getMessage());
        return [];
    }
}

/**
 * Đếm số sản phẩm trong đơn hàng
 */
private function getOrderItemCount($orderId)
{
    try {
        $sql = "SELECT SUM(quantity) as total FROM order_details WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    } catch (Exception $e) {
        return 0;
    }
}
}