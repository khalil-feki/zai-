<?php
require_once 'app/config/database.php';
require_once 'app/models/Order.php';

try {
    // Test database connection
    $database = new Database();
    $conn = $database->getConnection();
    echo "✅ Database connected\n";
    
    // Initialize Order model
    $orderModel = new Order($conn);
    
    // Test data
    $userId = 9;
    $items = [
        [
            'product_id' => 1568,
            'quantity' => 1,
            'price' => 4.00,
            'total_price' => 4.00
        ]
    ];
    
    echo "🚀 Testing order creation with fixed parameters...\n";
    
    // Attempt to create order
    $result = $orderModel->createOrder($userId, $items, null, 'Test order - parameter fix', 'Test order');
    
    if ($result) {
        echo "✅ Order created successfully! Order ID: $result\n";
    } else {
        echo "❌ Order creation failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "📁 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
}

echo "\n🏁 Test completed\n";
?>