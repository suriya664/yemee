<?php
// public/products.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Get category from URL parameter
$categorySlug = isset($_GET['category']) ? $_GET['category'] : 'all';

// Map slugs to display names if needed (simple cleanup for now)
$categoryName = ucfirst(str_replace('-', ' ', $categorySlug));

// Handle different "Women" sub-categories if the URL is just /women
// For now, if category is 'women', we might want to show all women's products or just a generic header.
// Let's assume we show products where category matches or generic query.

// Handle sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "ORDER BY id DESC"; // default: newest

if ($sort === 'price-low') {
    $orderBy = "ORDER BY price ASC";
} elseif ($sort === 'price-high') {
    $orderBy = "ORDER BY price DESC";
}

// Prepare SQL
if ($categorySlug === 'all') {
    $stmt = $pdo->prepare("SELECT * FROM products $orderBy");
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE (category LIKE ? OR name LIKE ?) $orderBy");
    $searchTerm = "%$categorySlug%";
    $stmt->execute([$searchTerm, $searchTerm]);
}

$products = [];
foreach ($stmt->fetchAll() as $product) {
    if ($product['name'] !== 'Indigo Mustard Kalamkari Kerala Type Gown') {
        $products[] = $product;
    }
}
?>

<main>
    <!-- Page Banner -->
    <section class="page-banner">
        <!-- Using a placeholder or dynamic image based on category -->
        <!-- For 'Gowns' we see a specific banner in screenshot. Using a generic class for now. -->
        <div class="banner-content">
            <h1><?= htmlspecialchars($categoryName) ?></h1>
             <div class="breadcrumbs">
                <a href="index.php">Home</a> / <span><?= htmlspecialchars($categoryName) ?></span>
            </div>
        </div>
    </section>

    <!-- Sort/Filter Bar -->
    <div class="sort-bar-container">
        <div class="sort-bar">
            <div class="sort-controls">
                <div class="sort-dropdown">
                    <label>Sort By:</label>
                    <select onchange="location.href = '?category=<?= urlencode($categorySlug) ?>&sort=' + this.value;">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Date, new to old</option>
                        <option value="price-low" <?= $sort === 'price-low' ? 'selected' : '' ?>>Price, low to high</option>
                        <option value="price-high" <?= $sort === 'price-high' ? 'selected' : '' ?>>Price, high to low</option>
                    </select>
                </div>
                <div class="product-count">
                    <?php
                        if (strtolower($categorySlug) === 'combos') {
                            echo "8 Products";
                        } else {
                            echo count($products) . " Products";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (strtolower($categorySlug) === 'combos'): ?>
    <!-- Featured Combo Gallery (Replacing main grid for this category to avoid duplicates) -->
    <section class="featured-category-gallery">
        <div class="product-grid">
            <?php
            $featuredCombos = [
                ['id' => 101, 'name' => 'Vibrant Combo Pack 1', 'price' => 5500, 'img' => 'assets/images/combo/vc1.jpg'],
                ['id' => 102, 'name' => 'Classic Combo Set 2', 'price' => 6200, 'img' => 'assets/images/combo/vc2.jpg'],
                ['id' => 103, 'name' => 'Premium Combo Collection 3', 'price' => 7500, 'img' => 'assets/images/combo/vc3.jpg'],
                ['id' => 104, 'name' => 'Elegant Combo Wear 4', 'price' => 5800, 'img' => 'assets/images/combo/vc4.jpg'],
                ['id' => 105, 'name' => 'Signature Combo Pack 5', 'price' => 4500, 'img' => 'assets/images/combo/vc5.jpg'],
                ['id' => 106, 'name' => 'Classic Combo Pack 6', 'price' => 5200, 'img' => 'assets/images/combo/vc6.jpg'],
                ['id' => 107, 'name' => 'Premium Combo Pack 7', 'price' => 4800, 'img' => 'assets/images/combo/vc7.jpg'],
                ['id' => 108, 'name' => 'Elegant Combo Pack 8', 'price' => 5500, 'img' => 'assets/images/combo/vc8.jpg']
            ];

            // Manual sorting for the combos array
            if ($sort === 'price-low') {
                usort($featuredCombos, fn($a, $b) => $a['price'] <=> $b['price']);
            } elseif ($sort === 'price-high') {
                usort($featuredCombos, fn($a, $b) => $b['price'] <=> $a['price']);
            } elseif ($sort === 'newest') {
                usort($featuredCombos, fn($a, $b) => $b['id'] <=> $a['id']);
            }

            foreach ($featuredCombos as $fProduct):
            ?>
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="<?= $fProduct['img'] ?>" alt="<?= htmlspecialchars($fProduct['name']) ?>">
                </div>
                <h4><?= htmlspecialchars($fProduct['name']) ?></h4>
                <span class="text-xs text-gray-500 block mb-1">Mesmaa</span>
                <span class="price">From Rs. <?= number_format($fProduct['price'], 2) ?></span>
                <button class="btn-add-cart" 
                        data-product-id="<?= $fProduct['id'] ?>" 
                        data-product-name="<?= htmlspecialchars($fProduct['name']) ?>" 
                        data-product-price="<?= $fProduct['price'] ?>">
                    Add to Cart
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php else: ?>

    <!-- Product Grid -->
    <section class="category-products">
        <?php if (count($products) > 0): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="img-wrapper">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <!-- Overlay Icons usually go here -->
                        </div>
                        <h4><?= htmlspecialchars($product['name']) ?></h4>
                        <?php 
                            // Format price
                             $price = number_format($product['price'], 2);
                        ?>
                        <span class="text-xs text-gray-500 block mb-1">Mesmaa</span>
                        <span class="price">From Rs. <?= $price ?></span>
                        
                        <button class="btn-add-cart" 
                                data-product-id="<?= $product['id'] ?>" 
                                data-product-name="<?= htmlspecialchars($product['name']) ?>" 
                                data-product-price="<?= $product['price'] ?>">
                            Add to Cart
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align:center; padding: 50px;">
                <p>No products found in this category.</p>
            </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
