<?php require_once 'app/views/containers/header.php'; ?>

<div class="order-details-container">
    <div class="order-header">
        <h1>Order #<?= htmlspecialchars($order['ref']) ?></h1>
        <p class="order-date">Placed on <?= date('F j, Y', strtotime($order['date_commande'])) ?></p>
    </div>
    
    <div class="order-info">
        <div class="order-section">
            <h2>Order Information</h2>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Order Number:</span>
                    <span class="info-value"><?= htmlspecialchars($order['ref']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date:</span>
                    <span class="info-value"><?= date('F j, Y', strtotime($order['date_commande'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <?php 
                        $status = '';
                        switch($order['fk_statut']) {
                            case 0: $status = 'Draft'; break;
                            case 1: $status = 'Validated'; break;
                            case 2: $status = 'Shipped'; break;
                            case 3: $status = 'Delivered'; break;
                            default: $status = 'Processing'; break;
                        }
                        echo $status;
                        ?>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total:</span>
                    <span class="info-value">$<?= number_format($order['total_ht'], 2) ?></span>
                </div>
            </div>
        </div>
        
        <div class="order-section">
            <h2>Shipping Information</h2>
            <p><?= nl2br(htmlspecialchars($order['note_private'])) ?></p>
        </div>
    </div>
    
    <div class="order-section">
        <h2>Order Items</h2>
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $orderItems->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="product-info">
                            <div>
                                <h3><?= htmlspecialchars($item['label']) ?></h3>
                                <?php if (!empty($item['description'])): ?>
                                    <p class="product-description"><?= htmlspecialchars(substr($item['description'], 0, 100)) ?><?= strlen($item['description']) > 100 ? '...' : '' ?></p>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>$<?= number_format($item['total_ht'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                    <td>$<?= number_format($order['total_ht'], 2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                    <td>$<?= number_format($order['total_tva'], 2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td>$<?= number_format($order['total_ttc'], 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="order-actions">
        <a href="<?= BASE_URL ?>orders" class="btn btn-secondary">Back to Orders</a>
    </div>
</div>

<?php require_once 'app/views/containers/footer.php'; ?>