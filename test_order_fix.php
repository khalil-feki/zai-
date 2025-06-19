<?php
require_once 'app/config/config.php';
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';
require_once 'app/models/User.php';

echo "<h2>Testing Order Creation Fix</h2>";

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
    
    // Test user ID (assuming user 12 exists)
    $userId = 12;
    
    // Clear any existing cart
    $cartModel->clearCart($userId);
    echo "🧹 Cart cleared<br>";
    
    // Add test items to cart
    $cartModel->addToCart($userId, 1, 2); // Product 1, quantity 2
    echo "✅ Added product to cart<br>";
    
    // Get cart items
    $cartItems = $cartModel->getCartItems($userId);
    echo "📦 Cart items: " . count($cartItems) . "<br>";
    
    if (!empty($cartItems)) {
        // Transform cart items for order
        $orderItems = array_map(function($item) {
            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity']
            ];
        }, $cartItems);
        
        echo "📋 Order items prepared<br>";
        
        // Create order with notes
        $notePrivate = 'Test order from fix script\nShipping: Test Address\nPayment: Cash on Delivery';
        $orderId = $orderModel->createOrder($userId, $orderItems, null, $notePrivate);
        
        if ($orderId) {
            echo "✅ Order created successfully! Order ID: $orderId<br>";
            
            // Get order details
            $orderDetails = $orderModel->getOrderDetails($orderId);
            if ($orderDetails) {
                echo "📄 Order Reference: " . $orderDetails['ref'] . "<br>";
                echo "💰 Order Total: " . $orderDetails['total_ttc'] . " TND<br>";
                echo "📝 Notes: " . substr($orderDetails['note_private'], 0, 50) . "...<br>";
            }
        } else {
            echo "❌ Order creation failed<br>";
        }
    } else {
        echo "❌ No items in cart<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "<br>";
}

echo "<br>🏁 Test completed";
?>