<?php

class Collection extends Model
{
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM collections WHERE status = TRUE ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM collections WHERE slug = ? AND status = TRUE");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}