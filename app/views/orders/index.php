<?php require_once __DIR__ . '/../containers/header.php'; ?>

<style>
:root {
    --primary-color: #4e73df;
    --secondary-color: #858796;
    --success-color: #1cc88a;
    --info-color: #36b9cc;
    --warning-color: #f6c23e;
    --danger-color: #e74a3b;
    --light-color: #f8f9fc;
    --dark-color: #5a5c69;
    --border-color: #e3e6f0;
    --shadow-color: rgba(0, 0, 0, 0.15);
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

body {
    font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    margin: 0;
    padding: 0;
}

.orders-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    min-height: calc(100vh - 200px);
}

.orders-container h1 {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 3rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    position: relative;
}

.orders-container h1:after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
}

.empty-orders {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: fadeInUp 0.6s ease-out;
}

.empty-orders p {
    font-size: 1.2rem;
    color: var(--dark-color);
    margin-bottom: 2rem;
    font-weight: 500;
}

.orders-list {
    display: grid;
    gap: 1.5rem;
    animation: fadeInUp 0.6s ease-out;
}

.order-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.order-card:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.order-info h3 {
    color: var(--primary-color);
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.order-date {
    color: var(--secondary-color);
    font-size: 0.95rem;
    margin: 0;
    font-weight: 500;
}

.order-status {
    display: flex;
    align-items: center;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.status-draft {
    background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
    color: #2d3436;
}

.status-validated {
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    color: white;
}

.status-processing {
    background: linear-gradient(135deg, #fd79a8, #e84393);
    color: white;
}

.status-shipped {
    background: linear-gradient(135deg, #a29bfe, #6c5ce7);
    color: white;
}

.status-delivered {
    background: linear-gradient(135deg, #00b894, #00a085);
    color: white;
}

.status-cancelled {
    background: linear-gradient(135deg, #fab1a0, #e17055);
    color: white;
}

.status-unknown {
    background: linear-gradient(135deg, #b2bec3, #636e72);
    color: white;
}

.order-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.order-total p {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn:hover:before {
    left: 100%;
}

.btn-primary {
    background: var(--gradient-primary);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);
}

.btn-secondary {
    background: var(--gradient-secondary);
    color: white;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);
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
    .orders-container {
        padding: 1rem;
    }
    
    .orders-container h1 {
        font-size: 2rem;
        margin-bottom: 2rem;
    }
    
    .order-card {
        padding: 1.5rem;
    }
    
    .order-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .order-details {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .empty-orders {
        padding: 2rem 1rem;
    }
}

@media (max-width: 480px) {
    .orders-container h1 {
        font-size: 1.8rem;
    }
    
    .order-info h3 {
        font-size: 1.2rem;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.8rem;
    }
}
</style>

<div class="orders-container">
    <h1>My Orders</h1>
    
    <!-- User Info -->
    <div class="user-info" style="background: rgba(255, 255, 255, 0.95); padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="color: #5a5c69;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem;">📧 Showing orders for your email:</h3>
                <p style="margin: 0; font-weight: 600; color: #4e73df; font-size: 1rem;"><?= htmlspecialchars($_SESSION['user_email'] ?? 'N/A') ?></p>
            </div>
        </div>
        <div style="margin-top: 1rem; padding: 0.75rem; background: #e8f5e8; border-radius: 8px; color: #2e7d32; font-size: 0.9rem;">
            <strong>ℹ️ Note:</strong> Orders are automatically filtered to show only those associated with your email address.
        </div>
    </div>
    
    <?php if (empty($orders)): ?>
        <div class="empty-orders">
            <p>You don't have any orders yet.</p>
            <a href="<?= BASE_URL ?>products" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #<?= htmlspecialchars($order['ref']) ?></h3>
                            <p class="order-date">Placed on <?= date('F j, Y', strtotime($order['date_creation'])) ?></p>
                        </div>
                        <div class="order-status">
                            <?php
                            $statusClass = '';
                            $statusText = '';
                            switch ($order['fk_statut']) {
                                case 0:
                                    $statusClass = 'status-draft';
                                    $statusText = 'Draft';
                                    break;
                                case 1:
                                    $statusClass = 'status-validated';
                                    $statusText = 'Validated';
                                    break;
                                case 2:
                                    $statusClass = 'status-processing';
                                    $statusText = 'Processing';
                                    break;
                                case 3:
                                    $statusClass = 'status-shipped';
                                    $statusText = 'Shipped';
                                    break;
                                case 4:
                                    $statusClass = 'status-delivered';
                                    $statusText = 'Delivered';
                                    break;
                                case -1:
                                    $statusClass = 'status-cancelled';
                                    $statusText = 'Cancelled';
                                    break;
                                default:
                                    $statusClass = 'status-unknown';
                                    $statusText = 'Unknown';
                            }
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </div>
                    </div>
                    <div class="order-details">
                        <div class="order-info">
                            <?php if (isset($order['customer_name'])): ?>
                            <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                            <?php endif; ?>
                            <p><strong>Total:</strong> $<?= number_format($order['total_ttc'], 2) ?></p>
                        </div>
                        <div class="order-actions">
                            <a href="<?= BASE_URL ?>orders/view/<?= $order['rowid'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/containers/footer.php'; ?>