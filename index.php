<?php
// public/index.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Static Banners using b1, b2, b3 images
$banners = [
    [
        'image_url' => 'assets/images/b1.png',
        'heading' => 'Exquisite Collection',
        'subheading' => 'Discover timeless elegance in every piece',
        'button_text' => 'Shop Now',
        'button_url' => '#'
    ],
    [
        'image_url' => 'assets/images/b2.png',
        'heading' => 'New Arrivals',
        'subheading' => 'Embrace the latest trends in ethnic fashion',
        'button_text' => 'Explore',
        'button_url' => '#'
    ],
    [
        'image_url' => 'assets/images/b3.png',
        'heading' => 'Premium Designs',
        'subheading' => 'Crafted with perfection for your special moments',
        'button_text' => 'View Collection',
        'button_url' => '#'
    ]
];

// Fetch Products (Best Sellers)
$stmt = $pdo->query("SELECT * FROM products WHERE is_bestseller = 1 LIMIT 8");
$bestSellers = $stmt->fetchAll();

// Fetch New Collection (for display)
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 10");
$newCollection = $stmt->fetchAll();

?>

<main>
    <!-- 1. Hero Section -->
    <section class="hero-slider">
        <div class="slides-container">
            <?php foreach ($banners as $index => $banner): ?>
                <div class="hero-slide <?= $index === 0 ? 'active' : '' ?>">
                    <div class="slide-bg" style="background-image: url('<?= htmlspecialchars($banner['image_url']) ?>');"></div>
                    <div class="hero-content">
                        <h2 class="animate-text"><?= htmlspecialchars($banner['heading']) ?></h2>
                        <p class="animate-text delay-1"><?= htmlspecialchars($banner['subheading']) ?></p>
                        <?php if ($banner['button_text']): ?>
                            <a href="<?= htmlspecialchars($banner['button_url']) ?>" class="btn-primary animate-text delay-2"><?= htmlspecialchars($banner['button_text']) ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Slider Controls -->
        <div class="slider-controls">
            <button class="prev-slide" aria-label="Previous Slide">&#10094;</button>
            <button class="next-slide" aria-label="Next Slide">&#10095;</button>
        </div>

        <!-- Slider Dots -->
        <div class="slider-dots">
            <?php foreach ($banners as $index => $banner): ?>
                <span class="dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></span>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 2. Shop By Category -->
    <section class="category-section">
        <h2 class="section-title">Shop By Category</h2>
        <div class="category-grid">
            <?php
            $cats = [
                'Bridal' => 'nc22.jpg', 
                'Sarees' => 'nc12.jpg', 
                'Gowns' => 'nc20.jpg', 
                'Lehengas/Half saree' => 'nc13.jpg', 
                'Anarkali' => 'nc19.jpg', 
                'Dresses' => 'nc21.jpg',
                'Kurti' => 'nc25.jpg',
                'Kids' => 'nc17.jpg',
                'Combos' => 'nc24.jpg',
                'Blouse' => 'nc12.jpg',
                'Suits' => 'nc18.jpg',
                'Dupattas' => 'nc14.jpg'
            ];
            foreach ($cats as $name => $img): 
            ?>
            <div class="category-item">
                <div class="cat-img-circle">
                    <img src="assets/images/<?= $img ?>" alt="<?= $name ?>">
                </div>
                <h3><?= $name ?></h3>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 3. New Collection Section -->
    <section class="new-collection-section">
        <div class="nc-container">
            <div class="nc-text">
                <h2>New Collection</h2>
                <a href="#" class="btn-primary-solid">Shop Now</a>
            </div>
            <div class="nc-products">
                 <?php foreach ($newCollection as $product): ?>
                 <div class="product-card minimal">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h4><?= htmlspecialchars($product['name']) ?></h4>
                    <span class="price">Rs. <?= number_format($product['price'], 2) ?></span>
                    <button class="btn-add-cart" 
                            data-product-id="<?= $product['id'] ?>" 
                            data-product-name="<?= htmlspecialchars($product['name']) ?>" 
                            data-product-price="<?= $product['price'] ?>">
                        Add to Cart
                    </button>
                 </div>
                 <?php endforeach; ?>
                 
                 <?php if (empty($newCollection)): ?>
                 <!-- Fallback items if DB is empty -->
                 <div class="product-card minimal">
                    <img src="assets/images/nc1.jpg" alt="Product 1">
                    <h4>Baby Pink Indigo Floral Pleated Anarkali.</h4>
                    <span class="price">Rs. 3,780.00</span>
                    <button class="btn-add-cart" data-product-id="1" data-product-name="Baby Pink Indigo Floral Pleated Anarkali." data-product-price="3780">Add to Cart</button>
                 </div>
                 <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Perks Section (Added based on screenshot) -->
    <section class="perks-section">
        <div class="perk-item">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
            <div class="perk-text">
                <strong>5,000+ 5-STARS</strong>
                <span>REVIEWS</span>
            </div>
        </div>
        <div class="perk-item">
            <i class="fa-solid fa-truck-fast"></i>
            <div class="perk-text">
                <strong>EXPRESS SHIPPING</strong>
                <span>AVAILABLE</span>
            </div>
        </div>
        <div class="perk-item">
            <i class="fa-solid fa-box-open"></i>
            <div class="perk-text">
                <strong>SATISFACTION</strong>
                <span>GUARANTEED</span>
            </div>
        </div>
        <div class="perk-item">
            <i class="fa-solid fa-headset"></i>
            <div class="perk-text">
                <strong>FAST CUSTOMER</strong>
                <span>SUPPORT</span>
            </div>
        </div>
    </section>

    <!-- 4. Best Seller Section -->
    <section class="bestseller-section">
        <h2 class="section-title">Best Seller</h2>
        <div class="product-grid">
            <?php foreach ($bestSellers as $index => $product): 
                // Override images for the first three Best Sellers as requested
                $displayImage = htmlspecialchars($product['image_url']);
                if ($index === 0) $displayImage = 'assets/images/nc1.jpg';
                if ($index === 1) $displayImage = 'assets/images/nc2.jpg';
                if ($index === 2) $displayImage = 'assets/images/nc4.jpg';
            ?>
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="<?= $displayImage ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <h4><?= htmlspecialchars($product['name']) ?></h4>
                <span class="price">Rs. <?= number_format($product['price'], 2) ?></span>
                <button class="btn-add-cart" 
                        data-product-id="<?= $product['id'] ?>" 
                        data-product-name="<?= htmlspecialchars($product['name']) ?>" 
                        data-product-price="<?= $product['price'] ?>">
                    Add to Cart
                </button>
            </div>
            <?php endforeach; ?>

            <?php if (empty($bestSellers)): ?>
            <!-- Fallback items if no best sellers found -->
            <div class="product-card">
                <div class="img-wrapper">
                    <img src="assets/images/nc5.jpg" alt="Best Seller 5">
                </div>
                <h4>Elegant Green Anarkali</h4>
                <span class="price">Rs. 5,200.00</span>
                <button class="btn-add-cart" data-product-id="5" data-product-name="Elegant Green Anarkali" data-product-price="5200">Add to Cart</button>
            </div>
            <?php endif; ?>
        </div>
    </section>
        </div>
    </section>

    <!-- 5. Testimonials (Static based on screenshot) -->
    <section class="testimonials-section">
        <h2 class="section-title">HEAR WHY OUR CUSTOMERS LOVE US</h2>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <h3>Perfect for me</h3>
                <p>"I bought the Cami Dress, and it's one of my favorite summer tops! It's comfortable, stylish, and looks great on me!"</p>
                <span class="author">Jessica K.</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <h3>Great quality!</h3>
                <p>"I paired it with the matching skirt and received so many compliments! The shoulder pads are subtle and flattering."</p>
                <span class="author">Sarah L.</span>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <h3>I love the look of it!</h3>
                <p>"Im love with it I had the Wallet and one day looking on Amazon I saw the matching purse i had to but it and is the perfect size."</p>
                <span class="author">Olivia T.</span>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
