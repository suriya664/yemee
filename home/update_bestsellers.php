<?php
require_once 'config/db.php';

// Get the first two bestseller IDs
$stmt = $pdo->query("SELECT id FROM products WHERE is_bestseller = 1 LIMIT 2");
$ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (count($ids) >= 1) {
    $pdo->prepare("UPDATE products SET image_url = 'assets/images/nc1.jpg' WHERE id = ?")->execute([$ids[0]]);
    echo "Updated product ID {$ids[0]} to assets/images/nc1.jpg\n";
}

if (count($ids) >= 2) {
    $pdo->prepare("UPDATE products SET image_url = 'assets/images/nc2.jpg' WHERE id = ?")->execute([$ids[1]]);
    echo "Updated product ID {$ids[1]} to assets/images/nc2.jpg\n";
}
