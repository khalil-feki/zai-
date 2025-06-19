<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Product.php';

echo "<h2>Testing Order Placement with Real User Data</h2>";

// Initialize models
$userModel = new User();
$orderModel = new Order();
$cartModel = new Cart();
$productModel = new Product();

try {
    // Test with a real user (assuming user ID 1 exists)
    $userId = 1;
    $user = $userModel->findById($userId);
    
    if (!$user) {
        echo "<p style='color: red;'>Error: User with ID $userId not found!</p>";
        exit;
    }
    
    echo "<h3>User Information:</h3>";
    echo "<p>User ID: {$user['rowid']}</p>";
    echo "<p>Email: {$user['email']}</p>";
    $nom = $user['nom'] ?? 'Unknown User';
    echo "<p>Name: $nom</p>";
    
    // Get a test product
    $products = $productModel->findAll();
    if (empty($products)) {
        echo "<p style='color: red;'>Error: No products found!</p>";
        exit;
    }
    
    $testProduct = $products[0];
    echo "<h3>Test Product:</h3>";
    echo "<p>Product ID: {$testProduct['rowid']}</p>";
    echo "<p>Label: {$testProduct['label']}</p>";
    echo "<p>Price: {$testProduct['price']}</p>";
    
    // Clear existing cart for clean test
    $cartModel->clearCart($userId);
    echo "<p>Cleared existing cart for user.</p>";
    
    // Add product to cart
    $addResult = $cartModel->addToCart($userId, $testProduct['rowid'], 2);
    if ($addResult) {
        echo "<p style='color: green;'>Successfully added product to cart.</p>";
    } else {
        echo "<p style='color: red;'>Failed to add product to cart.</p>";
        exit;
    }
    
    // Get cart items
    $cartItems = $cartModel->getCartItems($userId);
    echo "<h3>Cart Items:</h3>";
    foreach ($cartItems as $item) {
        echo "<p>Product: {$item['label']}, Quantity: {$item['quantity']}, Price: {$item['price']}</p>";
    }
    
    // Prepare order data
    $orderData = [
        'user_id' => $userId,
        'shipping_address' => '123 Test Street, Test City, 12345',
        'billing_address' => '123 Test Street, Test City, 12345',
        'payment_method' => 'credit_card',
        'notes' => 'Test order created by automated script',
        'dolibarr_order_id' => null
    ];
    
    echo "<h3>Creating Order...</h3>";
    echo "<p>Order Data:</p>";
    echo "<pre>" . print_r($orderData, true) . "</pre>";
    
    // Transform cart items for order creation
    $orderItems = array_map(function($item) {
        return [
            'product_id' => $item['product_id'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
            'total_price' => $item['price'] * $item['quantity']
        ];
    }, $cartItems);
    
    echo "<p>Order Items:</p>";
    echo "<pre>" . print_r($orderItems, true) . "</pre>";
    
    // Create the order
    $orderId = $orderModel->createOrder($orderData, $orderItems);
    
    if ($orderId) {
        echo "<h3 style='color: green;'>Order Created Successfully!</h3>";
        echo "<p>Order ID: $orderId</p>";
        
        // Verify the order was created correctly
        $createdOrder = $orderModel->findById($orderId);
        if ($createdOrder) {
            echo "<h3>Order Details:</h3>";
            echo "<p>Reference: {$createdOrder['ref']}</p>";
            echo "<p>Client Reference: {$createdOrder['ref_client']}</p>";
            echo "<p>Society ID (fk_soc): {$createdOrder['fk_soc']}</p>";
            echo "<p>Author User ID (fk_user_author): {$createdOrder['fk_user_author']}</p>";
            echo "<p>Total HT: {$createdOrder['total_ht']}</p>";
            echo "<p>Total TTC: {$createdOrder['total_ttc']}</p>";
            echo "<p>Status: {$createdOrder['fk_statut']}</p>";
            echo "<p>Date: {$createdOrder['date_commande']}</p>";
            
            // Get order items
            $orderItems = $orderModel->getOrderItems($orderId);
            echo "<h3>Order Items:</h3>";
            foreach ($orderItems as $item) {
                echo "<p>Product: {$item['product_name']}, Quantity: {$item['qty']}, Price: {$item['price']}, Total: {$item['total_ht']}</p>";
            }
            
            // Check if cart was cleared
            $remainingCartItems = $cartModel->getCartItems($userId);
            if (empty($remainingCartItems)) {
                echo "<p style='color: green;'>Cart was successfully cleared after order creation.</p>";
            } else {
                echo "<p style='color: orange;'>Warning: Cart still contains items after order creation.</p>";
            }
        } else {
            echo "<p style='color: red;'>Error: Could not retrieve created order details.</p>";
        }
    } else {
        echo "<h3 style='color: red;'>Order Creation Failed!</h3>";
        echo "<p>Check the error logs for more details.</p>";
    }
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>Exception occurred:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h3>Recent Error Log Entries:</h3>";
if (file_exists('php_errors.log')) {
    $logContent = file_get_contents('php_errors.log');
    $logLines = explode("\n", $logContent);
    $recentLines = array_slice($logLines, -10); // Last 10 lines
    echo "<pre>" . implode("\n", $recentLines) . "</pre>";
} else {
    echo "<p>No error log file found.</p>";
}
?>