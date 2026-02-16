<?php
// public/cart.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/cart_functions.php';

$cartItems = getCart($pdo);
$cartTotal = getCartTotal($pdo);
?>

<main class="cart-page">
    <div class="container">
        <h1 class="page-title">Shopping Cart</h1>
        
        <?php if (empty($cartItems)): ?>
            <div class="empty-cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <h2>Your cart is empty</h2>
                <p>Add some products to get started!</p>
                <a href="index.php" class="btn-primary">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <div class="cart-items">
                    <div class="cart-table-wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item): ?>
                                    <tr data-product-id="<?= $item['id'] ?>">
                                        <td class="product-info" data-label="Product">
                                            <?php 
                                               $imgUrl = !empty($item['image_url']) ? htmlspecialchars($item['image_url']) : 'assets/images/nc1.jpg'; 
                                            ?>
                                            <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                            <div class="product-details">
                                                <h3><?= htmlspecialchars($item['name']) ?></h3>
                                                <span class="category"><?= htmlspecialchars($item['category']) ?></span>
                                            </div>
                                        </td>
                                        <td class="price" data-label="Price">Rs. <?= number_format($item['price'], 2) ?></td>
                                        <td class="quantity" data-label="Quantity">
                                            <div class="quantity-controls">
                                                <button class="qty-btn qty-decrease" data-product-id="<?= $item['id'] ?>">-</button>
                                                <input type="number" class="qty-input" value="<?= $item['quantity'] ?>" min="1" data-product-id="<?= $item['id'] ?>">
                                                <button class="qty-btn qty-increase" data-product-id="<?= $item['id'] ?>">+</button>
                                            </div>
                                        </td>
                                        <td class="subtotal" data-label="Subtotal">Rs. <?= number_format($item['subtotal'], 2) ?></td>
                                        <td class="remove" data-label="Remove">
                                            <button class="remove-btn" data-product-id="<?= $item['id'] ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="cart-summary">
                    <h2>Cart Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span class="cart-subtotal">Rs. <?= number_format($cartTotal, 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span>Calculated at checkout</span>
                    </div>
                    <hr>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span class="cart-total">Rs. <?= number_format($cartTotal, 2) ?></span>
                    </div>
                    <button class="btn-checkout">Proceed to Checkout</button>
                    <a href="index.php" class="btn-continue">Continue Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
