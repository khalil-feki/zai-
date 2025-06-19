<?php
require_once 'app/config/database.php';
require_once 'app/models/User.php';
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';

echo "<h2>Testing Order Placement Fix</h2>";

try {
    // Test 1: Check if models load correctly
    echo "<h3>Test 1: Model Loading</h3>";
    $userModel = new User();
    $orderModel = new Order();
    $cartModel = new Cart();
    echo "<p style='color:green'>✓ All models loaded successfully</p>";
    
    // Test 2: Check if we can find a test user
    echo "<h3>Test 2: User Lookup</h3>";
    $testUser = $userModel->findById(1);
    if ($testUser) {
        echo "<p style='color:green'>✓ Found test user: " . htmlspecialchars($testUser['nom']) . " (" . htmlspecialchars($testUser['email']) . ")</p>";
        
        // Test 3: Simulate order creation with minimal data
        echo "<h3>Test 3: Order Creation Simulation</h3>";
        
        // Create test cart items
        $testCartItems = [
            [
                'product_id' => 1,
                'label' => 'Test Product',
                'price' => 10.00,
                'quantity' => 2
            ]
        ];
        
        $testOrderData = [
            'shipping_address' => 'Test Address 123',
            'billing_address' => 'Test Address 123',
            'payment_method' => 'credit_card',
            'notes' => 'Test order for debugging'
        ];
        
        echo "<p>Attempting to create test order...</p>";
        
        try {
            $orderId = $orderModel->createOrder($testUser['rowid'], $testCartItems, $testOrderData);
            if ($orderId) {
                echo "<p style='color:green'>✓ Order created successfully with ID: $orderId</p>";
                
                // Verify the order was created
                $createdOrder = $orderModel->findById($orderId);
                if ($createdOrder) {
                    echo "<p style='color:green'>✓ Order verification successful</p>";
                    echo "<p>Order Reference: " . htmlspecialchars($createdOrder['ref']) . "</p>";
                    echo "<p>Order Total: " . htmlspecialchars($createdOrder['total_ttc']) . "</p>";
                } else {
                    echo "<p style='color:orange'>⚠ Order created but verification failed</p>";
                }
            } else {
                echo "<p style='color:red'>✗ Order creation failed</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color:red'>✗ Order creation exception: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
    } else {
        echo "<p style='color:red'>✗ No test user found with ID 1</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Test failed with exception: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h3>Test Complete</h3>";
?>