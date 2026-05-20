<?php

class Product extends Model
{
    protected $table = 'products';

    /**
     * Lấy danh sách tất cả sản phẩm (kèm giá thấp nhất và ảnh chính)
     */
    public function getAll($limit = 100)
    {
        $sql = "SELECT p.*, c.name as collection_name, MIN(pv.sale_price) as price 
                FROM products p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                WHERE p.status = 'In Stock' 
                GROUP BY p.id 
                ORDER BY p.id DESC 
                LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->attachPrimaryImages($products);
    }

    /**
     * Tìm sản phẩm theo Slug (Dùng cho trang chi tiết)
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT p.*, c.name as collection_name 
                FROM products p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                WHERE p.slug = ? AND p.status = 'In Stock'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Lấy biến thể, ảnh và đánh giá
            $product['variants'] = $this->getVariants($product['id']);
            $product['images'] = $this->getImages($product['id']);
            $product['primary_image'] = $this->getPrimaryImage($product['id']);

            // Lấy giá mặc định từ biến thể đầu tiên
            if (!empty($product['variants'])) {
                $product['price'] = $product['variants'][0]['sale_price'];
                $product['size'] = $product['variants'][0]['size'];
                $product['stock_quantity'] = $product['variants'][0]['stock_quantity'];
            }

            $ratingData = $this->getRealRatingInfo($product['id']);
            $product['rating'] = $ratingData['avg_rating'] ?: 0;
            $product['review_count'] = $ratingData['total_reviews'] ?: 0;
            $product['category_name'] = $product['collection_name'] ?? 'Giày Thể Thao';
        }
        return $product;
    }

    /**
     * Tìm sản phẩm theo ID
     */
    public function findById($id)
    {
        $id = trim($id);
        if (!is_numeric($id))
            return null;

        $sql = "SELECT p.*, c.name as collection_name 
                FROM products p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                WHERE p.id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                if (empty($product['slug'])) {
                    $product['slug'] = 'san-pham-' . $product['id'];
                }
                $product['primary_image'] = $this->getPrimaryImage($product['id']);
                $product['price'] = $this->getProductPrice($product['id']);
                $product['variants'] = $this->getVariants($product['id']);

                $ratingData = $this->getRealRatingInfo($product['id']);
                $product['rating'] = $ratingData['avg_rating'] ?: 0;
                $product['review_count'] = $ratingData['total_reviews'] ?: 0;
            }
            return $product;
        } catch (PDOException $e) {
            error_log("Product::findById - DB Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search($query)
    {
        $searchTerm = "%$query%";
        $sql = "SELECT p.*, c.name as collection_name, MIN(pv.sale_price) as price 
                FROM products p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                WHERE (p.name LIKE ? OR p.description LIKE ?) AND p.status = 'In Stock'
                GROUP BY p.id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->attachPrimaryImages($products);
    }

    /**
     * Bộ lọc sản phẩm (Size, Giá, Danh mục, Giới tính)
     */
    public function filter($categoryId = null, $gender = null, $collectionSlug = null, $minPrice = null, $maxPrice = null, $size = null)
    {
        $sql = "SELECT p.*, c.name as collection_name, MIN(pv.sale_price) as price 
                FROM products p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                LEFT JOIN product_variants pv ON p.id = pv.product_id 
                WHERE p.status = 'In Stock'";

        $params = [];
        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        if ($gender) {
            $sql .= " AND p.gender = ?";
            $params[] = $gender;
        }
        if ($collectionSlug) {
            $sql .= " AND c.slug = ?";
            $params[] = $collectionSlug;
        }
        if ($size) {
            $sql .= " AND pv.size = ?";
            $params[] = $size;
        }

        $sql .= " GROUP BY p.id";

        if ($minPrice !== null || $maxPrice !== null) {
            $sql .= " HAVING";
            if ($minPrice !== null && $maxPrice !== null) {
                $sql .= " price BETWEEN ? AND ?";
                $params[] = (float) $minPrice;
                $params[] = (float) $maxPrice;
            } elseif ($minPrice !== null) {
                $sql .= " price >= ?";
                $params[] = (float) $minPrice;
            } elseif ($maxPrice !== null) {
                $sql .= " price <= ?";
                $params[] = (float) $maxPrice;
            }
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->attachPrimaryImages($products);
    }

    /**
     * Lấy thông tin đánh giá thực tế từ bảng reviews
     */
    public function getRealRatingInfo($productId)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(id) as total_reviews 
                FROM product_reviews WHERE product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách bình luận kèm tên khách hàng
     */
    public function getReviewsByProductId($productId)
    {
        // Sử dụng JOIN để lấy tên khách hàng từ bảng customers dựa trên customer_id
        $sql = "SELECT r.id, r.product_id, c.full_name as fullname, r.rating, r.comment, r.created_at 
                FROM product_reviews r
                JOIN customers c ON r.customer_id = c.id
                WHERE r.product_id = ? 
                ORDER BY r.created_at DESC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getReviewsByProductId: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Hỗ trợ gắn ảnh và đánh giá vào danh sách sản phẩm
     */
    private function attachPrimaryImages($products)
    {
        foreach ($products as &$p) {
            $p['primary_image'] = $this->getPrimaryImage($p['id']);
            $p['hover_image'] = $p['primary_image'];

            $ratingData = $this->getRealRatingInfo($p['id']);
            $p['rating'] = $ratingData['avg_rating'] ? round($ratingData['avg_rating'], 1) : 0;
            $p['review_count'] = $ratingData['total_reviews'] ?: 0;

            $p['category_name'] = $p['collection_name'] ?? 'Giày Thể Thao';
            $p['price'] = isset($p['price']) ? (float) $p['price'] : 0;
        }
        return $products;
    }

    // --- CÁC HÀM BỔ TRỢ HỆ THỐNG ---

    public function getPrimaryImage($productId)
    {
        $stmt = $this->db->prepare("SELECT image_url FROM product_images WHERE product_id = ? AND is_primary = 1 LIMIT 1");
        $stmt->execute([$productId]);
        $image = $stmt->fetchColumn();

        if ($image) {
            $image = ltrim($image, '/');
            // Nếu đã có shop_giay_admin trong database thì không nối thêm
            if (strpos($image, 'shop_giay_admin') !== false) {
                return '/' . $image;
            }
            return '/shop_giay_admin/' . $image;
        }

        return '/shop_giay/public/images/no-image.png';
    }

    public function getProductPrice($productId)
    {
        $stmt = $this->db->prepare("SELECT MIN(sale_price) as price FROM product_variants WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchColumn() ?: 0;
    }

    public function getVariants($productId)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_variants WHERE product_id = ? ORDER BY size ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getImages($productId)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Gắn thêm tiền tố /shop_giay_admin/ cho tất cả ảnh nếu chưa có
        foreach ($images as &$img) {
            $url = ltrim($img['image_url'], '/');
            if (strpos($url, 'shop_giay_admin') !== false) {
                $img['image_url'] = '/' . $url;
            } else {
                $img['image_url'] = '/shop_giay_admin/' . $url;
            }
        }

        return $images;
    }

    public function getAllSizes()
    {
        $sql = "SELECT DISTINCT size FROM product_variants ORDER BY CAST(size AS UNSIGNED) ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getPriceRange()
    {
        $sql = "SELECT MIN(sale_price) as min_price, MAX(sale_price) as max_price FROM product_variants";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Đếm số lượng sản phẩm theo từng Size (Dùng cho Sidebar lọc sản phẩm)
     */
    public function countProductsBySize()
    {
        $sql = "SELECT pv.size, COUNT(DISTINCT p.id) as product_count
                FROM product_variants pv
                JOIN products p ON p.id = pv.product_id
                WHERE p.status = 'In Stock'
                GROUP BY pv.size
                ORDER BY CAST(pv.size AS UNSIGNED) ASC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = [];
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $result[$row['size']] = $row['product_count'];
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error in countProductsBySize: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Đếm số lượng sản phẩm theo giới tính
     */
    public function countByGender($gender)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) as count
                FROM products p
                WHERE p.status = 'In Stock' AND p.gender = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$gender]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['count'] : 0;
    }
    /**
     * Thêm đánh giá mới vào cơ sở dữ liệu
     * Dữ liệu bao gồm: product_id, customer_name, rating, comment
     */
    public function addReview($data)
    {
        // Câu lệnh SQL để lưu vào bảng product_reviews
        // Bảng này KHÔNG có cột customer_name, ta chỉ lưu customer_id
        $sql = "INSERT INTO product_reviews (product_id, customer_id, rating, comment, created_at) 
            VALUES (:product_id, :customer_id, :rating, :comment, NOW())";

        try {
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':product_id' => $data['product_id'],
                ':customer_id' => $data['customer_id'],
                ':rating' => $data['rating'],
                ':comment' => $data['comment']
            ]);
        } catch (PDOException $e) {
            error_log("Lỗi Model Product::addReview: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra xem khách hàng đã đánh giá sản phẩm này chưa
     */
    public function hasCustomerReviewedProduct($customerId, $productId)
    {
        $sql = "SELECT COUNT(*) FROM product_reviews WHERE customer_id = ? AND product_id = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$customerId, $productId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error in hasCustomerReviewedProduct: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra xem khách hàng đã mua sản phẩm này chưa (đơn hàng Completed)
     */
    public function hasCustomerPurchasedProduct($customerId, $productId)
    {
        $sql = "SELECT COUNT(*) 
                FROM orders o 
                JOIN order_details od ON o.id = od.order_id 
                JOIN product_variants pv ON od.product_variant_id = pv.id
                WHERE o.customer_id = ? 
                  AND pv.product_id = ? 
                  AND o.order_status = 'Completed'";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$customerId, $productId]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error in hasCustomerPurchasedProduct: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Đếm số lượng sản phẩm theo bộ sưu tập
     */
    public function countByCollection($collectionSlug)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) as count
                FROM products p
                JOIN collections c ON p.collection_id = c.id
                WHERE p.status = 'In Stock' AND c.slug = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$collectionSlug]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['count'] : 0;
    }
    /**
     * Bí danh cho hàm getBySlug để tương thích với Controller cũ
     */
    public function findBySlug($slug)
    {
        return $this->getBySlug($slug);
    }/**
     * Tính trung bình cộng số sao (Bổ sung để tương thích với Controller dòng 95)
     */
    public function calculateAverageRating($productId)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(id) as total_reviews 
                FROM product_reviews 
                WHERE product_id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$productId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'stars' => $result['avg_rating'] ? round($result['avg_rating'], 1) : 0,
                'count' => $result['total_reviews'] ?: 0
            ];
        } catch (PDOException $e) {
            error_log("Error in calculateAverageRating: " . $e->getMessage());
            return ['stars' => 0, 'count' => 0];
        }
    }
}