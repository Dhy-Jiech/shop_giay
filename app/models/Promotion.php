<?php
// app/models/Promotion.php

class Promotion extends Model
{
    protected $table = 'promotions';

    /**
     * Lấy tất cả khuyến mãi
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy khuyến mãi đang hoạt động
     */
    public function getActivePromotions()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 1 
                AND start_date <= NOW() 
                AND end_date >= NOW() 
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm khuyến mãi theo mã
     */
    public function findByCode($code)
    {
        $sql = "SELECT * FROM {$this->table} WHERE code = ? AND status = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kiểm tra và tính giảm giá
     */
    public function calculateDiscount($code, $total)
    {
        $promo = $this->findByCode($code);

        if (!$promo) {
            return ['success' => false, 'message' => 'Mã khuyến mãi không hợp lệ'];
        }

        // Kiểm tra thời gian
        $now = date('Y-m-d H:i:s');
        if ($promo['start_date'] > $now || $promo['end_date'] < $now) {
            return ['success' => false, 'message' => 'Mã khuyến mãi đã hết hạn'];
        }

        // Kiểm tra số lần sử dụng
        if ($promo['usage_limit'] !== null && $promo['used_count'] >= $promo['usage_limit']) {
            return ['success' => false, 'message' => 'Mã khuyến mãi đã hết lượt sử dụng'];
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($total < $promo['min_order_value']) {
            return [
                'success' => false,
                'message' => 'Đơn hàng tối thiểu ' . number_format($promo['min_order_value'], 0, ',', '.') . 'đ'
            ];
        }

        // Tính giảm giá
        if ($promo['discount_type'] == 'Percent') {
            $discount = $total * $promo['discount_value'] / 100;
            if ($promo['max_discount_amount'] && $discount > $promo['max_discount_amount']) {
                $discount = $promo['max_discount_amount'];
            }
        }
        else {
            $discount = $promo['discount_value'];
        }

        return [
            'success' => true,
            'discount' => $discount,
            'promo' => $promo
        ];
    }

    /**
     * Tăng số lần sử dụng
     */
    public function incrementUsedCount($id)
    {
        $sql = "UPDATE {$this->table} SET used_count = used_count + 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Tạo bảng promotions nếu chưa có
     */
    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(50) UNIQUE NOT NULL,
            name VARCHAR(255) NOT NULL,
            discount_type ENUM('Percent', 'Fixed') NOT NULL,
            discount_value DECIMAL(10,2) NOT NULL,
            min_order_value DECIMAL(15,2) DEFAULT 0,
            max_discount_amount DECIMAL(15,2) DEFAULT NULL,
            start_date DATETIME NOT NULL,
            end_date DATETIME NOT NULL,
            usage_limit INT DEFAULT NULL,
            used_count INT DEFAULT 0,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        try {
            $this->db->exec($sql);

            // Thêm dữ liệu mẫu
            
            return true;
        }
        catch (PDOException $e) {
            error_log("Error creating promotions table: " . $e->getMessage());
            return false;
        }
    }



}