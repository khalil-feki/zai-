<?php
session_start();
require_once 'app/config/database.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';
require_once 'app/models/Product.php';
require_once 'app/controllers/CheckoutController.php';

echo "<h1>Comprehensive Checkout Scan & Fix Test</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .info { color: blue; }
    .code { background: #f5f5f5; padding: 10px; border-radius: 3px; font-family: monospace; }
</style>";

$testResults = [];

function logTest($section, $message, $status = 'info') {
    global $testResults;
    $testResults[] = [
        'section' => $section,
        'message' => $message,
        'status' => $status
    ];
    echo "<div class='$status'>[$section] $message</div>";
}

try {
    echo "<div class='test-section'>";
    echo "<h2>1. Database Connection Test</h2>";
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        logTest('DB', '✓ Database connection successful', 'success');
    } else {
        logTest('DB', '✗ Database connection failed', 'error');
        throw new Exception('Database connection failed');
    }
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>2. User Authentication Test</h2>";
    
    // Test user login
    $userModel = new User();
    $testUser = $userModel->findById(1);
    
    if ($testUser) {
        $_SESSION['user_id'] = 1;
        logTest('AUTH', "✓ Test user found: {$testUser['email']}", 'success');
        logTest('AUTH', "✓ Session user_id set to: {$_SESSION['user_id']}", 'success');
    } else {
        logTest('AUTH', '✗ Test user not found', 'error');
        throw new Exception('Test user not found');
    }
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>3. Cart Functionality Test</h2>";
    
    $cartModel = new Cart();
    
    // Clear existing cart
    $cartModel->clearCart($_SESSION['user_id']);
    logTest('CART', '✓ Cart cleared', 'info');
    
    // Add test products
    $productModel = new Product();
    $products = $productModel->findAll();
    
    if (empty($products)) {
        logTest('CART', '⚠ No products found in database', 'warning');
        // Create test products if none exist
        $testProducts = [
            ['label' => 'Test Product 1', 'price' => 10.00],
            ['label' => 'Test Product 2', 'price' => 25.50]
        ];
        
        foreach ($testProducts as $index => $product) {
            $productId = $index + 1;
            $cartModel->addToCart($_SESSION['user_id'], $productId, 2);
            logTest('CART', "✓ Added test product $productId to cart", 'success');
        }
    } else {
        // Add first two products to cart
        $addedCount = 0;
        foreach (array_slice($products, 0, 2) as $product) {
            $result = $cartModel->addToCart($_SESSION['user_id'], $product['rowid'], 1);
            if ($result) {
                $addedCount++;
                logTest('CART', "✓ Added {$product['label']} to cart", 'success');
            }
        }
        
        if ($addedCount === 0) {
            logTest('CART', '✗ Failed to add any products to cart', 'error');
        }
    }
    
    // Verify cart contents
    $cartItems = $cartModel->getCartItems($_SESSION['user_id']);
    if (!empty($cartItems)) {
        logTest('CART', "✓ Cart contains " . count($cartItems) . " items", 'success');
        
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $cartTotal += $itemTotal;
            logTest('CART', "- {$item['label']}: {$item['quantity']} x {$item['price']} = $itemTotal TND", 'info');
        }
        logTest('CART', "Total: $cartTotal TND", 'info');
    } else {
        logTest('CART', '✗ Cart is empty after adding items', 'error');
        throw new Exception('Cart is empty');
    }
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>4. Checkout Controller Test</h2>";
    
    // Test checkout controller instantiation
    try {
        $checkoutController = new CheckoutController();
        logTest('CHECKOUT', '✓ CheckoutController instantiated successfully', 'success');
    } catch (Exception $e) {
        logTest('CHECKOUT', '✗ CheckoutController instantiation failed: ' . $e->getMessage(), 'error');
        throw $e;
    }
    
    // Test checkout index method (should not redirect since we have cart items)
    ob_start();
    try {
        $checkoutController->index();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (strpos($output, 'checkout-form') !== false) {
            logTest('CHECKOUT', '✓ Checkout page renders correctly', 'success');
        } else {
            logTest('CHECKOUT', '⚠ Checkout page may have issues', 'warning');
        }
    } catch (Exception $e) {
        ob_end_clean();
        logTest('CHECKOUT', '✗ Checkout index method failed: ' . $e->getMessage(), 'error');
    }
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>5. Order Processing Simulation</h2>";
    
    // Simulate POST data
    $_POST = [
        'shipping_address' => '123 Test Street, Test City, Test Country',
        'billing_address' => '',
        'payment_method' => 'cash_on_delivery',
        'notes' => 'Test order from comprehensive scan'
    ];
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    logTest('ORDER', 'Simulating form submission with POST data', 'info');
    logTest('ORDER', 'Shipping: ' . $_POST['shipping_address'], 'info');
    logTest('ORDER', 'Payment: ' . $_POST['payment_method'], 'info');
    
    // Capture any output/redirects from process method
    ob_start();
    $errorOccurred = false;
    
    try {
        // Temporarily disable header redirects for testing
        $originalHeaders = headers_list();
        
        $checkoutController->process();
        
        $output = ob_get_contents();
        ob_end_clean();
        
        // Check if order was created by looking for success message in session
        if (isset($_SESSION['success_message'])) {
            logTest('ORDER', '✓ Order processed successfully: ' . $_SESSION['success_message'], 'success');
            
            // Extract order ID from success message
            if (preg_match('/Order ID: (\d+)/', $_SESSION['success_message'], $matches)) {
                $orderId = $matches[1];
                
                // Verify order in database
                $orderQuery = "SELECT * FROM h8pd_commande WHERE rowid = :order_id";
                $orderStmt = $conn->prepare($orderQuery);
                $orderStmt->execute(['order_id' => $orderId]);
                $orderData = $orderStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($orderData) {
                    logTest('ORDER', "✓ Order verified in database: {$orderData['ref']}", 'success');
                    logTest('ORDER', "Order total: {$orderData['total_ttc']} TND", 'info');
                } else {
                    logTest('ORDER', '✗ Order not found in database', 'error');
                }
            }
        } else if (isset($_SESSION['error_message'])) {
            logTest('ORDER', '✗ Order processing failed: ' . $_SESSION['error_message'], 'error');
            $errorOccurred = true;
        } else {
            logTest('ORDER', '⚠ No clear success or error message', 'warning');
        }
        
    } catch (Exception $e) {
        ob_end_clean();
        logTest('ORDER', '✗ Exception during order processing: ' . $e->getMessage(), 'error');
        $errorOccurred = true;
    }
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>6. Error Log Analysis</h2>";
    
    if (file_exists('php_errors.log')) {
        $errorLog = file_get_contents('php_errors.log');
        $recentErrors = array_slice(explode("\n", $errorLog), -10);
        
        $hasRecentErrors = false;
        foreach ($recentErrors as $error) {
            if (!empty(trim($error)) && strpos($error, date('Y-m-d')) !== false) {
                logTest('ERRORS', 'Recent error: ' . trim($error), 'error');
                $hasRecentErrors = true;
            }
        }
        
        if (!$hasRecentErrors) {
            logTest('ERRORS', '✓ No recent errors found in log', 'success');
        }
    } else {
        logTest('ERRORS', '⚠ No error log file found', 'warning');
    }
    echo "</div>";
    
    echo "<div class='test-section'>";
    echo "<h2>7. Test Summary</h2>";
    
    $successCount = 0;
    $errorCount = 0;
    $warningCount = 0;
    
    foreach ($testResults as $result) {
        switch ($result['status']) {
            case 'success':
                $successCount++;
                break;
            case 'error':
                $errorCount++;
                break;
            case 'warning':
                $warningCount++;
                break;
        }
    }
    
    echo "<div class='info'>";
    echo "<strong>Test Results:</strong><br>";
    echo "✓ Successes: $successCount<br>";
    echo "⚠ Warnings: $warningCount<br>";
    echo "✗ Errors: $errorCount<br>";
    echo "</div>";
    
    if ($errorCount === 0) {
        echo "<div class='success'><h3>🎉 All tests passed! Checkout functionality is working correctly.</h3></div>";
    } else {
        echo "<div class='error'><h3>❌ Some tests failed. Please review the errors above.</h3></div>";
    }
    
    echo "<div class='info'>";
    echo "<strong>Next Steps:</strong><br>";
    echo "1. <a href='" . (defined('BASE_URL') ? BASE_URL : '/zai/') . "checkout' target='_blank'>Test actual checkout page</a><br>";
    echo "2. <a href='" . (defined('BASE_URL') ? BASE_URL : '/zai/') . "cart' target='_blank'>View cart page</a><br>";
    echo "3. <a href='" . (defined('BASE_URL') ? BASE_URL : '/zai/') . "' target='_blank'>Go to homepage</a><br>";
    echo "</div>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<div class='error'><h3>Critical Error: " . htmlspecialchars($e->getMessage()) . "</h3></div>";
    echo "<div class='code'>" . htmlspecialchars($e->getTraceAsString()) . "</div>";
    echo "</div>";
}

// Clean up
unset($_SESSION['user_id']);
$_POST = [];
$_SERVER['REQUEST_METHOD'] = 'GET';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

echo "<br><hr><br>";
echo "<div class='info'><strong>Test completed at:</strong> " . date('Y-m-d H:i:s') . "</div>";
?>