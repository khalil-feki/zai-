<?php require_once 'app/views/containers/header.php'; ?>

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

.order-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    min-height: calc(100vh - 200px);
}

.order-detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.order-detail-header h1 {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    position: relative;
}

.order-detail-header h1:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 80px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
}

.order-detail-content {
    display: grid;
    gap: 2rem;
    animation: fadeInUp 0.6s ease-out;
}

.order-info-section {
    display: grid;
    gap: 1.5rem;
}

.order-info-card {
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

.order-info-card:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.order-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.order-info-card h3 {
    color: var(--primary-color);
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0 0 1.5rem 0;
    position: relative;
    padding-bottom: 0.5rem;
}

.order-info-card h3:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: var(--primary-color);
    border-radius: 2px;
}

.order-info-details p {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    line-height: 1.6;
}

.order-info-details strong {
    color: var(--dark-color);
    font-weight: 600;
    display: inline-block;
    min-width: 120px;
}

.order-address {
    background: rgba(248, 249, 252, 0.8);
    padding: 1.5rem;
    border-radius: 15px;
    border-left: 4px solid var(--primary-color);
}

.order-address p {
    margin: 0;
    color: var(--dark-color);
    line-height: 1.6;
}

.order-items-section {
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

.order-items-section:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-secondary);
}

.order-items-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.order-items-section h3 {
    color: var(--primary-color);
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0 0 1.5rem 0;
    position: relative;
    padding-bottom: 0.5rem;
}

.order-items-section h3:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: var(--primary-color);
    border-radius: 2px;
}

.order-items-table {
    overflow-x: auto;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.order-items-table table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 15px;
    overflow: hidden;
}

.order-items-table th {
    background: var(--gradient-primary);
    color: white;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
}

.order-items-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.order-items-table tbody tr:hover {
    background: rgba(78, 115, 223, 0.05);
}

.order-items-table tfoot tr {
    background: rgba(248, 249, 252, 0.8);
    font-weight: 600;
}

.order-items-table tfoot td {
    border-bottom: none;
    border-top: 2px solid var(--primary-color);
}

.product-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.product-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.product-details a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.product-details a:hover {
    color: var(--dark-color);
}

.text-right {
    text-align: right;
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
    .order-detail-container {
        padding: 1rem;
    }
    
    .order-detail-header {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 2rem;
    }
    
    .order-detail-header h1 {
        font-size: 2rem;
    }
    
    .order-info-card,
    .order-items-section {
        padding: 1.5rem;
    }
    
    .product-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .order-items-table th,
    .order-items-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .order-detail-header h1 {
        font-size: 1.8rem;
    }
    
    .order-info-card h3,
    .order-items-section h3 {
        font-size: 1.2rem;
    }
    
    .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.8rem;
    }
    
    .product-thumbnail {
        width: 50px;
        height: 50px;
    }
}
</style>

<div class="order-detail-container">
    <div class="order-detail-header">
        <h1>Order #<?= htmlspecialchars($order['ref']) ?></h1>
        <a href="<?= BASE_URL ?>orders" class="btn btn-secondary">Back to Orders</a>
    </div>
    
    <div class="order-detail-content">
        <div class="order-info-section">
            <div class="order-info-card">
                <h3>Order Information</h3>
                <div class="order-info-details">
                    <p><strong>Order Date:</strong> <?= date('F j, Y', strtotime($order['date_creation'])) ?></p>
                    <?php if (isset($order['customer_name'])): ?>
                    <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($order['customer_email'])): ?>
                    <p><strong>Customer Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
                    <?php endif; ?>
                    <p><strong>Status:</strong> 
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
                    </p>
                    <p><strong>Total:</strong> $<?= number_format($order['total_ttc'], 2) ?></p>
                </div>
            </div>
            
            <?php if (!empty($order['note_private'])): ?>
            <div class="order-info-card">
                <h3>Shipping Address</h3>
                <div class="order-address">
                    <p><?= nl2br(htmlspecialchars($order['note_private'])) ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="order-items-section">
            <h3>Order Items</h3>
            <div class="order-items-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <img src="<?= BASE_URL . htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="product-thumbnail" onerror="this.src='<?= LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE ?>'">
                                        <?php endif; ?>
                                        <div class="product-details">
                                            <a href="<?= BASE_URL ?>products/view/<?= $item['fk_product'] ?>"><?= htmlspecialchars($item['product_name'] ?? $item['description']) ?></a>
                                        </div>
                                    </div>
                                </td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td><?= $item['qty'] ?></td>
                                <td>$<?= number_format($item['total_ht'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                            <td>$<?= number_format($order['total_ht'], 2) ?></td>
                        </tr>
                        <?php if (isset($order['total_tva']) && $order['total_tva'] > 0): ?>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                            <td>$<?= number_format($order['total_tva'], 2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                            <td><strong>$<?= number_format($order['total_ttc'], 2) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/containers/footer.php'; ?>