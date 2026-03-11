<?php
// app/models/Cart.php

class Cart extends Model
{
    protected $table = 'carts';
    protected $itemsTable = 'cart_items';

    public function getOrCreateCart($userId, $sessionId)
    {
        // Tìm cart theo user_id hoặc session_id
        if ($userId) {
            $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE user_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE session_id = ? AND user_id IS NULL");
            $stmt->execute([$sessionId]);
        }
        
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cart) {
            return $cart['id'];
        }
        
        // Tạo cart mới
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, session_id) VALUES (?, ?)");
        $stmt->execute([$userId, $sessionId]);
        return $this->db->lastInsertId();
    }

    public function addItem($cartId, $productId, $quantity, $variantId)
    {
        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $stmt = $this->db->prepare("SELECT id, quantity FROM {$this->itemsTable} 
                                    WHERE cart_id = ? AND product_id = ? AND variant_id = ?");
        $stmt->execute([$cartId, $productId, $variantId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Cập nhật số lượng
            $newQuantity = $existing['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE {$this->itemsTable} SET quantity = ? WHERE id = ?");
            return $stmt->execute([$newQuantity, $existing['id']]);
        } else {
            // Thêm mới
            $stmt = $this->db->prepare("INSERT INTO {$this->itemsTable} (cart_id, product_id, variant_id, quantity) 
                                        VALUES (?, ?, ?, ?)");
            return $stmt->execute([$cartId, $productId, $variantId, $quantity]);
        }
    }

    public function getItems($cartId)
    {
        $sql = "SELECT ci.*, p.name, p.slug, pv.size, pv.color, pv.sale_price as price,
                       pi.image_url as primary_image
                FROM {$this->itemsTable} ci
                JOIN products p ON ci.product_id = p.id
                JOIN product_variants pv ON ci.variant_id = pv.id
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
                WHERE ci.cart_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cartId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal($cartId)
    {
        $sql = "SELECT SUM(ci.quantity * pv.sale_price) as total
                FROM {$this->itemsTable} ci
                JOIN product_variants pv ON ci.variant_id = pv.id
                WHERE ci.cart_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cartId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function updateItem($cartId, $productId, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE {$this->itemsTable} SET quantity = ? 
                                    WHERE cart_id = ? AND product_id = ?");
        return $stmt->execute([$quantity, $cartId, $productId]);
    }

    public function removeItem($cartId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->itemsTable} WHERE cart_id = ? AND product_id = ?");
        return $stmt->execute([$cartId, $productId]);
    }

    public function clearCart($cartId)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->itemsTable} WHERE cart_id = ?");
        return $stmt->execute([$cartId]);
    }
}