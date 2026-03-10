<?php

class Cart extends Model
{

    public function getOrCreateCart($userId = null, $sessionId = null)
    {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT id FROM carts WHERE user_id = ?");
            $stmt->execute([$userId]);
            $cartId = $stmt->fetchColumn();
            if (!$cartId) {
                $stmt = $this->db->prepare("INSERT INTO carts (user_id) VALUES (?)");
                $stmt->execute([$userId]);
                $cartId = $this->db->lastInsertId();
            }
        }
        else {
            $stmt = $this->db->prepare("SELECT id FROM carts WHERE session_id = ?");
            $stmt->execute([$sessionId]);
            $cartId = $stmt->fetchColumn();
            if (!$cartId) {
                $stmt = $this->db->prepare("INSERT INTO carts (session_id) VALUES (?)");
                $stmt->execute([$sessionId]);
                $cartId = $this->db->lastInsertId();
            }
        }
        return $cartId;
    }

    public function getItems($cartId)
    {
        $stmt = $this->db->prepare("SELECT ci.*, p.name, p.price, p.slug, p.size, pi.image_url as primary_image
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = TRUE
            WHERE ci.cart_id = ?");
        $stmt->execute([$cartId]);
        return $stmt->fetchAll();
    }

    public function addItem($cartId, $productId, $quantity = 1)
    {
        $stmt = $this->db->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);
        $item = $stmt->fetch();

        if ($item) {
            $newQuantity = $item['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            return $stmt->execute([$newQuantity, $item['id']]);
        }
        else {
            $stmt = $this->db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
            return $stmt->execute([$cartId, $productId, $quantity]);
        }
    }

    public function updateItem($cartId, $productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($cartId, $productId);
        }
        $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?");
        return $stmt->execute([$quantity, $cartId, $productId]);
    }

    public function removeItem($cartId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
        return $stmt->execute([$cartId, $productId]);
    }

    public function clearCart($cartId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        return $stmt->execute([$cartId]);
    }

    public function getTotal($cartId)
    {
        $items = $this->getItems($cartId);
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
