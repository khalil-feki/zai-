</main>
    <footer class="modern-footer">
        <!-- SVG wave removed -->
        
        <div class="footer-content">
            <div class="footer-section about">
                <div class="logo-container">
                    <img src="<?= BASE_URL ?>public/img/logo.jpeg" alt="<?= SITE_NAME ?> Logo" class="footer-logo">
                </div>
                <p class="footer-description">Your trusted online shopping destination for premium products at competitive prices.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-section links">
                <h3>Quick Links</h3>
                <div class="footer-links">
                    <ul>
                        <li><a href="<?= BASE_URL ?>"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="<?= BASE_URL ?>products"><i class="fas fa-chevron-right"></i> Products</a></li>
                        <li><a href="<?= BASE_URL ?>products/new"><i class="fas fa-chevron-right"></i> New Arrivals</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?= BASE_URL ?>products/bestsellers"><i class="fas fa-chevron-right"></i> Best Sellers</a></li>
                        <li><a href="<?= BASE_URL ?>about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="<?= BASE_URL ?>contact"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-section newsletter">
                <h3>Newsletter</h3>
                <p>Subscribe to our newsletter for a weekly dose of news, updates, helpful tips, and exclusive offers.</p>
                <form class="newsletter-form" action="<?= BASE_URL ?>newsletter/subscribe" method="post">
                    <div class="newsletter-input-group">
                        <input type="email" name="email" placeholder="Your email" required>
                        <button type="submit" class="newsletter-btn">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="<?= BASE_URL ?>privacy-policy">Privacy Policy</a>
                    <a href="<?= BASE_URL ?>terms-of-service">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>public/js/cart.js"></script>
    <script src="<?= BASE_URL ?>public/js/header.js"></script>
    <!-- Make sure the footer CSS is properly loaded -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/footer.css">
</body>
</html>