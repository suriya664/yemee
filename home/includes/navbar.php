<?php
// includes/navbar.php

// Fetch main navigation items (parent_id is NULL)
$stmt = $pdo->query("SELECT * FROM navigation WHERE parent_id IS NULL ORDER BY sort_order ASC");
$navItems = $stmt->fetchAll();

function getSubmenu($pdo, $parentId) {
    $stmt = $pdo->prepare("SELECT * FROM navigation WHERE parent_id = ? ORDER BY sort_order ASC");
    $stmt->execute([$parentId]);
    return $stmt->fetchAll();
}
// Helper to format URLs for the router
function formatUrl($url) {
    // If it's an absolute path string from DB (e.g., /women), convert to products.php routing
    if (strpos($url, '/') === 0) {
        $slug = trim($url, '/');
        return "products.php?category=" . urlencode($slug);
    }
    return htmlspecialchars($url);
}
?>

<div class="nav-overlay" id="nav-overlay"></div>
<nav class="main-navbar" id="main-navbar">
    <div class="mobile-nav-header mobile-only">
        <div class="mobile-logo">
            <img src="assets/images/logo/logo.png" alt="Mesmaa Logo" class="mobile-sidebar-logo">
        </div>
        <div class="close-menu" id="mobile-menu-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <ul class="nav-links">
        <?php foreach ($navItems as $item): ?>
            <?php 
                $subItems = getSubmenu($pdo, $item['id']);
                $hasSub = count($subItems) > 0;
                $link = formatUrl($item['url']);
            ?>
            <li class="<?= $hasSub ? 'has-dropdown' : '' ?>">
                <a href="<?= $link ?>">
                    <?= htmlspecialchars($item['label']) ?>
                    <?php if ($hasSub): ?> <i class="fa-solid fa-chevron-down dropdown-icon"></i><?php endif; ?>
                </a>
                
                <?php if ($hasSub): ?>
                    <ul class="dropdown">
                        <?php foreach ($subItems as $sub): ?>
                            <li><a href="<?= formatUrl($sub['url']) ?>"><?= htmlspecialchars($sub['label']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        <li class="mobile-only mobile-extra-links">
            <a href="#"><i class="fa-solid fa-user"></i> Account</a>
        </li>
    </ul>
</nav>

<!-- Promotional Banner (Blue Strip) -->
<div class="promo-bar">
    <div class="promo-content">
        <span>Personalize Customization Available</span>
        <span class="dot">•</span>
        <span>We Provide Express Shipping</span>
        <span class="dot">•</span>
        <span>500+ ★★★★★ REVIEWS</span>
    </div>
</div>
