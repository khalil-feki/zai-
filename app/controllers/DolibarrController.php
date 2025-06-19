<?php
require_once 'app/services/DolibarrService.php';

class DolibarrController {
    private $dolibarrService;
    
    public function __construct() {
        $this->dolibarrService = new DolibarrService();
    }
    
    public function status() {
        // Check connection
        $isConnected = false;
        $connectionError = '';
        
        try {
            $isConnected = $this->dolibarrService->isConnected();
        } catch (Exception $e) {
            $connectionError = $e->getMessage();
        }
        
        // Prepare status data
        $status = [
            'connected' => $isConnected,
            'api_url' => getenv('DOLIBARR_API_URL'),
            'username' => getenv('DOLIBARR_USERNAME'),
            'error' => $connectionError
        ];
        
        // Output as JSON or HTML based on request
        if (isset($_GET['format']) && $_GET['format'] === 'json') {
            header('Content-Type: application/json');
            echo json_encode($status);
        } else {
            // HTML output
            require_once 'app/views/containers/header.php';
            ?>
            <div class="container mt-4">
                <h1>Dolibarr Connection Status</h1>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Connection Status</h5>
                        <?php if ($isConnected): ?>
                            <div class="alert alert-success">
                                <strong>Connected!</strong> Your application is successfully connected to Dolibarr.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <strong>Not Connected!</strong> 
                                <?php echo $connectionError ? 'Error: ' . htmlspecialchars($connectionError) : 'Unable to connect to Dolibarr.'; ?>
                            </div>
                        <?php endif; ?>
                        
                        <h5 class="mt-4">Configuration</h5>
                        <table class="table">
                            <tr>
                                <th>API URL</th>
                                <td><?php echo htmlspecialchars(getenv('DOLIBARR_API_URL')); ?></td>
                            </tr>
                            <tr>
                                <th>API Key</th>
                                <td><?php echo getenv('DOLIBARR_API_KEY') ? '********' : 'Not set'; ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><?php echo htmlspecialchars(getenv('DOLIBARR_USERNAME')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php if ($isConnected): ?>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Quick API Test</h5>
                        <a href="?action=test-products" class="btn btn-primary">Test Products API</a>
                        <a href="?action=test-customers" class="btn btn-secondary">Test Customers API</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php
            require_once 'app/views/containers/footer.php';
        }
    }
    
    // Add the missing show method
    public function show($id = null) {
        // If no ID provided, get it from query string
        if ($id === null && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        
        // Check if ID is provided
        if (!$id) {
            $_SESSION['error'] = 'Product ID is required';
            redirect('dolibarr/status');
            return;
        }
        
        // Get product details
        $product = $this->dolibarrService->getProduct($id);
        
        // Check for errors
        if (isset($product['error'])) {
            $_SESSION['error'] = 'Error retrieving product: ' . $product['error'];
            redirect('dolibarr/status');
            return;
        }
        
        // Display product details
        require_once 'app/views/containers/header.php';
        ?>
        <div class="container mt-4">
            <h1>Product Details</h1>
            
            <div class="card">
                <div class="card-body">
                    <h2><?= htmlspecialchars($product['label'] ?? 'Unknown Product') ?></h2>
                    <p class="text-muted">Reference: <?= htmlspecialchars($product['ref'] ?? 'N/A') ?></p>
                    
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h4>Description</h4>
                            <p><?= nl2br(htmlspecialchars($product['description'] ?? 'No description available')) ?></p>
                            
                            <h4>Details</h4>
                            <table class="table">
                                <tr>
                                    <th>Price</th>
                                    <td><?= htmlspecialchars($product['price'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td><?= htmlspecialchars($product['stock_reel'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?= ($product['status'] ?? 0) == 1 ? 'Active' : 'Inactive' ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <?php if (!empty($product['url_photo'])): ?>
                                <img src="<?= htmlspecialchars($product['url_photo']) ?>" class="img-fluid" alt="<?= htmlspecialchars($product['label'] ?? 'Product image') ?>">
                            <?php else: ?>
                                <div class="text-center p-4 bg-light">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                    <p class="mt-2">No image available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= BASE_URL ?>dolibarr/status" class="btn btn-secondary">Back to Status</a>
                </div>
            </div>
        </div>
        <?php
        require_once 'app/views/containers/footer.php';
    }
    
    // Add the missing orders method
    public function orders() {
        // Check connection
        if (!$this->dolibarrService->isConnected()) {
            $_SESSION['error'] = 'Not connected to Dolibarr';
            redirect('dolibarr/status');
            return;
        }
        
        // Get orders if the method exists in DolibarrService
        $orders = [];
        $error = null;
        
        try {
            // Check if the method exists
            if (method_exists($this->dolibarrService, 'getOrders')) {
                $orders = $this->dolibarrService->getOrders(10, 0);
                
                // Check for API error
                if (isset($orders['error'])) {
                    $error = $orders['error'];
                    $orders = [];
                }
            } else {
                $error = 'The getOrders method is not implemented in DolibarrService';
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        
        // Display orders
        require_once 'app/views/containers/header.php';
        ?>
        <div class="container mt-4">
            <h1>Dolibarr Orders</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($orders)): ?>
                <div class="alert alert-info">
                    <?= $error ? 'No orders could be retrieved due to the error above.' : 'No orders found.' ?>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['ref'] ?? 'N/A') ?></td>
                                    <td><?= isset($order['date']) ? date('Y-m-d', strtotime($order['date'])) : 'N/A' ?></td>
                                    <td><?= htmlspecialchars($order['socname'] ?? 'N/A') ?></td>
                                    <td><?= isset($order['total_ttc']) ? number_format($order['total_ttc'], 2) : 'N/A' ?></td>
                                    <td>
                                        <?php 
                                        $status = 'Unknown';
                                        if (isset($order['status'])) {
                                            switch($order['status']) {
                                                case 0: $status = 'Draft'; break;
                                                case 1: $status = 'Validated'; break;
                                                case 2: $status = 'Processing'; break;
                                                case 3: $status = 'Delivered'; break;
                                                case 4: $status = 'Canceled'; break;
                                            }
                                        }
                                        echo $status;
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>dolibarr/order/<?= $order['id'] ?? 0 ?>" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="mt-3">
                <a href="<?= BASE_URL ?>dolibarr/status" class="btn btn-secondary">Back to Status</a>
            </div>
        </div>
        <?php
        require_once 'app/views/containers/footer.php';
    }
}
?>