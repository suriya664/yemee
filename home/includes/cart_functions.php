<?php
// includes/cart_functions.php
// Shopping cart helper functions using PHP sessions

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/**
 * Add a product to the cart
 */
function addToCart($productId, $quantity = 1) {
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

/**
 * Remove a product from the cart
 */
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

/**
 * Update quantity of a product in cart
 */
function updateCartQuantity($productId, $quantity) {
    if ($quantity <= 0) {
        removeFromCart($productId);
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

/**
 * Get all cart items with product details
 */
function getCart($pdo) {
    $cartItems = [];
    
    if (empty($_SESSION['cart'])) {
        return $cartItems;
    }
    
    $productIds = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll();
    
    foreach ($products as $product) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $cartItems[] = $product;
    }
    
    return $cartItems;
}

/**
 * Get total number of items in cart
 */
function getCartCount() {
    if (empty($_SESSION['cart'])) {
        return 0;
    }
    return array_sum($_SESSION['cart']);
}

/**
 * Calculate cart total price
 */
function getCartTotal($pdo) {
    $cartItems = getCart($pdo);
    $total = 0;
    
    foreach ($cartItems as $item) {
        $total += $item['subtotal'];
    }
    
    return $total;
}

/**
 * Clear the entire cart
 */
function clearCart() {
    $_SESSION['cart'] = [];
}
