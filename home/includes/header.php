<?php
// includes/header.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/cart_functions.php';

$cartCount = getCartCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesmaa - The Clothing Experience</title>
    <!-- Google Fonts: Playfair Display (Serif) & Lato (Sans-Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Floating Elements -->
<div class="floating-loyalty">
    <button><i class="fa-solid fa-gift"></i> Loyalty Points</button>
</div>

<!-- Header Section -->
<header>
    <div class="top-nav">

        <div class="nav-placeholder desktop-only"></div>

        <div class="mobile-toggle mobile-only" id="mobile-menu-open">
            <i class="fa-solid fa-bars"></i>
        </div>
        
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo/logo.png" alt="Mesmaa Logo" class="header-logo">
            </a>
        </div>

        <div class="user-actions">
            <a href="cart.php" class="cart-icon">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="cart-count"><?= $cartCount ?></span>
            </a>
        </div>
    </div>
</header>
