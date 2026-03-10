<?php
require 'config/database.php';
$db = Database::getInstance()->getConnection();
$stmt = $db->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
$result = ["tables" => $tables];

if (in_array('users', $tables)) {
    $stmt = $db->query("DESCRIBE users");
    $result['users_columns'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
echo json_encode($result);
