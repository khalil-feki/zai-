<?php require_once 'app/views/includes/header.php'; ?>

<div class="container mt-4">
    <h2>My Orders</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($orders)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= date('M d, Y', strtotime($order['date_created'])) ?></td>
                            <td><span class="order-status status-<?= strtolower($order['status']) ?>"><?= $order['status'] ?></span></td>
                            <td>$<?= number_format($order['total'], 2) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>?page=orders&action=view&id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            You haven't placed any orders yet.
        </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/includes/footer.php'; ?>