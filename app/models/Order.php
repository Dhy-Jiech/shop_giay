<?php
// app/models/Order.php

class Order extends Model
{
    protected $table = 'orders';

    /**
     * Tạo đơn hàng mới
     */
    public function createOrder($customerId, $data, $items, $isBuyNow = false)
{
    try {
        error_log("===== CREATE ORDER START =====");
        error_log("Customer ID: " . $customerId);
        error_log("Data: " . print_r($data, true));
        error_log("Items: " . print_r($items, true));
        
        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Tính phí ship
        $shippingFee = $totalAmount >= 500000 ? 0 : 30000;
        $finalAmount = $totalAmount + $shippingFee;

        // Tạo mã đơn hàng
        $orderCode = 'DO' . time() . rand(100, 999);

        // Thêm vào bảng orders - KHÔNG có user_id
        $sql = "INSERT INTO orders (
            customer_id, order_code, total_amount, discount_amount, final_amount,
            shipping_address, customer_name, customer_phone, note, payment_method,
            payment_status, order_status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $customerId,
            $orderCode,
            $totalAmount,
            0, // discount_amount mặc định
            $finalAmount,
            $data['shipping_address'],
            $data['recipient_name'],
            $data['recipient_phone'],
            $data['note'] ?? '',
            $data['payment_method'],
            'Pending',
            'Pending'
        ]);

        if (!$result) {
            $error = $stmt->errorInfo();
            error_log("Order creation failed: " . print_r($error, true));
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
        $this->addOrderHistory($orderId, 'Pending', $customerId, 'Đơn hàng mới');

        error_log("===== CREATE ORDER SUCCESS: " . $orderCode . " =====");
        return $orderCode;

    } catch (Exception $e) {
        error_log("===== CREATE ORDER ERROR =====");
        error_log("Message: " . $e->getMessage());
        error_log("Stack trace: " . $e->getTraceAsString());
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
        }
        return $order;
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
}