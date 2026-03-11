<?php
// list_ids.php
require_once 'config/database.php';
$db = Database::getInstance()->getConnection();
$stmt = $db->query("SELECT id, name FROM products");
while ($row = $stmt->fetch()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['name'] . "\n";
}
echo "Total products: " . $stmt->rowCount() . "\n";
