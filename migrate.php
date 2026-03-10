<?php
require 'config/database.php';
$db = Database::getInstance()->getConnection();

try {
    // 1. Add address to users if it doesn't exist
    $stmt = $db->query("SHOW COLUMNS FROM users LIKE 'address'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN address TEXT");
    }

    // 2. Add collections table
    $db->exec("CREATE TABLE IF NOT EXISTS collections (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) UNIQUE,
        description TEXT,
        image_url VARCHAR(255),
        status BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Seed collections
    $db->exec("INSERT IGNORE INTO collections (name, slug, description) VALUES
        ('Mùa Hè Sôi Động', 'mua-he-soi-dong', 'Bộ sưu tập giày thoải mái, mát mẻ cho mùa hè.'),
        ('Street Style', 'street-style', 'Phong cách đường phố, trẻ trung năng động.')");

    // Add collection_id to products if it doesn't exist
    $stmt = $db->query("SHOW COLUMNS FROM products LIKE 'collection_id'");
    if ($stmt->rowCount() == 0) {
        $db->exec("ALTER TABLE products ADD COLUMN collection_id INT NULL");
    }

    // Seed products if empty (or link to collections)

    // 3. Add carts and cart_items
    $db->exec("CREATE TABLE IF NOT EXISTS carts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL, 
        session_id VARCHAR(100) NULL, 
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS cart_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cart_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )");

    // 4. Update orders structure to match Order.php logic if needed, or update Order.php
    // Order.php inserts into order_items, but schema has order_details.
    // I prefer to just create a View or change Order.php. Wait, I will just change Order.php.

    echo json_encode(["status" => "success", "message" => "Migration complete"]);

}
catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
