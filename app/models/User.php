<?php

class User extends Model
{
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        // Adding role_id = 2 as default since the original schema requires role_id
        $stmt = $this->db->prepare("INSERT INTO users (role_id, username, password, full_name, email, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            2,
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['full_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['address'] ?? null
        ]);
    }

    public function updateProfile($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $id
        ]);
    }
}
