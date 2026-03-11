<?php
// app/models/Customer.php

class Customer extends Model
{
    protected $table = 'customers';

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm customer theo email
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm customer theo số điện thoại
     */
    public function findByPhone($phone)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE phone = ?");
        $stmt->execute([$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm customer theo user_id (MỖI USER CHỈ CÓ 1 CUSTOMER)
     */
    public function findByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        // Nếu password chưa được hash thì hash nó
        $password = $data['password'];
        if (!password_get_info($password)['algo']) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $sql = "INSERT INTO {$this->table} 
                (full_name, username, password, email, phone, address, tier_id, user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        try {
            $result = $stmt->execute([
                $data['full_name'],
                $data['username'],
                $password,
                $data['email'] ?? null,
                $data['phone'] ?? null,
                $data['address'] ?? null,
                1, // Default tier: New Member
                $data['user_id'] ?? null
            ]);
            
            if ($result) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            // Xử lý lỗi unique constraint
            if ($e->errorInfo[1] == 1062) { // Duplicate entry
                error_log("Duplicate entry: " . $e->getMessage());
                return false;
            }
            throw $e;
        }
    }

    public function getCustomerIdByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn();
    }

    /**
     * Cập nhật thông tin customer
     */
    public function update($id, $data)
    {
        $fields = [];
        $values = [];
        
        if (isset($data['full_name'])) {
            $fields[] = "full_name = ?";
            $values[] = $data['full_name'];
        }
        if (isset($data['email'])) {
            $fields[] = "email = ?";
            $values[] = $data['email'];
        }
        if (isset($data['phone'])) {
            $fields[] = "phone = ?";
            $values[] = $data['phone'];
        }
        if (isset($data['address'])) {
            $fields[] = "address = ?";
            $values[] = $data['address'];
        }
        if (isset($data['tier_id'])) {
            $fields[] = "tier_id = ?";
            $values[] = $data['tier_id'];
        }
        if (isset($data['user_id'])) {
            $fields[] = "user_id = ?";
            $values[] = $data['user_id'];
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        try {
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Update customer error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa customer
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}