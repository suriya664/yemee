<?php
// public/cart_ajax.php
// AJAX endpoint for cart operations

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/cart_functions.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$productId = isset($_POST['product_id']) ? $_POST['product_id'] : '';
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

$response = ['success' => false, 'message' => ''];

switch ($action) {
    case 'add':
        if (!empty($productId)) {
            addToCart($productId, $quantity);
            $response['success'] = true;
            $response['message'] = 'Product added to cart';
            $response['cart_count'] = getCartCount();
        } else {
            $response['message'] = 'Empty product ID';
        }
        break;
        
    case 'remove':
        if (!empty($productId)) {
            removeFromCart($productId);
            $response['success'] = true;
            $response['message'] = 'Product removed from cart';
            $response['cart_count'] = getCartCount();
            $response['cart_total'] = number_format(getCartTotal($pdo), 2);
        } else {
            $response['message'] = 'Invalid product ID';
        }
        break;
        
    case 'update':
        if (!empty($productId)) {
            updateCartQuantity($productId, $quantity);
            $response['success'] = true;
            $response['message'] = 'Cart updated';
            $response['cart_count'] = getCartCount();
            $response['cart_total'] = number_format(getCartTotal($pdo), 2);
        } else {
            $response['message'] = 'Invalid product ID';
        }
        break;
        
    case 'clear':
        clearCart();
        $response['success'] = true;
        $response['message'] = 'Cart cleared';
        $response['cart_count'] = 0;
        $response['cart_total'] = '0.00';
        break;
        
    default:
        $response['message'] = 'Invalid action';
}

echo json_encode($response);
