<?php
require_once 'config/db.php';
$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll();
echo json_encode($products);
