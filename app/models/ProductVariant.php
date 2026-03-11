<?php
// app/models/ProductVariant.php

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    public function getByProduct($productId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = ? ORDER BY size ASC, color ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStock($id, $quantity)
    {
        $sql = "UPDATE {$this->table} SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$quantity, $id, $quantity]);
    }

    public function checkStock($id, $quantity)
    {
        $sql = "SELECT stock_quantity FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $stock = $stmt->fetchColumn();
        return $stock !== false && $stock >= $quantity;
    }
}