<?php
// includes/footer.php
?>

<!-- Refer A Friend Section -->
<section class="refer-friend-section">
    <h2>Refer A Friend :</h2>
    <a href="#" class="btn-primary-solid">Get Reward Points</a>
</section>

<!-- Main Footer -->
<footer class="main-footer">
    <div class="footer-container">
        <!-- Footer Logo -->
        <div class="footer-logo-section">
            <a href="index.php">
                <img src="assets/images/logo/logo.png" alt="Mesmaa Logo" class="footer-logo">
            </a>
        </div>

        <!-- Column 1: Gift Card -->
        <div class="footer-col gift-card-col">
            <h3>Style Wrapped In A Gift Card</h3>
            <p>Delight your loved ones with a Mesmaa gift card and let them pick their favorite designs. The perfect gift for any occasion!</p>
            <a href="#" class="btn-white-outline">Buy a gift card</a>
        </div>

        <!-- Column 2: Links -->
        <div class="footer-col links-col">
            <h3>LINKS</h3>
            <ul>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM footer_links WHERE column_name = 'Links'");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    $link = htmlspecialchars($row['link']);
                    echo '<li><a href="' . $link . '">' . htmlspecialchars($row['title']) . '</a></li>';
                }
                ?>
            </ul>
        </div>

        <!-- Column 3: Connect -->
        <div class="footer-col connect-col">
            <h3>CONNECT</h3>
            <ul>
                <li><a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i> Youtube</a></li>
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i> Facebook</a></li>
            </ul>
        </div>

        <!-- Column 4: Address -->
        <div class="footer-col address-col">
            <h3>ADDRESS</h3>
            <ul>
                <li><i class="fa-solid fa-location-dot"></i> 73C, Karuneegar Street, <br>Adambakkam, Chennai, Tamil Nadu 600088</li>
            </ul>
        </div>
    </div>
    
    <!-- Chat Widget Bubble (HTML representation) -->
    <div class="chat-help-widget">
        <span>Need Help? Chat with us</span>
        <div class="footer-contact-icons">
            <a href="contact.php" title="Contact Us"><i class="fa-solid fa-phone"></i></a>
            <a href="contact.php" title="Contact Us"><i class="fa-solid fa-envelope"></i></a>
        </div>
    </div>
</footer>

<script src="script.js"></script>
</body>
</html>
