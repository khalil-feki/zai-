<?php require_once 'app/views/containers/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </nav>
            
            <h1 class="mb-4">Your Shopping Cart</h1>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <?php if ($cartItems && count($cartItems) > 0): ?>
                <div class="modern-cart-container">
                    <div class="cart-items-grid">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="cart-item-card">
                                <div class="item-info">
                                    <h5 class="item-title"><?= htmlspecialchars($item['label']) ?></h5>
                                    <p class="item-sku">SKU: <?= htmlspecialchars($item['ref']) ?></p>
                                    <div class="item-quantity-display">
                                        <span class="quantity-label">Quantity:</span>
                                        <span class="quantity-value"><?= $item['quantity'] ?></span>
                                    </div>
                                </div>
                                
                                <div class="item-pricing">
                                    <div class="price-info">
                                        <span class="unit-price"><?= number_format($item['price'], 2) ?> dt each</span>
                                        <span class="total-price"><?= number_format($item['total_price'], 2) ?> dt</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="cart-summary">
                        <div class="summary-card">
                            <h3 class="summary-title">Order Summary</h3>
                            <div class="summary-line">
                                <span>Items (<?= count($cartItems) ?>)</span>
                                <span><?= number_format($cartTotal, 2) ?> dt</span>
                            </div>
                            <div class="summary-line">
                                <span>Shipping</span>
                                <span class="free-text">Free</span>
                            </div>
                            <div class="summary-total">
                                <span>Total</span>
                                <span><?= number_format($cartTotal, 2) ?> dt</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-actions-modern">
                        <div class="action-buttons">
                            <a href="<?= BASE_URL ?>" class="btn-continue">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                            <button type="button" class="btn-clear" onclick="clearCart()">
                                <i class="fas fa-trash-alt"></i> Clear Cart
                            </button>
                            
                            <script>
                            function clearCart() {
                                if (confirm('Are you sure you want to clear your cart?')) {
                                    fetch('<?= BASE_URL ?>index.php?page=cart&action=clear', {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            window.location.href = '<?= BASE_URL ?>';
                                        } else {
                                            alert(data.message || 'Failed to clear cart');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        window.location.href = '<?= BASE_URL ?>';
                                    });
                                }
                            }
                            </script>
                            <a href="<?= BASE_URL ?>checkout" class="btn-checkout">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart-modern">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="<?= BASE_URL ?>" class="btn-start-shopping">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Modern Cart Container with Glassmorphism */
.modern-cart-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    margin-bottom: 3rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.modern-cart-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f093fb, #f5576c, #4facfe, #00f2fe);
    background-size: 300% 100%;
    animation: gradientShift 3s ease-in-out infinite;
}

/* Modern Cart Items Grid */
.cart-items-grid {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin-bottom: 3rem;
}

.cart-item-card {
    display: grid;
    grid-template-columns: 2fr 1fr auto;
    gap: 2rem;
    align-items: center;
    padding: 2rem;
    border: 2px solid rgba(102, 126, 234, 0.1);
    border-radius: 20px;
    transition: all 0.4s ease;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.cart-item-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    transform: scaleY(0);
    transition: transform 0.4s ease;
}

.cart-item-card:hover {
    border-color: #667eea;
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
    background: rgba(255, 255, 255, 0.95);
}

.cart-item-card:hover::before {
    transform: scaleY(1);
}

/* Modern Item Info */
.item-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.item-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    position: relative;
    padding-bottom: 5px;
}

.item-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 1px;
}

.item-sku {
    color: #718096;
    font-size: 0.95rem;
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.item-quantity-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.5rem;
}

.quantity-label {
    color: #4a5568;
    font-weight: 600;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.quantity-value {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 25px;
    font-weight: 700;
    font-size: 0.95rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.quantity-value::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.quantity-value:hover::before {
    left: 100%;
}

/* Modern Pricing Section */
.item-pricing {
    text-align: right;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.price-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    align-items: flex-end;
}

.unit-price {
    color: #718096;
    font-size: 0.95rem;
    font-weight: 500;
    position: relative;
    padding: 0.25rem 0.75rem;
    background: rgba(113, 128, 150, 0.1);
    border-radius: 15px;
}

.total-price {
    font-size: 1.8rem;
    font-weight: 800;
    color: #2d3748;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

/* Modern Action Buttons */
.item-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-view, .btn-remove {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    text-align: center;
    transition: all 0.4s ease;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-view::before, .btn-remove::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.btn-view:hover::before, .btn-remove:hover::before {
    left: 100%;
}

.btn-view {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
    color: #4a5568;
    box-shadow: 0 4px 15px rgba(226, 232, 240, 0.4);
}

.btn-view:hover {
    background: linear-gradient(135deg, #cbd5e0, #a0aec0);
    color: #2d3748;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(226, 232, 240, 0.6);
}

.btn-remove {
    background: linear-gradient(135deg, #fed7d7, #feb2b2);
    color: #c53030;
    box-shadow: 0 4px 15px rgba(254, 215, 215, 0.4);
}

.btn-remove:hover {
    background: linear-gradient(135deg, #feb2b2, #fc8181);
    color: #9b2c2c;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(254, 215, 215, 0.6);
}

/* Modern Cart Summary */
.cart-summary {
    border-top: 2px solid rgba(102, 126, 234, 0.1);
    padding-top: 3rem;
    margin-bottom: 3rem;
    position: relative;
}

.cart-summary::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.summary-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem;
    border-radius: 25px;
    max-width: 450px;
    margin-left: auto;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
}

.summary-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

.summary-title {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 2rem;
    text-align: center;
    position: relative;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.summary-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.summary-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
    font-weight: 500;
    position: relative;
    z-index: 1;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.8rem;
    font-weight: 800;
    border-top: 2px solid rgba(255, 255, 255, 0.3);
    padding-top: 1.5rem;
    margin-top: 1.5rem;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.free-text {
    color: #68d391;
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Modern Cart Actions */
.cart-actions-modern {
    border-top: 2px solid rgba(102, 126, 234, 0.1);
    padding-top: 3rem;
    position: relative;
}

.cart-actions-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.action-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-continue, .btn-clear, .btn-checkout {
    padding: 1.2rem 2.5rem;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.4s ease;
    border: none;
    cursor: pointer;
    font-size: 1.1rem;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-continue::before, .btn-clear::before, .btn-checkout::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.btn-continue:hover::before, .btn-clear:hover::before, .btn-checkout:hover::before {
    left: 100%;
}

.btn-continue {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
    color: #4a5568;
    box-shadow: 0 8px 25px rgba(226, 232, 240, 0.4);
}

.btn-continue:hover {
    background: linear-gradient(135deg, #cbd5e0, #a0aec0);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(226, 232, 240, 0.6);
    color: #2d3748;
}

.btn-clear {
    background: linear-gradient(135deg, #fed7d7, #feb2b2);
    color: #c53030;
    box-shadow: 0 8px 25px rgba(254, 215, 215, 0.4);
}

.btn-clear:hover {
    background: linear-gradient(135deg, #feb2b2, #fc8181);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(254, 215, 215, 0.6);
    color: #9b2c2c;
}

.btn-checkout {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
}

.btn-checkout:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(72, 187, 120, 0.6);
    color: white;
}

/* Modern Empty Cart */
.empty-cart-modern {
    text-align: center;
    padding: 5rem 3rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.empty-cart-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f093fb, #f5576c, #4facfe, #00f2fe);
    background-size: 300% 100%;
    animation: gradientShift 3s ease-in-out infinite;
}

.empty-icon {
    font-size: 5rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 2.5rem;
    animation: float 3s ease-in-out infinite;
}

.empty-cart-modern h3 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d3748;
    margin-bottom: 1.5rem;
    position: relative;
}

.empty-cart-modern h3::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.empty-cart-modern p {
    color: #718096;
    font-size: 1.2rem;
    margin-bottom: 3rem;
    font-weight: 500;
}

.btn-start-shopping {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem 3rem;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.2rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-start-shopping::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.btn-start-shopping:hover::before {
    left: 100%;
}

.btn-start-shopping:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.6);
    color: white;
}

/* Animation Keyframes */
@keyframes gradientShift {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
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

@media (max-width: 768px) {
    .cart-item-card {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 1rem;
    }
    
    .item-actions {
        flex-direction: row;
        justify-content: center;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .summary-card {
        max-width: 100%;
    }
}</style>

<?php require_once 'app/views/containers/footer.php'; ?>
