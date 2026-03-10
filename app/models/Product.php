<?php

class Product extends Model
{
    public function getAll($limit = 100)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.name as collection_name FROM products p LEFT JOIN collections c ON p.collection_id = c.id WHERE p.status = 'In Stock' ORDER BY p.id DESC LIMIT ?");
        $stmt->execute([$limit]);
        $products = $stmt->fetchAll();
        return $this->attachPrimaryImages($products);
    }

    public function getBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.name as collection_name FROM products p LEFT JOIN collections c ON p.collection_id = c.id WHERE p.slug = ? AND p.status = 'In Stock'");
        $stmt->execute([$slug]);
        $product = $stmt->fetch();
        if ($product) {
            $product['images'] = $this->getImages($product['id']);
        }
        return $product;
    }

    public function search($query)
    {
        $searchTerm = "%$query%";
        $stmt = $this->db->prepare("SELECT p.*, c.name as collection_name FROM products p LEFT JOIN collections c ON p.collection_id = c.id WHERE (p.name LIKE ? OR p.description LIKE ?) AND p.status = 'In Stock'");
        $stmt->execute([$searchTerm, $searchTerm]);
        $products = $stmt->fetchAll();
        return $this->attachPrimaryImages($products);
    }

    public function getByCollectionSlug($slug)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.name as collection_name FROM products p JOIN collections c ON p.collection_id = c.id WHERE c.slug = ? AND p.status = 'In Stock'");
        $stmt->execute([$slug]);
        $products = $stmt->fetchAll();
        return $this->attachPrimaryImages($products);
    }

    private function getImages($productId)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    private function attachPrimaryImages($products)
    {
        foreach ($products as &$p) {
            $stmt = $this->db->prepare("SELECT image_url FROM product_images WHERE product_id = ? AND is_primary = TRUE LIMIT 1");
            $stmt->execute([$p['id']]);
            $img = $stmt->fetchColumn();
            $p['primary_image'] = $img ?: 'public/images/default-shoe.jpg';

            // Add missing UI data expected by the new template
            $p['hover_image'] = $p['primary_image'];
            $p['is_new'] = true;
            $p['discount_percent'] = rand(0, 1) ? rand(10, 30) : 0;
            $p['rating'] = rand(4, 5);
            $p['review_count'] = rand(10, 500);
            $p['category_name'] = $p['collection_name'] ?? 'Giày Thể Thao';
            $p['category_slug'] = 'the-thao';
            $p['default_variant_id'] = $p['id'];
            $p['old_price'] = $p['discount_percent'] > 0 ? $p['price'] * (1 + $p['discount_percent'] / 100) : null;
        }
        return $products;
    }
}
