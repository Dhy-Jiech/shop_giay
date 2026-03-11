<?php

class Product extends Model
{
    protected $table = 'products';
    public function getAll($limit = 100)
    {
        // Thêm JOIN với product_variants để lấy sale_price
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
        $products = $stmt->fetchAll();
        return $this->attachPrimaryImages($products);
    }

    public function getBySlug($slug)
{
    // 1. Lấy thông tin cơ bản của sản phẩm
    $sql = "SELECT p.*, c.name as collection_name 
            FROM products p 
            LEFT JOIN collections c ON p.collection_id = c.id 
            WHERE p.slug = ? AND p.status = 'In Stock'";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$slug]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // 2. Lấy TẤT CẢ các size và giá tương ứng từ bảng product_variants
        $sqlVariants = "SELECT id, size, color, sale_price, stock_quantity 
                        FROM product_variants 
                        WHERE product_id = ?";
        $stmtVar = $this->db->prepare($sqlVariants);
        $stmtVar->execute([$product['id']]);
        
        // Lưu danh sách vào mảng 'variants'
        $product['variants'] = $stmtVar->fetchAll(PDO::FETCH_ASSOC);
        
        // Lấy giá của biến thể đầu tiên làm giá hiển thị mặc định
        if (!empty($product['variants'])) {
            $product['price'] = $product['variants'][0]['sale_price'];
            $product['size'] = $product['variants'][0]['size'];
            $product['stock_quantity'] = $product['variants'][0]['stock_quantity'];
        }

        $product['images'] = $this->getImages($product['id']);
    }
    return $product;
}
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
        $products = $stmt->fetchAll();
        return $this->attachPrimaryImages($products);
    }

    public function getByCollectionSlug($slug)
    {
        $sql = "SELECT p.*, c.name as collection_name, MIN(pv.sale_price) as price 
                FROM products p 
                JOIN collections c ON p.collection_id = c.id 
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                WHERE c.slug = ? AND p.status = 'In Stock'
                GROUP BY p.id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        $products = $stmt->fetchAll();
        return $this->attachPrimaryImages($products);
    }
   public function filter($categoryId = null, $gender = null, $collectionSlug = null, $minPrice = null, $maxPrice = null, $size = null)
    {
        // SQL cơ bản
        $sql = "SELECT p.*, c.name as collection_name, MIN(pv.sale_price) as price 
                FROM products p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                LEFT JOIN product_variants pv ON p.id = pv.product_id 
                WHERE p.status = 'In Stock'";
        
        $params = [];

        // Lọc theo danh mục
        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }

        // Lọc theo giới tính
        if ($gender) {
            $sql .= " AND p.gender = ?";
            $params[] = $gender;
        }

        // Lọc theo bộ sưu tập
        if ($collectionSlug) {
            $sql .= " AND c.slug = ?";
            $params[] = $collectionSlug;
        }

        // Lọc theo SIZE - Quan trọng: Phải JOIN với product_variants và lọc theo size
        if ($size) {
            $sql .= " AND pv.size = ?";
            $params[] = $size;
        }

        // GROUP BY trước khi lọc giá
        $sql .= " GROUP BY p.id";

        // Lọc theo KHOẢNG GIÁ - Phải để HAVING sau GROUP BY
        if ($minPrice !== null || $maxPrice !== null) {
            $sql .= " HAVING";
            if ($minPrice !== null && $maxPrice !== null) {
                $sql .= " price BETWEEN ? AND ?";
                $params[] = (float)$minPrice;
                $params[] = (float)$maxPrice;
            } elseif ($minPrice !== null) {
                $sql .= " price >= ?";
                $params[] = (float)$minPrice;
            } elseif ($maxPrice !== null) {
                $sql .= " price <= ?";
                $params[] = (float)$maxPrice;
            }
        }

        $sql .= " ORDER BY p.id DESC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $this->attachPrimaryImages($products);
        } catch (PDOException $e) {
            error_log("Filter error: " . $e->getMessage());
            return [];
        }
    }
    public function getAllSizes()
    {
        $sql = "SELECT DISTINCT size FROM product_variants ORDER BY CAST(size AS UNSIGNED) ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public function countProductsBySize()
    {
        $sql = "SELECT pv.size, COUNT(DISTINCT p.id) as product_count
                FROM product_variants pv
                JOIN products p ON p.id = pv.product_id
                WHERE p.status = 'In Stock'
                GROUP BY pv.size
                ORDER BY CAST(pv.size AS UNSIGNED) ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['size']] = $row['product_count'];
        }
        return $result;
    }
    public function getPriceRange()
    {
        $sql = "SELECT MIN(sale_price) as min_price, MAX(sale_price) as max_price 
                FROM product_variants pv
                JOIN products p ON p.id = pv.product_id
                WHERE p.status = 'In Stock'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
            // Lấy ảnh chính
            $stmt = $this->db->prepare("SELECT image_url FROM product_images WHERE product_id = ? AND is_primary = TRUE LIMIT 1");
            $stmt->execute([$p['id']]);
            $img = $stmt->fetchColumn();
            $p['primary_image'] = $img ?: 'public/images/default-shoe.jpg';

            $p['hover_image'] = $p['primary_image'];
            $p['is_new'] = true;
            $p['discount_percent'] = rand(0, 1) ? rand(10, 30) : 0;
            $p['rating'] = rand(4, 5);
            $p['review_count'] = rand(10, 500);
            $p['category_name'] = $p['collection_name'] ?? 'Giày Thể Thao';
            $p['category_slug'] = 'the-thao';
            $p['default_variant_id'] = $p['id'];

            // FIX LỖI: Kiểm tra key 'price' (alias từ MIN(sale_price)) trước khi tính toán
            $currentPrice = isset($p['price']) ? (float)$p['price'] : 0;
            $p['old_price'] = $p['discount_percent'] > 0 ? $currentPrice * (1 + $p['discount_percent'] / 100) : null;
            $p['price'] = $currentPrice; 
        }
        return $products;
    }
        public function countByGender($gender)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) as count
                FROM products p
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                WHERE p.status = 'In Stock' AND p.gender = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$gender]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Đếm số lượng sản phẩm theo collection
     */
    public function countByCollection($collectionSlug)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) as count
                FROM products p
                JOIN collections c ON p.collection_id = c.id
                LEFT JOIN product_variants pv ON p.id = pv.product_id
                WHERE p.status = 'In Stock' AND c.slug = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$collectionSlug]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['count'] : 0;
    }
    public function findById($id)
    {
        // Debug: Log what we are looking for
        $id = trim($id); // FIX
    
    if (!is_numeric($id)) {
        return null;
    }

    $sql = "SELECT p.*, c.name as collection_name
            FROM products p
            LEFT JOIN collections c ON p.collection_id = c.id
            WHERE p.id = ?";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                // Ensure slug is set
                if (empty($product['slug'])) {
                    $product['slug'] = 'san-pham-' . $product['id'];
                }
                
                // Add primary image and price
                $product['primary_image'] = $this->getPrimaryImage($product['id']);
                $product['price'] = $this->getProductPrice($product['id']);
                $product['variants'] = $this->getVariants($product['id']); // Load variants here too
                
                error_log("Product::findById - Found: " . $product['name']);
            } else {
                error_log("Product::findById - Not found for value: " . $id);
            }
            
            return $product;
        } catch (PDOException $e) {
            error_log("Product::findById - DB Error: " . $e->getMessage());
            return null;
        }
    }
    public function findBySlug($slug)
    {
        $sql = "SELECT p.*, c.name as collection_name 
                FROM {$this->table} p 
                LEFT JOIN collections c ON p.collection_id = c.id 
                WHERE p.slug = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            $product['primary_image'] = $this->getPrimaryImage($product['id']);
            $product['price'] = $this->getProductPrice($product['id']);
            $product['images'] = $this->getImages($product['id']);
            $product['variants'] = $this->getVariants($product['id']);
        }
        
        return $product;
    }
     /**
     * Lấy ảnh chính của sản phẩm
     */
    public function getPrimaryImage($productId)
    {
        $stmt = $this->db->prepare("SELECT image_url FROM product_images WHERE product_id = ? AND is_primary = 1 LIMIT 1");
        $stmt->execute([$productId]);
        $image = $stmt->fetchColumn();
        return $image ?: '/public/images/no-image.png';
    }
    /**
     * Lấy giá sản phẩm (giá thấp nhất từ variants)
     */
    public function getProductPrice($productId)
    {
        $stmt = $this->db->prepare("SELECT MIN(sale_price) as price FROM product_variants WHERE product_id = ?");
        $stmt->execute([$productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['price'] ?? 0;
    }
    /**
     * Lấy tất cả biến thể của sản phẩm
     */
    public function getVariants($productId)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_variants WHERE product_id = ? ORDER BY size ASC, color ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     /**
     * Kiểm tra tồn kho của biến thể
     */
    public function checkVariantStock($variantId, $quantity)
    {
        $stmt = $this->db->prepare("SELECT stock_quantity FROM product_variants WHERE id = ?");
        $stmt->execute([$variantId]);
        $stock = $stmt->fetchColumn();
        return $stock !== false && $stock >= $quantity;
    }
}