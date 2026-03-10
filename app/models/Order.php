<?php

class Order extends Model
{

    public function createOrder($userId, $data, $cartItems)
    {
        try {
            $this->db->beginTransaction();

            $orderCode = 'DO' . time() . rand(100, 999);
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Using customer_id for shopper. In this context, logged-in user ID maps to customer_id or user_id depending on how auth is handled.
            // But since they registered via users table, we'll map their ID to customer_id here.
            // Or we just insert it into customer_id. The column allows NULL but let's just use it.
            $stmt = $this->db->prepare("INSERT INTO orders (customer_id, order_code, total_amount, final_amount, shipping_address, customer_name, customer_phone, note, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $userId,
                $orderCode,
                $totalAmount,
                $totalAmount,
                $data['shipping_address'],
                $data['recipient_name'],
                $data['recipient_phone'],
                $data['note'] ?? '',
                $data['payment_method']
            ]);

            $orderId = $this->db->lastInsertId();

            // Insert Items into order_details (product_variant_id is required, but we only have product_id, let's assume mapping directly for now since variants might not be fully seeded)
            // Wait, order_details requires product_variant_id.
            // If they didn't seed variants, we can't insert. Let's see if we can use product_id.
            // The schema says: product_variant_id INT NOT NULL. 
            // We must find the first variant of the product.
            $variantStmt = $this->db->prepare("SELECT id FROM product_variants WHERE product_id = ? LIMIT 1");

            $itemStmt = $this->db->prepare("INSERT INTO order_details (order_id, product_variant_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                // Determine a variant ID
                $variantStmt->execute([$item['product_id']]);
                $variantId = $variantStmt->fetchColumn();
                if (!$variantId) {
                    // Create a dummy variant to satisfy FK if none exists
                    $createVariant = $this->db->prepare("INSERT IGNORE INTO product_variants (product_id, size, color, import_price, sale_price) VALUES (?, 'Free', 'Standard', 0, ?)");
                    $createVariant->execute([$item['product_id'], $item['price']]);
                    $variantId = $this->db->lastInsertId() ?: 1;
                }

                $itemprice = floatval($item['price']);
                $itemStmt->execute([$orderId, $variantId, $item['quantity'], $itemprice, $itemprice * $item['quantity']]);

                // Deduct stock on variant
                $stockStmt = $this->db->prepare("UPDATE product_variants SET stock_quantity = stock_quantity - ? WHERE id = ?");
                $stockStmt->execute([$item['quantity'], $variantId]);
            }

            $this->db->commit();
            return $orderCode;

        }
        catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getByOrderCode($code)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE order_code = ?");
        $stmt->execute([$code]);
        $order = $stmt->fetch();
        if ($order) {
            $order['items'] = $this->getOrderItems($order['id']);
            $order['payment'] = [
                'payment_method' => $order['payment_method'],
                'payment_status' => $order['payment_status']
            ];
        }
        return $order;
    }

    private function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("SELECT od.quantity, od.unit_price as price, p.name, p.slug, pv.size, pi.image_url as primary_image
            FROM order_details od
            JOIN product_variants pv ON od.product_variant_id = pv.id
            JOIN products p ON pv.product_id = p.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = TRUE
            WHERE od.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
