<?php
// app/models/User.php

class User extends Model
{
    protected $table = 'users';

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Debug
        error_log("User::findById($id) - Found: " . ($user ? 'YES' : 'NO'));
        
        return $user;
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (username, password, full_name, email, phone, role_id, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['username'],
            $data['password'],
            $data['full_name'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            4, // role_id = 4 (Customer)
            1  // is_active = true
        ]);
        
        if ($result) {
            $id = $this->db->lastInsertId();
            error_log("User::create - Created user with ID: " . $id);
            return $id;
        }
        
        error_log("User::create - Failed to create user");
        return false;
    }

    public function updateProfile($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?");
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}