<?php require_once 'app/views/containers/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="success-container">
                <div class="success-header">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h1>Order Placed Successfully!</h1>
                    <p>Thank you for your order. We'll process it shortly.</p>
                </div>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <div class="order-details">
                    <div class="order-info">
                        <h3>Order Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <strong>Order Number:</strong>
                                <span><?= htmlspecialchars($order['ref']) ?></span>
                            </div>
                            <div class="info-item">
                                <strong>Order Date:</strong>
                                <span><?= !empty($order['date_creation']) ? date('F j, Y', strtotime($order['date_creation'])) : date('F j, Y') ?></span>
                            </div>
                            <?php if (!empty($order['customer_email'])): ?>
                            <div class="info-item">
                                <strong>Customer Email:</strong>
                                <span><?= htmlspecialchars($order['customer_email']) ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <strong>Status:</strong>
                                <span class="status-badge">Processing</span>
                            </div>
                            <div class="info-item">
                                <strong>Total Amount:</strong>
                                <span class="total-amount"><?= number_format($order['total_ttc'], 2) ?> TND</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        <h3>Order Items</h3>
                        <div class="items-list">
                            <?php foreach ($orderItems as $item): ?>
                                <div class="order-item">
                                    <div class="item-details">
                                        <h5><?= htmlspecialchars($item['label']) ?></h5>
                                        <p class="item-ref">SKU: <?= htmlspecialchars($item['product_ref'] ?? 'N/A') ?></p>
                                    </div>
                                    <div class="item-quantity">
                                        <span>Qty: <?= $item['qty'] ?></span>
                                    </div>
                                    <div class="item-total">
                                        <span><?= number_format($item['total_ttc'], 2) ?> TND</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="success-actions">
                    <a href="<?= BASE_URL ?>" class="btn btn-primary">Continue Shopping</a>
                    <a href="<?= BASE_URL ?>user/orders" class="btn btn-secondary">View My Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-container {
    max-width: 800px;
    margin: 2rem auto;
    text-align: center;
}

.success-header {
    margin-bottom: 2rem;
}

.success-icon {
    font-size: 4rem;
    color: #28a745;
    margin-bottom: 1rem;
}

.success-header h1 {
    color: #28a745;
    margin-bottom: 0.5rem;
}

.success-header p {
    color: #6c757d;
    font-size: 1.1rem;
}

.order-details {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: left;
}

.order-info h3, .order-items h3 {
    margin-bottom: 1.5rem;
    color: #333;
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 0.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item strong {
    color: #495057;
    font-size: 0.9rem;
}

.info-item span {
    font-size: 1.1rem;
    color: #333;
}

.status-badge {
    background-color: #ffc107;
    color: #212529;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
}

.total-amount {
    font-weight: 700;
    color: #28a745;
    font-size: 1.25rem !important;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.order-item {
    display: grid;
    grid-template-columns: 2fr auto auto;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.item-details h5 {
    margin: 0;
    color: #333;
}

.item-ref {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.item-quantity, .item-total {
    text-align: right;
    font-weight: 600;
}

.success-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #4a6cf7;
    color: white;
}

.btn-primary:hover {
    background-color: #3a5ce5;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

@media (max-width: 768px) {
    .order-item {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .success-actions {
        flex-direction: column;
    }
    
    .success-actions .btn {
        width: 100%;
    }
}
</style>

<?php require_once 'app/views/containers/footer.php'; ?>