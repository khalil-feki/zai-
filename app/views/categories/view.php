<?php require_once 'app/views/containers/header.php'; ?>

<!-- Modern Categories Hero Section -->
<div class="categories-hero">
    <div class="hero-background">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
    </div>
    <div class="container">
        <div class="hero-content">
            <nav aria-label="breadcrumb" class="modern-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL; ?>category">Categories</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($currentCategory['label']); ?></li>
                </ol>
            </nav>
            <h1 class="hero-title"><?= htmlspecialchars($currentCategory['label']); ?></h1>
            <?php if (!empty($currentCategory['description'])): ?>
                <p class="hero-description"><?= htmlspecialchars($currentCategory['description']); ?></p>
            <?php endif; ?>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($products); ?></span>
                    <span class="stat-label">Products Available</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Categories Layout -->
<div class="modern-categories-container">
    <div class="container">
        <div class="categories-layout">
            <!-- Floating Sidebar -->
            <div class="floating-sidebar">
                <div class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-filter"></i>
                    <span>Filters</span>
                </div>
                
                <div class="sidebar-content" id="sidebarContent">
                    <!-- Categories Navigation -->
                    <div class="modern-card categories-card">
                        <div class="card-header">
                            <h5><i class="fas fa-th-large"></i> Categories</h5>
                        </div>
                        <div class="categories-list">
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <a href="<?= BASE_URL; ?>category/view/<?= $category['rowid']; ?>" 
                                       class="category-item <?= ($category['rowid'] == $currentCategory['rowid']) ? 'active' : ''; ?>">
                                        <span class="category-name"><?= htmlspecialchars($category['label']); ?></span>
                                        <span class="category-count"><?= $category['product_count'] ?? 0; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="no-categories">No categories available</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Advanced Filters -->
                    <div class="modern-card filters-card">
                        <div class="card-header">
                            <h5><i class="fas fa-sliders-h"></i> Advanced Filters</h5>
                        </div>
                        <form action="<?= BASE_URL; ?>category/view/<?= $currentCategory['rowid']; ?>" method="GET" id="filter-form" class="modern-form">
                            <div class="form-group">
                                <label for="search" class="form-label">
                                    <i class="fas fa-search"></i> Search Products
                                </label>
                                <input type="text" class="modern-input" id="search" name="search" 
                                       value="<?= htmlspecialchars($search ?? ''); ?>" placeholder="What are you looking for?">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-euro-sign"></i> Price Range
                                </label>
                                <div class="price-range-inputs">
                                    <input type="number" class="modern-input" id="min_price" name="min_price" 
                                           value="<?= $minPrice ?? ''; ?>" placeholder="Min €" min="0" step="0.01">
                                    <span class="range-separator">to</span>
                                    <input type="number" class="modern-input" id="max_price" name="max_price" 
                                           value="<?= $maxPrice ?? ''; ?>" placeholder="Max €" min="0" step="0.01">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="sort" class="form-label">
                                    <i class="fas fa-sort"></i> Sort By
                                </label>
                                <select class="modern-select" id="sort" name="sort">
                                    <option value="newest" <?= ($sort === 'newest') ? 'selected' : ''; ?>>✨ Newest First</option>
                                    <option value="price_asc" <?= ($sort === 'price_asc') ? 'selected' : ''; ?>>💰 Price: Low to High</option>
                                    <option value="price_desc" <?= ($sort === 'price_desc') ? 'selected' : ''; ?>>💎 Price: High to Low</option>
                                    <option value="name_asc" <?= ($sort === 'name_asc') ? 'selected' : ''; ?>>🔤 Name: A to Z</option>
                                    <option value="name_desc" <?= ($sort === 'name_desc') ? 'selected' : ''; ?>>🔤 Name: Z to A</option>
                                </select>
                            </div>
                            
                            <div class="filter-actions">
                                <button type="submit" class="modern-btn primary">
                                    <i class="fas fa-magic"></i> Apply Filters
                                </button>
                                <a href="<?= BASE_URL; ?>category/view/<?= $currentCategory['rowid']; ?>" class="modern-btn secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="products-main">
                <?php if (!empty($products)): ?>
                    <div class="products-grid-modern">
                        <?php foreach ($products as $index => $product): ?>
                            <div class="product-card-modern" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>" onclick="window.location.href='<?= BASE_URL; ?>product/view/<?= $product['rowid']; ?>'" style="cursor: pointer;">
                                <div class="product-image-container">
                                    <img src="<?= $product['image_url'] ?? LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE ?>" 
                                         alt="<?= htmlspecialchars($product['label']); ?>" 
                                         class="product-image" 
                                         onerror="this.src='<?= LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE ?>'">
                                    <div class="product-overlay">
                                        <a href="<?= BASE_URL; ?>product/view/<?= $product['rowid']; ?>" class="quick-view-btn">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="product-badge">
                                        <span class="badge-new">New</span>
                                    </div>
                                </div>
                                
                                <div class="product-content">
                                    <h3 class="product-title"><?= htmlspecialchars($product['label']); ?></h3>
                                    <p class="product-description">
                                        <?= !empty($product['description']) ? htmlspecialchars(substr($product['description'], 0, 80)) . '...' : 'Premium quality product with excellent features.'; ?>
                                    </p>
                                    <div class="product-price">
                                        <span class="current-price">€<?= number_format($product['price'], 2); ?></span>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <a href="<?= BASE_URL; ?>product/view/<?= $product['rowid']; ?>" class="action-btn view-btn" onclick="event.stopPropagation();">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Details</span>
                                        </a>
                                        <button class="action-btn cart-btn add-to-cart" data-product-id="<?= $product['rowid']; ?>" onclick="event.stopPropagation();">
                                            <i class="fas fa-cart-plus"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="product-glow"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-products-found">
                        <div class="no-products-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>No Products Found</h3>
                        <p>We couldn't find any products matching your criteria. Try adjusting your filters or explore other categories.</p>
                        <a href="<?= BASE_URL; ?>category/view/<?= $currentCategory['rowid']; ?>" class="modern-btn primary">
                            <i class="fas fa-refresh"></i> Reset Filters
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modern Styles -->
<style>
/* Hero Section */
.categories-hero {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    overflow: hidden;
    margin-bottom: 40px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
}

.shape-3 {
    width: 60px;
    height: 60px;
    top: 40%;
    left: 70%;
    animation-delay: 4s;
}

.shape-4 {
    width: 100px;
    height: 100px;
    top: 10%;
    right: 40%;
    animation-delay: 1s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.modern-breadcrumb .breadcrumb {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 10px 20px;
    justify-content: center;
    margin-bottom: 30px;
}

.modern-breadcrumb .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
}

.modern-breadcrumb .breadcrumb-item a:hover {
    color: white;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    background: linear-gradient(45deg, #fff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: titleGlow 2s ease-in-out infinite alternate;
}

@keyframes titleGlow {
    from { text-shadow: 0 0 20px rgba(255, 255, 255, 0.5); }
    to { text-shadow: 0 0 30px rgba(255, 255, 255, 0.8); }
}

.hero-description {
    font-size: 1.2rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Modern Layout */
.modern-categories-container {
    padding: 0 0 80px;
}

.categories-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 40px;
    position: relative;
}

/* Floating Sidebar */
.floating-sidebar {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.sidebar-toggle {
    display: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 50px;
    cursor: pointer;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.sidebar-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.sidebar-toggle i {
    margin-right: 10px;
}

.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modern-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border: none;
}

.modern-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.modern-card .card-header i {
    margin-right: 10px;
}

/* Categories List */
.categories-list {
    padding: 0;
}

.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
    position: relative;
}

.category-item:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    color: #667eea;
    transform: translateX(5px);
}

.category-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.category-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #fff;
}

.category-name {
    font-weight: 500;
}

.category-count {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.category-item.active .category-count {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Modern Form */
.modern-form {
    padding: 20px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.form-label i {
    margin-right: 8px;
    color: #667eea;
}

.modern-input, .modern-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e1e5e9;
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: white;
}

.modern-input:focus, .modern-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-1px);
}

.price-range-inputs {
    display: flex;
    align-items: center;
    gap: 10px;
}

.range-separator {
    color: #666;
    font-weight: 500;
    white-space: nowrap;
}

.filter-actions {
    display: flex;
    gap: 10px;
}

.modern-btn {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.modern-btn.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modern-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.modern-btn.secondary {
    background: #f8f9fa;
    color: #666;
    border: 2px solid #e1e5e9;
}

.modern-btn.secondary:hover {
    background: #e9ecef;
    transform: translateY(-1px);
}

/* Products Grid */
.products-main {
    min-height: 600px;
}

.products-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 40px;
    padding: 30px 0;
}

/* Product Cards */
.product-card-modern {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
    position: relative;
    cursor: pointer;
}

.product-card-modern:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
}

.product-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.4s ease;
}

.product-card-modern:hover .product-image {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.product-card-modern:hover .product-overlay {
    opacity: 1;
}

.quick-view-btn {
    background: white;
    color: #667eea;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 1.2rem;
    transform: scale(0.8);
    transition: all 0.3s ease;
}

.product-overlay:hover .quick-view-btn {
    transform: scale(1);
}

.product-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 2;
}

.badge-new {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-content {
    padding: 25px;
}

.product-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.3;
}

.product-description {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 15px;
    height: 40px;
    overflow: hidden;
}

.product-price {
    margin-bottom: 20px;
}

.current-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
}

.product-actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    flex: 1;
    padding: 16px 20px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 1rem;
    min-height: 50px;
}

.view-btn {
    background: #f8f9fa;
    color: #666;
    border: 2px solid #e1e5e9;
}

.view-btn:hover {
    background: #e9ecef;
    transform: translateY(-1px);
}

.cart-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    font-size: 1.6rem;
    font-weight: 700;
    padding: 28px 36px;
    min-height: 80px;
    flex: 2.5;
    border-radius: 16px;
}

.cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
}

.cart-btn i {
    font-size: 1.8rem;
}

.view-btn {
    flex: 1;
}

.product-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(102, 126, 234, 0.1), transparent);
    transform: rotate(45deg);
    transition: all 0.6s ease;
    opacity: 0;
}

.product-card-modern:hover .product-glow {
    opacity: 1;
    animation: glow 1.5s ease-in-out;
}

@keyframes glow {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

/* No Products Found */
.no-products-found {
    text-align: center;
    padding: 80px 20px;
    color: #666;
}

.no-products-icon {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.no-products-found h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #333;
}

.no-products-found p {
    font-size: 1.1rem;
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .categories-layout {
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }
    
    .products-grid-modern {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .categories-layout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .floating-sidebar {
        position: relative;
        top: auto;
    }
    
    .sidebar-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .sidebar-content {
        display: none;
    }
    
    .sidebar-content.active {
        display: block;
        animation: slideDown 0.3s ease;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-stats {
        gap: 20px;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .products-grid-modern {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
    
    .filter-actions {
        flex-direction: column;
    }
    
    .price-range-inputs {
        flex-direction: column;
        gap: 10px;
    }
    
    .range-separator {
        text-align: center;
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* AOS Animation Overrides */
[data-aos="fade-up"] {
    transform: translateY(30px);
    opacity: 0;
    transition: all 0.6s ease;
}

[data-aos="fade-up"].aos-animate {
    transform: translateY(0);
    opacity: 1;
}
</style>

<script>
// AOS Animation Library
(function() {
    const script = document.createElement('script');
    script.src = 'https://unpkg.com/aos@2.3.1/dist/aos.js';
    script.onload = function() {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 100
        });
    };
    document.head.appendChild(script);
    
    const link = document.createElement('link');
    link.href = 'https://unpkg.com/aos@2.3.1/dist/aos.css';
    link.rel = 'stylesheet';
    document.head.appendChild(link);
})();

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarContent = document.getElementById('sidebarContent');
    
    if (sidebarToggle && sidebarContent) {
        sidebarToggle.addEventListener('click', function() {
            sidebarContent.classList.toggle('active');
            
            // Add smooth animation
            if (sidebarContent.classList.contains('active')) {
                sidebarContent.style.display = 'block';
                setTimeout(() => {
                    sidebarContent.style.opacity = '1';
                    sidebarContent.style.transform = 'translateY(0)';
                }, 10);
            } else {
                sidebarContent.style.opacity = '0';
                sidebarContent.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    sidebarContent.style.display = 'none';
                }, 300);
            }
        });
    }
    
    // Enhanced Add to Cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.getAttribute('data-product-id');
            const originalText = this.innerHTML;
            const card = this.closest('.product-card-modern');
            
            // Show loading state with modern animation
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Adding...</span>';
            this.disabled = true;
            this.style.background = 'linear-gradient(135deg, #ffc107 0%, #fd7e14 100%)';
            
            // Add loading effect to card
            if (card) {
                card.style.transform = 'translateY(-5px) scale(0.98)';
                card.style.boxShadow = '0 15px 40px rgba(255, 193, 7, 0.3)';
            }
            
            // AJAX request to add product to cart
            fetch(BASE_URL + 'index.php?page=cart&action=add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'product_id=' + productId + '&quantity=1'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success state with celebration effect
                    this.innerHTML = '<i class="fas fa-check"></i> <span>Added!</span>';
                    this.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                    
                    // Add success effect to card
                    if (card) {
                        card.style.transform = 'translateY(-10px) scale(1.02)';
                        card.style.boxShadow = '0 25px 60px rgba(40, 167, 69, 0.3)';
                        
                        // Create success particles
                        createSuccessParticles(card);
                    }
                    
                    // Update cart count if element exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cart_count) {
                        cartCount.textContent = data.cart_count;
                        cartCount.style.animation = 'bounce 0.6s ease';
                    }
                    
                    // Reset button after 2.5 seconds
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                        this.disabled = false;
                        
                        if (card) {
                            card.style.transform = '';
                            card.style.boxShadow = '';
                        }
                    }, 2500);
                } else {
                    throw new Error(data.message || 'Failed to add product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error state
                this.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>Error</span>';
                this.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
                
                // Add error effect to card
                if (card) {
                    card.style.transform = 'translateY(-5px) scale(0.98)';
                    card.style.boxShadow = '0 15px 40px rgba(220, 53, 69, 0.3)';
                    card.style.animation = 'shake 0.5s ease';
                }
                
                // Show modern error notification
                showNotification(error.message || 'An error occurred. Please try again.', 'error');
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                    this.disabled = false;
                    
                    if (card) {
                        card.style.transform = '';
                        card.style.boxShadow = '';
                        card.style.animation = '';
                    }
                }, 3000);
            });
        });
    });
    
    // Product card hover effects
    const productCards = document.querySelectorAll('.product-card-modern');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });
    
    // Smooth scrolling for category links
    const categoryLinks = document.querySelectorAll('.category-item');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading effect
            this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            this.style.color = 'white';
            this.style.transform = 'translateX(10px)';
        });
    });
});

// Success particles animation
function createSuccessParticles(element) {
    const colors = ['#28a745', '#20c997', '#17a2b8', '#6f42c1'];
    
    for (let i = 0; i < 6; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = '6px';
        particle.style.height = '6px';
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        particle.style.borderRadius = '50%';
        particle.style.pointerEvents = 'none';
        particle.style.zIndex = '1000';
        
        const rect = element.getBoundingClientRect();
        particle.style.left = (rect.left + rect.width / 2) + 'px';
        particle.style.top = (rect.top + rect.height / 2) + 'px';
        
        document.body.appendChild(particle);
        
        const angle = (Math.PI * 2 * i) / 6;
        const velocity = 100 + Math.random() * 50;
        const lifetime = 1000 + Math.random() * 500;
        
        particle.animate([
            {
                transform: 'translate(0, 0) scale(1)',
                opacity: 1
            },
            {
                transform: `translate(${Math.cos(angle) * velocity}px, ${Math.sin(angle) * velocity}px) scale(0)`,
                opacity: 0
            }
        ], {
            duration: lifetime,
            easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
        }).onfinish = () => {
            particle.remove();
        };
    }
}

// Modern notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `modern-notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add notification styles
    const style = document.createElement('style');
    style.textContent = `
        .modern-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 10000;
            min-width: 300px;
            transform: translateX(400px);
            transition: all 0.3s ease;
        }
        .modern-notification.error {
            border-left: 4px solid #dc3545;
        }
        .modern-notification.success {
            border-left: 4px solid #28a745;
        }
        .modern-notification.show {
            transform: translateX(0);
        }
        .notification-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .notification-content i {
            color: ${type === 'error' ? '#dc3545' : '#28a745'};
        }
        .notification-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        .notification-close:hover {
            background: #f0f0f0;
        }
    `;
    
    if (!document.querySelector('#notification-styles')) {
        style.id = 'notification-styles';
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Close button functionality
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }, 5000);
}

// Add shake animation for errors
const shakeStyle = document.createElement('style');
shakeStyle.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
`;
document.head.appendChild(shakeStyle);
</script>

<?php require_once 'app/views/containers/footer.php'; ?>