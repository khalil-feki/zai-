<?php require_once 'app/views/containers/header.php'; ?>

<!-- Modern Product Hero Section -->
<div class="product-hero">
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
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>cart">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['label']) ?></li>
                </ol>
            </nav>
            <h1 class="hero-title"><?= htmlspecialchars($product['label']) ?></h1>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= number_format($product['price'], 2) ?> dt</span>
                    <span class="stat-label">Premium Quality</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Product Container -->
<div class="modern-product-container">
    <div class="container">
    
        <div class="product-layout">
            <!-- Product Image Card -->
            <div class="product-image-card modern-card">
                <div class="product-image-container">
                    <img src="<?= $product['image_url'] ?? LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE ?>"
                         alt="<?= htmlspecialchars($product['label']) ?>" 
                         class="product-main-image"
                         onerror="this.src='<?= LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE ?>'">
                    <div class="image-overlay">
                        <div class="zoom-btn">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                    <div class="product-badge">
                        <span class="badge-premium">Premium</span>
                    </div>
                </div>
            </div>
            
            <!-- Product Details Card -->
            <div class="product-details-card modern-card">
                <div class="card-header">
                    <div class="product-meta">
                        <span class="product-sku"><i class="fas fa-barcode"></i> SKU: <?= htmlspecialchars($product['ref']) ?></span>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0 (Premium Quality)</span>
                        </div>
                    </div>
                </div>
                
                <div class="card-content">
                    <?php if (!empty($product['description'])): ?>
                        <div class="product-description">
                            <h5><i class="fas fa-info-circle"></i> Product Description</h5>
                            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="product-features">
                        <h5><i class="fas fa-check-circle"></i> Key Features</h5>
                        <ul class="features-list">
                            <li><i class="fas fa-shield-alt"></i> Premium Quality Guarantee</li>
                            <li><i class="fas fa-truck"></i> Fast & Secure Delivery</li>
                            <li><i class="fas fa-undo"></i> 30-Day Return Policy</li>
                            <li><i class="fas fa-headset"></i> 24/7 Customer Support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            
        <!-- Cart & Purchase Section -->
        <div class="cart-purchase-section">
            <!-- Cart Status Card -->
            <?php if ($cartItem): ?>
                <div class="cart-status-card modern-card">
                    <div class="card-header success">
                        <h5><i class="fas fa-check-circle"></i> Already in Your Cart</h5>
                    </div>
                    <div class="card-content">
                        <div class="cart-details">
                            <div class="detail-item">
                                <span class="label">Quantity:</span>
                                <span class="value"><?= $cartItem['quantity'] ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="label">Added:</span>
                                <span class="value"><?= date('M j, Y g:i A', strtotime($cartItem['date_creation'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Add to Cart Card -->
            <div class="add-to-cart-card modern-card">
                <div class="card-header">
                    <h5><i class="fas fa-shopping-cart"></i> Purchase Options</h5>
                </div>
                <div class="card-content">
                    <form action="<?= BASE_URL ?>index.php?page=cart&action=add" method="post" class="modern-cart-form">
                        <input type="hidden" name="product_id" value="<?= $product['rowid'] ?>">
                        
                        <div class="quantity-section">
                            <label for="quantity" class="modern-label">
                                <i class="fas fa-cubes"></i> Select Quantity
                            </label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn minus" onclick="decreaseQuantity()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="99" 
                                       class="quantity-input" readonly>
                                <button type="button" class="quantity-btn plus" onclick="increaseQuantity()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Price Summary Section -->
                        <div class="price-summary-section">
                            <div class="price-breakdown">
                                <div class="price-item">
                                    <span class="price-label">Unit Price:</span>
                                    <span class="price-value"><?= number_format($product['price'], 2) ?> dt</span>
                                </div>
                                <div class="price-item">
                                    <span class="price-label">Quantity:</span>
                                    <span class="price-value" id="display-quantity">1</span>
                                </div>
                                <div class="price-item total-price">
                                    <span class="price-label">Total:</span>
                                    <span class="price-value" id="total-price"><?= number_format($product['price'], 2) ?> dt</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="purchase-actions">
                            <button type="submit" class="add-to-cart-btn-modern">
                                <i class="fas fa-cart-plus"></i>
                                <span><?= $cartItem ? 'Add More to Cart' : 'Add to Cart' ?></span>
                                <div class="btn-shine"></div>
                            </button>
                            
                            <div class="action-buttons-modern">
                                <a href="<?= BASE_URL ?>cart" class="modern-btn secondary">
                                    <i class="fas fa-shopping-cart"></i> View Cart
                                </a>
                                <a href="<?= BASE_URL ?>" class="modern-btn outline">
                                    <i class="fas fa-arrow-left"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Related Products</h3>
                <div class="row">
                    <?php foreach (array_slice($relatedProducts, 0, 4) as $relatedProduct): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="<?= $relatedProduct['image_url'] ?? (LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE) ?>" 
                                     class="card-img-top" alt="<?= htmlspecialchars($relatedProduct['label']) ?>"
                                     style="height: 200px; object-fit: cover;"
                                     onerror="this.src='<?= LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE ?>'">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title"><?= htmlspecialchars($relatedProduct['label']) ?></h6>
                                    <p class="card-text text-primary fw-bold"><?= number_format($relatedProduct['price'], 2) ?> dt</p>
                                    <div class="mt-auto">
                                        <a href="<?= BASE_URL ?>product/view/<?= $relatedProduct['rowid'] ?>" 
                                           class="btn btn-outline-primary btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
/* Hero Section */
.product-hero {
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

/* Modern Product Container */
.modern-product-container {
    padding: 0 0 80px;
}

.product-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}

/* Modern Card Base */
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
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

.modern-card .card-header.success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.modern-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.modern-card .card-header i {
    margin-right: 10px;
}

.modern-card .card-content {
    padding: 25px;
}

/* Product Image Card */
.product-image-container {
    position: relative;
    height: 500px;
    overflow: hidden;
}

.product-main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.4s ease;
}

.product-image-card:hover .product-main-image {
    transform: scale(1.1);
}

.image-overlay {
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

.product-image-card:hover .image-overlay {
    opacity: 1;
}

.zoom-btn {
    background: white;
    color: #667eea;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    transform: scale(0.8);
    transition: all 0.3s ease;
    cursor: pointer;
}

.image-overlay:hover .zoom-btn {
    transform: scale(1);
}

.product-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 2;
}

.badge-premium {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Product Details Card */
.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.product-sku {
    font-size: 0.9rem;
    opacity: 0.9;
}

.product-sku i {
    margin-right: 5px;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 10px;
}

.stars {
    color: #ffd700;
}

.rating-text {
    font-size: 0.85rem;
    opacity: 0.9;
}

.product-description {
    margin-bottom: 25px;
}

.product-description h5 {
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
}

.product-description h5 i {
    color: #667eea;
    margin-right: 10px;
}

.product-description p {
    color: #666;
    line-height: 1.6;
}

.product-features h5 {
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
}

.product-features h5 i {
    color: #28a745;
    margin-right: 10px;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.features-list li {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    color: #666;
    display: flex;
    align-items: center;
    gap: 12px;
}

.features-list li:last-child {
    border-bottom: none;
}

.features-list li i {
    color: #28a745;
    width: 16px;
}

/* Cart Purchase Section */
.cart-purchase-section {
    display: grid;
    gap: 30px;
}

/* Cart Status Card */
.cart-details {
    display: grid;
    gap: 15px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item .label {
    font-weight: 500;
    opacity: 0.9;
}

.detail-item .value {
    font-weight: 600;
}

.detail-item .value.price {
    font-size: 1.2rem;
    color: #fff;
}

/* Modern Cart Form */
.modern-cart-form {
    display: grid;
    gap: 25px;
}

/* Price Summary Section */
.price-summary-section {
    margin: 1.5rem 0;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    border: 1px solid rgba(0, 123, 255, 0.1);
}

.price-breakdown {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.price-item.total-price {
    border-top: 2px solid #007bff;
    padding-top: 1rem;
    margin-top: 0.5rem;
    font-weight: 600;
    font-size: 1.1rem;
}

.price-label {
    color: #495057;
    font-weight: 500;
}

.price-value {
    color: #007bff;
    font-weight: 600;
    font-size: 1rem;
}

.total-price .price-value {
    color: #28a745;
    font-size: 1.2rem;
    font-weight: 700;
}

.quantity-section {
    display: grid;
    gap: 15px;
}

.modern-label {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modern-label i {
    color: #667eea;
}

.quantity-controls {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    overflow: hidden;
    width: fit-content;
    transition: all 0.3s ease;
}

.quantity-controls:hover {
    border-color: #667eea;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
}

.quantity-btn {
    background: transparent;
    border: none;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #666;
    font-weight: 600;
}

.quantity-btn:hover {
    background: #667eea;
    color: white;
    transform: scale(1.1);
}

.quantity-btn:active {
    transform: scale(0.95);
}

.quantity-input {
    width: 80px;
    padding: 15px;
    border: none;
    font-size: 1.2rem;
    font-weight: 700;
    text-align: center;
    background: transparent;
    color: #333;
}

.quantity-input:focus {
    outline: none;
}

/* Purchase Actions */
.purchase-actions {
    display: grid;
    gap: 20px;
}

.add-to-cart-btn-modern {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-height: 45px;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    position: relative;
    overflow: hidden;
    text-transform: none;
    letter-spacing: 0.5px;
}

.add-to-cart-btn-modern:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 30px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
}

.add-to-cart-btn-modern:active {
    transform: translateY(-2px) scale(1.02);
}

.add-to-cart-btn-modern i {
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}

.add-to-cart-btn-modern:hover i {
    transform: rotate(15deg) scale(1.2);
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.add-to-cart-btn-modern:hover .btn-shine {
    left: 100%;
}



.action-buttons-modern {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.modern-btn {
    padding: 15px 25px;
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
    font-size: 0.95rem;
}

.modern-btn.secondary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.modern-btn.secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.modern-btn.outline {
    background: transparent;
    color: #666;
    border: 2px solid #e1e5e9;
}

.modern-btn.outline:hover {
    background: #f8f9fa;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .product-layout {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .hero-title {
        font-size: 3rem;
    }
}

@media (max-width: 768px) {
    .product-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .product-image-container {
        height: 350px;
    }
    
    .product-meta {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .action-buttons-modern {
        grid-template-columns: 1fr;
    }
    
    .add-to-cart-btn-modern {
        font-size: 1.2rem;
        padding: 18px 30px;
        min-height: 60px;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .modern-card .card-content {
        padding: 20px;
    }
    
    .quantity-btn {
        width: 45px;
        height: 45px;
    }
    
    .quantity-input {
        width: 70px;
        font-size: 1.1rem;
    }
    
    .add-to-cart-btn-modern {
        font-size: 1.1rem;
        padding: 16px 25px;
        min-height: 55px;
        gap: 10px;
    }
}
</style>

<script>
function updateTotal() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const unitPrice = <?= $product['price'] ?>;
    const total = quantity * unitPrice;
    
    document.getElementById('display-quantity').textContent = quantity;
    document.getElementById('total-price').textContent = total.toFixed(2) + ' dt';
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.getAttribute('max'));
    
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
        updateTotal();
        
        // Add visual feedback
        const plusBtn = document.querySelector('.quantity-btn.plus');
        plusBtn.style.transform = 'scale(1.2)';
        setTimeout(() => {
            plusBtn.style.transform = 'scale(1)';
        }, 150);
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.getAttribute('min'));
    
    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
        updateTotal();
        
        // Add visual feedback
        const minusBtn = document.querySelector('.quantity-btn.minus');
        minusBtn.style.transform = 'scale(1.2)';
        setTimeout(() => {
            minusBtn.style.transform = 'scale(1)';
        }, 150);
    }
}

// Add keyboard support
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    
    quantityInput.addEventListener('keydown', function(e) {
        // Allow: backspace, delete, tab, escape, enter
        if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    // Validate input on change
    quantityInput.addEventListener('change', function() {
        let value = parseInt(this.value);
        const min = parseInt(this.getAttribute('min'));
        const max = parseInt(this.getAttribute('max'));
        
        if (isNaN(value) || value < min) {
            this.value = min;
        } else if (value > max) {
            this.value = max;
        }
    });
});
</script>

<?php require_once 'app/views/containers/footer.php'; ?>