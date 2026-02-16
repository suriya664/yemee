<?php
// public/contact.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<main>
    <section class="contact-hero">
        <div class="contact-hero-content">
            <h1 class="section-title">Contact Us</h1>
            <p>We'd love to hear from you. Get in touch with us for any queries or customized orders.</p>
        </div>
    </section>

    <section class="contact-container">
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success'): ?>
                <div class="status-message success" style="background: #e7faf3; color: #0d5a44; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #b7ebde; text-align: center;">
                    Your message has been sent successfully. We will get back to you soon!
                </div>
            <?php elseif ($_GET['status'] == 'error'): ?>
                <div class="status-message error" style="background: #fff1f0; color: #a8071a; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ffa39e; text-align: center;">
                    Oops! Something went wrong. Please try again later or contact us directly.
                </div>
            <?php elseif ($_GET['status'] == 'smtp_error'): ?>
                <div class="status-message warning" style="background: #fffbe6; color: #856404; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ffe58f; text-align: center;">
                    <strong>Local SMTP Error:</strong> Real email sending requires XAMPP configuration. <br>
                    Please follow the <strong>XAMPP SMTP Setup</strong> guide in the project walkthrough to enable Gmail sending.
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <strong>Our Studio</strong>
                        <p>73C, Karuneegar Street, Adambakkam,<br>Chennai, Tamil Nadu 600088</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <strong>Call Us</strong>
                        <p>098844 02027</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <strong>Email Us</strong>
                        <p>admin@yamee.co.in</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fa-solid fa-clock"></i>
                    <div>
                        <strong>Working Hours</strong>
                        <p>Mon - Sat: 10:00 AM - 7:00 PM</p>
                    </div>
                </div>

                <div class="social-links-contact">
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <h3>Send Us a Message</h3>
                <form action="contact_process.php" method="POST" class="premium-form">
                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="mobile" name="mobile" placeholder="Your Mobile Number" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="map-placeholder">
            <i class="fa-solid fa-map-location-dot"></i>
            <p>Map Integration Coming Soon</p>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
