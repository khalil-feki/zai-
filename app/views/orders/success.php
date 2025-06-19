<?php require_once 'app/views/containers/header.php'; ?>

<div class="order-success-container">
    <div class="success-header">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your purchase. Your order has been received and is being processed.</p>
    </div>
    
    <div class="order-details">
        <h2>Order Details</h2>
        <div class="order-info">
            <div class="info-row">
                <span>Order Number:</span>
                <span><?= htmlspecialchars($order['ref']) ?></span>
            </div>
            <div class="info-row">
                <span>Date:</span>
                <span><?= date('F j, Y', strtotime($order['date_commande'])) ?></span>
            </div>
            <div class="info-row">
                <span>Total Amount:</span>
                <span>$<?= number_format($order['total_ht'], 2) ?></span>
            </div>
            <div class="info-row">
                <span>Shipping Address:</span>
                <span><?= nl2br(htmlspecialchars($order['note_private'])) ?></span>
            </div>
        </div>
        
        <h3>Order Items</h3>
        <div class="order-items">
            <?php while ($item = $orderItems->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="order-item">
                    <div class="item-info">
                        <h4><?= htmlspecialchars($item['label']) ?></h4>
                        <p>Quantity: <?= $item['qty'] ?></p>
                    </div>
                    <div class="item-price">
                        <p>$<?= number_format($item['price'], 2) ?> × <?= $item['qty'] ?></p>
                        <p class="total">$<?= number_format($item['total_ht'], 2) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    
    <div class="success-actions">
        <a href="<?= BASE_URL ?>orders" class="btn">View All Orders</a>
        <a href="<?= BASE_URL ?>products" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>

<style>
.order-success-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px 15px;
}

.success-header {
    text-align: center;
    margin-bottom: 30px;
}

.success-icon {
    font-size: 64px;
    color: #28a745;
    margin-bottom: 20px;
}

.success-header h1 {
    margin-bottom: 10px;
}

.order-details {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.order-details h2 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}

.order-details h3 {
    margin: 20px 0 15px;
}

.order-info {
    margin-bottom: 20px;
}

.info-row {
    display: flex;
    margin-bottom: 10px;
}

.info-row span:first-child {
    font-weight: bold;
    width: 150px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #ddd;
}

.item-info h4 {
    margin-bottom: 5px;
}

.item-price {
    text-align: right;
}

.item-price .total {
    font-weight: bold;
}

.success-actions {
    display: flex;
    justify-content: center;
    gap: 20px;
}

@media (max-width: 768px) {
    .info-row {
        flex-direction: column;
    }
    
    .info-row span:first-child {
        margin-bottom: 5px;
    }
    
    .order-item {
        flex-direction: column;
    }
    
    .item-price {
        text-align: left;
        margin-top: 10px;
    }
    
    .success-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .success-actions .btn {
        width: 100%;
        text-align: center;
    }
}
</style>

<?php require_once 'app/views/containers/footer.php'; ?>