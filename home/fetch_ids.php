<?php
require_once 'config/db.php';
$stmt = $pdo->query('SELECT id, name FROM products LIMIT 50');
while ($row = $stmt->fetch()) {
    echo $row['id'] . ': ' . $row['name'] . "\n";
}
