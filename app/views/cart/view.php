<?php require_once 'app/views/containers/header.php'; ?>

<div class="container mt-4">
    <div class="cart-view-container">
        <h2>Cart Summary</h2>
        
        <?php if (!empty($cartItems) && is_array($cartItems)): ?>
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item-card mb-3">
                        <div class="row align-items-center">
                            
                            <div class="col-md-4">
                                <h6><?= htmlspecialchars($item['label']) ?></h6>
                                <small class="text-muted">SKU: <?= htmlspecialchars($item['ref']) ?></small>
                            </div>
                            <div class="col-md-2">
                                <span class="fw-bold">€<?= number_format($item['price'], 2) ?></span>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-secondary">Qty: <?= $item['quantity'] ?></span>
                            </div>
                            <div class="col-md-2">
                                <span class="fw-bold text-primary">€<?= number_format($item['total_price'], 2) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-total mt-4 p-3 bg-light rounded">
                <div class="row">
                    <div class="col-md-8">
                        <h5>Total Amount:</h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <h4 class="text-primary">€<?= number_format($cartTotal, 2) ?></h4>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Your cart is empty.
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.cart-view-container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.cart-item-card {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.cart-total {
    border: 2px solid #4a6cf7;
}
</style>

<?php require_once 'app/views/containers/footer.php'; ?>