<?php
require_once 'config/db.php';

// Delete the specific gown that was removed from the SQL file
$gownName = 'Indigo Mustard Kalamkari Kerala Type Gown';
$stmt = $pdo->prepare("DELETE FROM products WHERE name = ? AND category = 'Gowns'");
$stmt->execute([$gownName]);

if ($stmt->rowCount() > 0) {
    echo "Successfully deleted '$gownName' from the database.\n";
} else {
    echo "Gown '$gownName' not found or already deleted.\n";
}
