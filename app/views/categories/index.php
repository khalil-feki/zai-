<?php require_once 'app/views/containers/header.php'; ?>

<section class="categories-hero">
    <div class="container">
        <div class="hero-content fade-in-up">
            <h1>Explorez Nos <span>Catégories</span></h1>
            <p>Découvrez des produits incroyables organisés par catégories</p>
        </div>
    </div>
</section>

<section class="main-content">
    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error fade-in-up">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="content-layout">
            <!-- Left sidebar with categories -->
            <div class="category-sidebar">
                <h2>Parcourir les Catégories</h2>
                <div class="category-menu">
                    <?php if (!empty($categories)): ?>
                        <?php 
                        // Define unique visual elements for each category
                        $categoryVisuals = [
                            'Électronique' => ['icon' => 'fas fa-laptop', 'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'color' => '#667eea'],
                            'Vêtements' => ['icon' => 'fas fa-tshirt', 'gradient' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', 'color' => '#f093fb'],
                            'Maison' => ['icon' => 'fas fa-home', 'gradient' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'color' => '#4facfe'],
                            'Sport' => ['icon' => 'fas fa-dumbbell', 'gradient' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'color' => '#43e97b'],
                            'Beauté' => ['icon' => 'fas fa-heart', 'gradient' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)', 'color' => '#fa709a'],
                            'Livres' => ['icon' => 'fas fa-book', 'gradient' => 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)', 'color' => '#a8edea'],
                            'Jouets' => ['icon' => 'fas fa-gamepad', 'gradient' => 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)', 'color' => '#ffecd2'],
                            'Automobile' => ['icon' => 'fas fa-car', 'gradient' => 'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)', 'color' => '#a18cd1'],
                            'Jardin' => ['icon' => 'fas fa-leaf', 'gradient' => 'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)', 'color' => '#84fab0'],
                            'Alimentation' => ['icon' => 'fas fa-utensils', 'gradient' => 'linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%)', 'color' => '#fad0c4']
                        ];
                        
                        foreach ($categories as $index => $category): 
                            // Get category visual based on label or use default
                            $categoryLabel = $category['label'];
                            $visual = null;
                            
                            // Try to match category label with predefined visuals
                            foreach ($categoryVisuals as $key => $value) {
                                if (stripos($categoryLabel, $key) !== false) {
                                    $visual = $value;
                                    break;
                                }
                            }
                            
                            // If no match found, use a default based on index
                            if (!$visual) {
                                $defaultVisuals = array_values($categoryVisuals);
                                $visual = $defaultVisuals[$index % count($defaultVisuals)];
                            }
                        ?>
                            <div class="sidebar-category-item fade-in-up stagger-item" data-category-id="<?= $category['rowid']; ?>">
                                <div class="sidebar-category-icon" style="background: <?= $visual['gradient']; ?>">
                                    <i class="<?= $visual['icon']; ?>" style="color: white;"></i>
                                </div>
                                <div class="sidebar-category-content">
                                    <h3><?= htmlspecialchars($category['label']); ?></h3>
                                    <a href="<?= BASE_URL; ?>category/view/<?= $category['rowid']; ?>" class="btn-text">Explorer <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <i class="fas fa-search"></i>
                            <h3>Aucune catégorie trouvée</h3>
                            <p>Veuillez revenir plus tard pour de nouvelles catégories.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right content with animated ZAI image -->
            <div class="products-content">
                <!-- ZAI Animated Section -->
                <section class="zai-showcase">
                    <div class="zai-container">
                        <div class="zai-image-wrapper">
                            <div class="zai-background-effects">
                                <div class="floating-particle"></div>
                                <div class="floating-particle"></div>
                                <div class="floating-particle"></div>
                                <div class="floating-particle"></div>
                                <div class="floating-particle"></div>
                            </div>
                            <div class="zai-image-container">
                                <img src="<?= BASE_URL ?>public/img/zai.jpg" alt="ZAI" class="zai-main-image">
                                <div class="zai-glow-effect"></div>
                                <div class="zai-pulse-ring"></div>
                                <div class="zai-pulse-ring pulse-delay-1"></div>
                                <div class="zai-pulse-ring pulse-delay-2"></div>
                            </div>
                            <div class="zai-text-overlay">
                                <h2 class="zai-title">ZAI</h2>
                                <p class="zai-subtitle">Innovation & Excellence</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<style>
/* Modern Categories Page Styling */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    --card-shadow-hover: 0 16px 48px rgba(0, 0, 0, 0.15);
    --border-radius-lg: 20px;
    --border-radius-md: 15px;
    --border-radius-sm: 10px;
    --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    --glass-bg: rgba(255, 255, 255, 0.95);
    --backdrop-blur: blur(10px);
    --zai-primary: #667eea;
    --zai-secondary: #764ba2;
    --zai-accent: #4facfe;
}

/* ZAI Showcase Section */
.zai-showcase {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    position: relative;
   
}

.zai-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.zai-image-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
}

.zai-background-effects {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.floating-particle {
    position: absolute;
    width: 8px;
    height: 8px;
    background: var(--zai-primary);
    border-radius: 50%;
    opacity: 0.6;
    animation: floatParticle 6s infinite ease-in-out;
}

.floating-particle:nth-child(1) {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
    background: var(--zai-primary);
}

.floating-particle:nth-child(2) {
    top: 60%;
    left: 80%;
    animation-delay: 1.2s;
    background: var(--zai-secondary);
}

.floating-particle:nth-child(3) {
    top: 30%;
    left: 70%;
    animation-delay: 2.4s;
    background: var(--zai-accent);
}

.floating-particle:nth-child(4) {
    top: 80%;
    left: 20%;
    animation-delay: 3.6s;
    background: var(--zai-primary);
}

.floating-particle:nth-child(5) {
    top: 10%;
    left: 50%;
    animation-delay: 4.8s;
    background: var(--zai-secondary);
}

@keyframes floatParticle {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 1;
    }
}

.zai-image-container {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
}

.zai-main-image {
    max-width: 400px;
    width: 100%;
    height: auto;
    border-radius: var(--border-radius-lg);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    animation: zaiFloat 4s ease-in-out infinite, zaiGlow 3s ease-in-out infinite alternate;
    transition: var(--transition-smooth);
    position: relative;
    z-index: 3;
}

.zai-main-image:hover {
    transform: scale(1.05) rotateY(5deg);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
}

@keyframes zaiFloat {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-15px);
    }
}

@keyframes zaiGlow {
    0% {
        filter: brightness(1) saturate(1);
    }
    100% {
        filter: brightness(1.1) saturate(1.2);
    }
}

.zai-glow-effect {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 120%;
    height: 120%;
    background: radial-gradient(circle, var(--zai-primary) 0%, transparent 70%);
    transform: translate(-50%, -50%);
    opacity: 0.3;
    animation: glowPulse 3s ease-in-out infinite;
    z-index: 1;
    border-radius: 50%;
}

@keyframes glowPulse {
    0%, 100% {
        opacity: 0.3;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.6;
        transform: translate(-50%, -50%) scale(1.1);
    }
}

.zai-pulse-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    border: 3px solid var(--zai-primary);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: pulseRing 2s ease-out infinite;
    z-index: 2;
}

.zai-pulse-ring.pulse-delay-1 {
    animation-delay: 0.7s;
    border-color: var(--zai-secondary);
}

.zai-pulse-ring.pulse-delay-2 {
    animation-delay: 1.4s;
    border-color: var(--zai-accent);
}

@keyframes pulseRing {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(2);
        opacity: 0;
    }
}

.zai-text-overlay {
    position: absolute;
    bottom: -80px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 4;
    animation: textSlideUp 1s ease-out 0.5s both;
}

.zai-title {
    font-size: 3rem;
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    animation: titlePulse 2s ease-in-out infinite;
}

.zai-subtitle {
    font-size: 1.2rem;
    color: var(--zai-secondary);
    margin: 10px 0 0 0;
    opacity: 0.8;
    font-weight: 500;
    letter-spacing: 2px;
    text-transform: uppercase;
}

@keyframes textSlideUp {
    0% {
        opacity: 0;
        transform: translateX(-50%) translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

@keyframes titlePulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .zai-main-image {
        max-width: 300px;
    }
    
    .zai-title {
        font-size: 2.5rem;
    }
    
    .zai-subtitle {
        font-size: 1rem;
    }
    
    .zai-image-wrapper {
        min-height: 400px;
    }
}

@media (max-width: 480px) {
    .zai-main-image {
        max-width: 250px;
    }
    
    .zai-title {
        font-size: 2rem;
    }
    
    .zai-subtitle {
        font-size: 0.9rem;
    }
}

/* Main content layout */
.main-content {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    position: relative;
}

.main-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    pointer-events: none;
}

.content-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 40px;
    align-items: start;
}

/* Enhanced Category Sidebar */
.category-sidebar {
    background: var(--glass-bg);
    backdrop-filter: var(--backdrop-blur);
    border-radius: var(--border-radius-lg);
    box-shadow: var(--card-shadow);
    padding: 30px;
    position: sticky;
    top: 100px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition-smooth);
}

.category-sidebar:hover {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-5px);
}

.category-sidebar h2 {
    font-size: 1.8rem;
    margin-bottom: 25px;
    color: var(--text-color);
    position: relative;
    padding-bottom: 15px;
    font-weight: 700;
}

.category-sidebar h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--primary-gradient);
    border-radius: 2px;
}

.category-menu {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.sidebar-category-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: var(--border-radius-md);
    transition: var(--transition-smooth);
    cursor: pointer;
    background: rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.sidebar-category-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    transition: left 0.3s ease;
    z-index: -1;
}

.sidebar-category-item:hover {
    transform: translateX(8px) scale(1.02);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: white;
}

.sidebar-category-item:hover::before {
    left: 0;
}

.sidebar-category-item:hover .sidebar-category-content h3,
.sidebar-category-item:hover .btn-text {
    color: white;
}

.sidebar-category-icon {
    width: 55px;
    height: 55px;
    border-radius: var(--border-radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    position: relative;
    overflow: hidden;
    transition: var(--transition-smooth);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.sidebar-category-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.sidebar-category-icon:hover::before {
    opacity: 1;
}

.sidebar-category-icon i {
    font-size: 24px;
    z-index: 2;
    transition: transform 0.3s ease;
}

.sidebar-category-item:hover .sidebar-category-icon {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.sidebar-category-item:hover .sidebar-category-icon i {
    transform: scale(1.1);
}

/* Removed old image-based category styles - now using icons */

.sidebar-category-content {
    flex: 1;
}

.sidebar-category-content h3 {
    margin: 0 0 8px;
    font-size: 1.15rem;
    font-weight: 600;
    transition: var(--transition-smooth);
}

/* Enhanced Products Content */
.products-content {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.featured-products, .trending-products {
    background: var(--glass-bg);
    backdrop-filter: var(--backdrop-blur);
    border-radius: var(--border-radius-lg);
    box-shadow: var(--card-shadow);
    padding: 35px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition-smooth);
}

.featured-products:hover, .trending-products:hover {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-3px);
}

/* Enhanced Grid Layouts */
.products-slider {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.trending-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .content-layout {
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }
}

@media (max-width: 992px) {
    .content-layout {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .category-sidebar {
        position: static;
        margin-bottom: 0;
    }
    
    .main-content {
        padding: 40px 0;
    }
}

@media (max-width: 768px) {
    .products-slider {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .trending-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .featured-products, .trending-products {
        padding: 25px;
    }
    
    .category-sidebar {
        padding: 25px;
    }
}

@media (max-width: 576px) {
    .products-slider {
        grid-template-columns: 1fr;
    }
    
    .main-content {
        padding: 30px 0;
    }
    
    .content-layout {
        gap: 20px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            
            // Add animation effect
            this.classList.add('adding');
            
            // AJAX request to add product to cart
            fetch(BASE_URL + 'cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'product_id=' + productId + '&quantity=1'
            })
            .then(response => response.json())
            .then(data => {
                setTimeout(() => {
                    this.classList.remove('adding');
                    if (data.success) {
                        this.classList.add('added');
                        setTimeout(() => {
                            this.classList.remove('added');
                        }, 1500);
                        
                        // Update cart count if needed
                        updateCartCount(data.cartCount || 1);
                    } else {
                        alert(data.message || 'Failed to add product to cart');
                    }
                }, 800);
            })
            .catch(error => {
                console.error('Error:', error);
                this.classList.remove('adding');
                alert('An error occurred. Please try again.');
            });
        });
    });
    
    // Category item hover effects
    const categoryItems = document.querySelectorAll('.sidebar-category-item');
    categoryItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.classList.add('hover');
        });
        
        item.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });
    
    function updateCartCount(count) {
        const cartBadge = document.querySelector('.cart-badge');
        if (cartBadge) {
            cartBadge.textContent = count;
            cartBadge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }
});
</script>

<style>
/* Enhanced Hero Section */
.categories-hero {
    background: var(--primary-gradient);
    padding: 100px 0;
    text-align: center;
    margin-bottom: 0;
    position: relative;
    overflow: hidden;
    clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
}

.categories-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>') repeat;
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.hero-content {
    position: relative;
    z-index: 2;
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.categories-hero h1 {
    color: white;
    font-size: 3.5rem;
    margin-bottom: 20px;
    font-weight: 800;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    letter-spacing: -1px;
}

.categories-hero h1 span {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

.categories-hero h1 span::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    border-radius: 2px;
    animation: shimmer 2s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.categories-hero p {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.3rem;
    max-width: 700px;
    margin: 0 auto;
    font-weight: 300;
    line-height: 1.6;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

/* Enhanced Button Styles */
.btn-text {
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: var(--transition-smooth);
    padding: 8px 16px;
    border-radius: 25px;
    background: rgba(74, 108, 247, 0.1);
    border: 1px solid rgba(74, 108, 247, 0.2);
}

.btn-text i {
    margin-left: 8px;
    transition: var(--transition-smooth);
}

.btn-text:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(74, 108, 247, 0.3);
}

.btn-text:hover i {
    transform: translateX(5px);
}

/* Enhanced Section Titles */
.section-title {
    text-align: center;
    margin-bottom: 50px;
    position: relative;
}

.section-title h2 {
    font-size: 2.8rem;
    color: var(--text-color);
    margin-bottom: 20px;
    font-weight: 800;
    letter-spacing: -1px;
    position: relative;
}

.section-title h2 span {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

.section-title h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--primary-gradient);
    border-radius: 2px;
}

.section-title p {
    color: var(--secondary-color);
    font-size: 1.2rem;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.7;
    font-weight: 300;
}

/* Enhanced Product Cards */
.product-card {
    background: var(--glass-bg);
    backdrop-filter: var(--backdrop-blur);
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: var(--transition-smooth);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.product-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: var(--card-shadow-hover);
}

.product-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: var(--primary-gradient);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    z-index: 3;
    box-shadow: 0 4px 15px rgba(74, 108, 247, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-image-container {
    height: 240px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: var(--transition-smooth);
    padding: 20px;
}

.product-card:hover .product-image-container img {
    transform: scale(1.1) rotate(2deg);
}

.product-actions {
    position: absolute;
    bottom: -60px;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 15px;
    padding: 15px;
    background: linear-gradient(to top, rgba(255, 255, 255, 0.95), transparent);
    backdrop-filter: var(--backdrop-blur);
    transition: var(--transition-smooth);
}

.product-card:hover .product-actions {
    bottom: 0;
}

.action-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-color);
    border: 2px solid rgba(255, 255, 255, 0.8);
    cursor: pointer;
    transition: var(--transition-smooth);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    transition: left 0.3s ease;
    z-index: -1;
}

.action-btn:hover {
    color: white;
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 25px rgba(74, 108, 247, 0.4);
}

.action-btn:hover::before {
    left: 0;
}

.action-btn.adding {
    animation: pulse 0.8s ease;
}

.action-btn.added {
    background: var(--success-color);
    color: white;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.product-info {
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
}

.product-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0 0 12px;
    color: var(--text-color);
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-size: 1.4rem;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
}

.product-rating {
    display: flex;
    align-items: center;
    color: #ffc107;
    font-size: 1rem;
    gap: 2px;
}

.product-rating span {
    color: var(--secondary-color);
    margin-left: 8px;
    font-weight: 600;
}

/* Enhanced Trending Cards */
.trending-card {
    display: flex;
    background: var(--glass-bg);
    backdrop-filter: var(--backdrop-blur);
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: var(--transition-smooth);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
}

.trending-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    opacity: 0;
    transition: var(--transition-smooth);
    z-index: 1;
}

.trending-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: var(--card-shadow-hover);
}

.trending-card:hover::before {
    opacity: 0.05;
}

.trending-image {
    width: 45%;
    overflow: hidden;
    position: relative;
    z-index: 2;
}

.trending-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-smooth);
}

.trending-card:hover .trending-image img {
    transform: scale(1.15) rotate(2deg);
}

.trending-content {
    width: 55%;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.trending-content h3 {
    margin: 0 0 15px;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-color);
    line-height: 1.3;
}

.trending-price {
    font-size: 1.5rem;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 30px;
    font-weight: 700;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: var(--transition-smooth);
    box-shadow: 0 6px 20px rgba(74, 108, 247, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 30px rgba(74, 108, 247, 0.5);
}

.btn-primary:hover::before {
    left: 100%;
}

/* Enhanced No Results */
.no-results {
    text-align: center;
    padding: 80px 40px;
    color: var(--secondary-color);
    background: var(--glass-bg);
    backdrop-filter: var(--backdrop-blur);
    border-radius: var(--border-radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.no-results i {
    font-size: 4rem;
    margin-bottom: 25px;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    opacity: 0.8;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.no-results h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: var(--text-color);
    font-weight: 700;
}

.no-results p {
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Enhanced Responsive Design */
@media (max-width: 992px) {
    .categories-hero {
        padding: 80px 0;
        clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
    }
    
    .categories-hero h1 {
        font-size: 2.8rem;
    }
    
    .section-title h2 {
        font-size: 2.2rem;
    }
    
    .trending-card {
        flex-direction: column;
    }
    
    .trending-image, .trending-content {
        width: 100%;
    }
    
    .trending-image {
        height: 220px;
    }
}

@media (max-width: 768px) {
    .categories-hero {
        padding: 60px 0;
    }
    
    .categories-hero h1 {
        font-size: 2.2rem;
    }
    
    .section-title h2 {
        font-size: 1.8rem;
    }
    
    .product-info {
        padding: 20px;
    }
    
    .trending-content {
        padding: 25px;
    }
}

@media (max-width: 576px) {
    .categories-hero h1 {
        font-size: 1.8rem;
    }
    
    .categories-hero p {
        font-size: 1.1rem;
    }
    
    .section-title h2 {
        font-size: 1.6rem;
    }
    
    .product-badge {
        top: 15px;
        left: 15px;
        padding: 6px 12px;
        font-size: 0.75rem;
    }
}
</style>

<?php require_once 'app/views/containers/footer.php'; ?>