<?php
session_start();
require_once 'app/config/database.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';
require_once 'app/models/Product.php';

echo "<h2>Complete Order Flow Test</h2>";
echo "<style>body{font-family:Arial,sans-serif;} .success{color:green;} .error{color:red;} .info{color:blue;} .step{margin:20px 0; padding:15px; background:#f9f9f9; border-left:4px solid #007cba;}</style>";

try {
    // Step 1: Setup test user session
    echo "<div class='step'>";
    echo "<h3>Step 1: Setup Test User Session</h3>";
    
    $userId = 1;
    $_SESSION['user_id'] = $userId;
    
    $userModel = new User();
    $user = $userModel->findById($userId);
    
    if ($user) {
        echo "<span class='success'>✓ User session setup: {$user['email']}</span><br>";
    } else {
        echo "<span class='error'>✗ User not found</span><br>";
        exit;
    }
    echo "</div>";
    
    // Step 2: Add items to cart
    echo "<div class='step'>";
    echo "<h3>Step 2: Add Items to Cart</h3>";
    
    $cartModel = new Cart();
    
    // Clear existing cart first
    $cartModel->clearCart($userId);
    echo "<span class='info'>Cart cleared</span><br>";
    
    // Add test products to cart
    $testProducts = [
        ['product_id' => 1, 'quantity' => 2],
        ['product_id' => 2, 'quantity' => 1]
    ];
    
    foreach ($testProducts as $product) {
        $result = $cartModel->addToCart($userId, $product['product_id'], $product['quantity']);
        if ($result) {
            echo "<span class='success'>✓ Added product {$product['product_id']} (qty: {$product['quantity']}) to cart</span><br>";
        } else {
            echo "<span class='error'>✗ Failed to add product {$product['product_id']} to cart</span><br>";
        }
    }
    echo "</div>";
    
    // Step 3: Get cart items (simulate checkout page)
    echo "<div class='step'>";
    echo "<h3>Step 3: Retrieve Cart Items</h3>";
    
    $cartItems = $cartModel->getCartItems($userId);
    
    if (!empty($cartItems)) {
        echo "<span class='success'>✓ Found " . count($cartItems) . " items in cart</span><br>";
        
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $cartTotal += $itemTotal;
            echo "- {$item['label']}: {$item['quantity']} x {$item['price']} = {$itemTotal} TND<br>";
        }
        echo "<strong>Cart Total: {$cartTotal} TND</strong><br>";
    } else {
        echo "<span class='error'>✗ Cart is empty</span><br>";
        exit;
    }
    echo "</div>";
    
    // Step 4: Simulate checkout form data
    echo "<div class='step'>";
    echo "<h3>Step 4: Simulate Checkout Process</h3>";
    
    // Simulate POST data
    $_POST['shipping_address'] = '123 Test Street, Test City, Test Country';
    $_POST['billing_address'] = '';
    $_POST['payment_method'] = 'cash_on_delivery';
    $_POST['notes'] = 'Test order from automated test';
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    echo "<span class='info'>Simulated form data:</span><br>";
    echo "- Shipping: {$_POST['shipping_address']}<br>";
    echo "- Payment: {$_POST['payment_method']}<br>";
    echo "- Notes: {$_POST['notes']}<br>";
    echo "</div>";
    
    // Step 5: Process order (simulate CheckoutController logic)
    echo "<div class='step'>";
    echo "<h3>Step 5: Process Order</h3>";
    
    $shippingAddress = trim($_POST['shipping_address']);
    $billingAddress = trim($_POST['billing_address']);
    $paymentMethod = $_POST['payment_method'];
    $notes = trim($_POST['notes']);
    
    // If billing address is empty, use shipping address
    if (empty($billingAddress)) {
        $billingAddress = $shippingAddress;
    }
    
    // Transform cart items to order items format
    $orderItems = array_map(function($item) {
        return [
            'product_id' => $item['product_id'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'total_price' => $item['price'] * $item['quantity']
        ];
    }, $cartItems);
    
    // Create notes
    $notePrivate = 'Order created from web application';
    $notePrivate .= '\nShipping: ' . $shippingAddress;
    if ($billingAddress !== $shippingAddress) {
        $notePrivate .= '\nBilling: ' . $billingAddress;
    }
    $notePrivate .= '\nPayment: ' . $paymentMethod;
    if (!empty($notes)) {
        $notePrivate .= '\nCustomer Notes: ' . $notes;
    }
    
    $notePublic = 'Web order';
    if (!empty($notes)) {
        $notePublic .= ' - ' . $notes;
    }
    
    // Create the order
    $orderModel = new Order();
    $orderId = $orderModel->createOrder($userId, $orderItems, null, $notePrivate, $notePublic);
    
    if ($orderId) {
        echo "<span class='success'>✓ Order created successfully! Order ID: $orderId</span><br>";
        
        // Verify order details
        $database = new Database();
        $conn = $database->getConnection();
        
        $orderQuery = "SELECT ref, fk_soc, total_ht, total_ttc, note_private, note_public FROM h8pd_commande WHERE rowid = :order_id";
        $orderStmt = $conn->prepare($orderQuery);
        $orderStmt->execute(['order_id' => $orderId]);
        $orderData = $orderStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($orderData) {
            echo "<div style='margin:10px 0; padding:10px; background:#e8f5e8; border:1px solid #4caf50;'>";
            echo "<strong>Order Created Successfully:</strong><br>";
            echo "Reference: {$orderData['ref']}<br>";
            echo "Society ID: {$orderData['fk_soc']}<br>";
            echo "Total: {$orderData['total_ttc']} TND<br>";
            echo "Private Notes: " . substr($orderData['note_private'], 0, 100) . "...<br>";
            echo "</div>";
            
            // Check if cart was cleared
            $remainingItems = $cartModel->getCartItems($userId);
            if (empty($remainingItems)) {
                echo "<span class='success'>✓ Cart cleared successfully</span><br>";
            } else {
                echo "<span class='error'>✗ Cart was not cleared (" . count($remainingItems) . " items remaining)</span><br>";
            }
        }
    } else {
        echo "<span class='error'>✗ Order creation failed</span><br>";
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h3>Test Summary</h3>";
    if ($orderId) {
        echo "<span class='success'>✓ Complete order flow test PASSED</span><br>";
        echo "<span class='info'>Order placement functionality is working correctly!</span><br>";
    } else {
        echo "<span class='error'>✗ Complete order flow test FAILED</span><br>";
    }
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='step'>";
    echo "<span class='error'>✗ Exception occurred: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}

// Clean up session
unset($_SESSION['user_id']);
$_POST = [];
$_SERVER['REQUEST_METHOD'] = 'GET';

echo "<h3>Recent Error Logs:</h3>";
if (file_exists('php_errors.log')) {
    $logs = file_get_contents('php_errors.log');
    $recentLogs = array_slice(explode("\n", $logs), -5); // Last 5 lines
    echo "<pre style='background:#f5f5f5;padding:10px;'>" . htmlspecialchars(implode("\n", $recentLogs)) . "</pre>";
} else {
    echo "<p>No error log file found.</p>";
}
?>