<?php
require_once 'app/config/config.php';
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';
require_once 'app/models/User.php';

echo "<h2>Debug Checkout Process</h2>";

try {
    // Test database connection
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✅ Database connected<br>";
    
    // Initialize models
    $orderModel = new Order($pdo);
    $cartModel = new Cart($pdo);
    $userModel = new User($pdo);
    
    // Test with user ID 9 (from console log)
    $userId = 9;
    echo "🔍 Testing with User ID: $userId<br>";
    
    // Check if user exists
    $user = $userModel->findById($userId);
    if ($user) {
        echo "✅ User found: " . $user['email'] . "<br>";
    } else {
        echo "❌ User not found<br>";
        exit;
    }
    
    // Get cart items
    $cartItems = $cartModel->getCartItems($userId);
    echo "📦 Cart items: " . count($cartItems) . "<br>";
    
    if (empty($cartItems)) {
        echo "⚠️ Cart is empty, adding test item...<br>";
        $cartModel->addToCart($userId, 1, 1); // Add product 1, quantity 1
        $cartItems = $cartModel->getCartItems($userId);
        echo "📦 Cart items after adding: " . count($cartItems) . "<br>";
    }
    
    if (!empty($cartItems)) {
        // Display cart contents
        foreach ($cartItems as $item) {
            echo "📋 Item: Product ID {$item['product_id']}, Qty: {$item['quantity']}, Price: {$item['price']}<br>";
        }
        
        // Transform cart items for order
        $orderItems = array_map(function($item) {
            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity']
            ];
        }, $cartItems);
        
        // Create test notes
        $notePrivate = 'Debug test order\nShipping: Test Address\nPayment: Test Payment';
        $notePublic = 'Debug web order';
        
        echo "🚀 Attempting to create order...<br>";
        
        // Create order
        $orderId = $orderModel->createOrder($userId, $orderItems, null, $notePrivate, $notePublic);
        
        if ($orderId) {
            echo "✅ Order created successfully! Order ID: $orderId<br>";
            
            // Get order details
            $orderDetails = $orderModel->getOrderDetails($orderId);
            if ($orderDetails) {
                echo "📄 Order Reference: " . $orderDetails['ref'] . "<br>";
                echo "💰 Order Total: " . $orderDetails['total_ttc'] . " TND<br>";
            }
        } else {
            echo "❌ Order creation failed<br>";
            echo "📋 Check error logs for details<br>";
        }
    } else {
        echo "❌ No items in cart after adding test item<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "<br>";
    echo "🔍 Stack trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<br>🏁 Debug completed";
?>