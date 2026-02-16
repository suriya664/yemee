// public/script.js

document.addEventListener('DOMContentLoaded', () => {
    // Hero Slider Logic
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.dot');
    const nextBtn = document.querySelector('.next-slide');
    const prevBtn = document.querySelector('.prev-slide');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        // Remove active classes
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Wrap around logic
        if (index >= slides.length) currentSlide = 0;
        else if (index < 0) currentSlide = slides.length - 1;
        else currentSlide = index;

        // Add active class to current slide and dot
        slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) dots[currentSlide].classList.add('active');

        // Reset and restart interval
        resetTimer();
    }

    function resetTimer() {
        clearInterval(slideInterval);
        slideInterval = setInterval(() => {
            showSlide(currentSlide + 1);
        }, 8000); // 8 seconds for slower, premium feel
    }

    // Event Listeners for buttons
    if (nextBtn && prevBtn) {
        nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
        prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
    }

    // Event Listeners for dots
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.getAttribute('data-index'));
            showSlide(index);
        });
    });

    // Initialize the first timer
    if (slides.length > 0) {
        resetTimer();
    }

    // ===================================
    // CART FUNCTIONALITY
    // ===================================

    // Add to Cart buttons
    const addToCartBtns = document.querySelectorAll('.btn-add-cart');
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            addToCart(productId);
        });
    });

    // Cart page quantity controls
    const qtyIncreaseBtns = document.querySelectorAll('.qty-increase');
    const qtyDecreaseBtns = document.querySelectorAll('.qty-decrease');
    const qtyInputs = document.querySelectorAll('.qty-input');
    const removeBtns = document.querySelectorAll('.remove-btn');

    qtyIncreaseBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
            const newQty = parseInt(input.value) + 1;
            input.value = newQty;
            updateCartQuantity(productId, newQty);
        });
    });

    qtyDecreaseBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
            const newQty = Math.max(1, parseInt(input.value) - 1);
            input.value = newQty;
            updateCartQuantity(productId, newQty);
        });
    });

    qtyInputs.forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.getAttribute('data-product-id');
            const newQty = Math.max(1, parseInt(this.value));
            this.value = newQty;
            updateCartQuantity(productId, newQty);
        });
    });

    removeBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            removeFromCart(productId);
        });
    });

    // AJAX Functions
    function addToCart(productId) {
        const btn = document.querySelector(`.btn-add-cart[data-product-id="${productId}"]`);
        const originalText = btn ? btn.innerText : 'Add to Cart';

        if (btn) {
            btn.classList.add('adding');
            btn.innerText = 'Adding...';
        }

        fetch('cart_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=add&product_id=${productId}&quantity=1`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    showNotification('Product added to cart!', 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to add to cart', 'error');
            })
            .finally(() => {
                if (btn) {
                    btn.classList.remove('adding');
                    btn.innerText = originalText;
                }
            });
    }

    function updateCartQuantity(productId, quantity) {
        fetch('cart_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=update&product_id=${productId}&quantity=${quantity}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    updateCartTotal(data.cart_total);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function removeFromCart(productId) {
        if (confirm('Remove this item from cart?')) {
            fetch('cart_ajax.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=remove&product_id=${productId}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove row from table
                        const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                        if (row) row.remove();

                        updateCartCount(data.cart_count);
                        updateCartTotal(data.cart_total);

                        // Check if cart is empty
                        const remainingRows = document.querySelectorAll('.cart-table tbody tr');
                        if (remainingRows.length === 0) {
                            location.reload(); // Reload to show empty cart message
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function updateCartCount(count) {
        const cartCountEl = document.querySelector('.cart-count');
        if (cartCountEl) {
            cartCountEl.textContent = count;
        }
    }

    function updateCartTotal(total) {
        const cartTotalEls = document.querySelectorAll('.cart-total, .cart-subtotal');
        cartTotalEls.forEach(el => {
            el.textContent = 'Rs. ' + total;
        });
    }

    function showNotification(message, type = 'success') {
        // Remove existing notification
        const existing = document.querySelector('.cart-notification');
        if (existing) existing.remove();

        // Create notification
        const notification = document.createElement('div');
        notification.className = `cart-notification ${type}`;
        notification.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(notification);

        // Show notification
        setTimeout(() => notification.classList.add('show'), 10);

        // Hide and remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    // ===================================
    // SCROLL ANIMATIONS (Intersection Observer)
    // ===================================
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                // Once animated, no need to observe anymore
                animationObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1, // Trigger when 10% of element is visible
        rootMargin: '0px 0px -50px 0px' // Slightly delayed for better feel
    });

    // Elements to observe
    const elementsToAnimate = document.querySelectorAll(
        '.category-item, .product-card, .testimonial-card, .perk-item'
    );

    elementsToAnimate.forEach(el => {
        animationObserver.observe(el);
    });

    // Handle elements already in view on load
    setTimeout(() => {
        elementsToAnimate.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.classList.add('animate-in');
                animationObserver.unobserve(el);
            }
        });
    }, 100);
    // ===================================
    // MOBILE MENU LOGIC
    // ===================================
    const menuOpenBtn = document.getElementById('mobile-menu-open');
    const menuCloseBtn = document.getElementById('mobile-menu-close');
    const navbar = document.getElementById('main-navbar');
    const overlay = document.getElementById('nav-overlay');

    if (menuOpenBtn && navbar && overlay) {
        menuOpenBtn.addEventListener('click', () => {
            navbar.classList.add('mobile-active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        });

        const closeMenu = () => {
            navbar.classList.remove('mobile-active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (menuCloseBtn) menuCloseBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMenu();
        });
    }

    // Dropdown toggle on mobile
    const dropdownToggles = document.querySelectorAll('.has-dropdown > a');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('dropdown-open');
            }
        });
    });
});
