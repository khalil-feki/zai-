<?php

require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';
require_once 'app/models/Product.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize models
$cartModel = new Cart();
$orderModel = new Order();
$userModel = new User();

// Start session
session_start();

// Test user data
$userId = 1; // Assuming user ID 1 exists
$_SESSION['user_id'] = $userId;

echo "=== Starting Checkout Process Test ===\n";

try {
    // Step 1: Check database connection
    echo "\nTesting database connection...\n";
    $db = Database::getInstance()->getConnection();
    echo "Database connection successful.\n";

    // Step 2: Check cart items
    echo "\nChecking cart items...\n";
    $cartItems = $cartModel->getCartItems($userId);
    if (empty($cartItems)) {
        throw new Exception('Cart is empty. Please add items before testing checkout.');
    }

    // Debug cart items structure
    echo "\nCart items structure:\n";
    foreach ($cartItems as $index => $item) {
        echo sprintf(
            "Item %d: product_id=%s, label=%s, price=%s, quantity=%s, total_price=%s\n",
            $index + 1,
            $item['product_id'] ?? 'NOT SET',
            $item['label'] ?? 'NOT SET',
            $item['price'] ?? 'NOT SET',
            $item['quantity'] ?? 'NOT SET',
            $item['total_price'] ?? 'NOT SET'
        );
    }

    // Transform cart items to order items format
    echo "\nTransforming cart items to order format...\n";
    $orderItems = array_map(function($item) {
        return [
            'product_id' => $item['product_id'],
            'price' => $item['price'] * $item['quantity'] // Calculate total price per item including quantity
        ];
    }, $cartItems);

    // Debug order items structure
    echo "\nOrder items structure:\n";
    foreach ($orderItems as $index => $item) {
        echo sprintf(
            "Item %d: product_id=%s, price=%s\n",
            $index + 1,
            $item['product_id'],
            $item['price']
        );
    }

    // Step 3: Create order
    echo "\nAttempting to create order...\n";
    $orderId = $orderModel->createOrder($userId, $orderItems);
    
    if (!$orderId) {
        throw new Exception('Failed to create order in database');
    }
    echo "Order created successfully with ID: $orderId\n";

    // Step 4: Clear cart
    echo "\nClearing cart...\n";
    $clearResult = $cartModel->clearCart($userId);
    if (!$clearResult) {
        throw new Exception('Failed to clear cart');
    }
    echo "Cart cleared successfully\n";

    // Step 5: Verify order details
    echo "\nVerifying order details...\n";
    $orderStmt = $orderModel->getOrderDetails($orderId, $userId);
    if ($orderStmt->rowCount() === 0) {
        throw new Exception('Could not verify order details');
    }
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);
    echo "Order verification successful\n";
    echo "Order reference: " . ($order['ref'] ?? 'N/A') . "\n";
    echo "Order total: " . ($order['total_ttc'] ?? 'N/A') . "\n";

    // Step 6: Get order items
    echo "\nRetrieving order items...\n";
    $orderItems = $orderModel->getOrderItems($orderId);
    if (empty($orderItems)) {
        throw new Exception('No items found in the created order');
    }
    echo "Found " . count($orderItems) . " items in the order\n";

    // Debug order items details
    foreach ($orderItems as $index => $item) {
        echo sprintf(
            "Item %d: product_name=%s, product_ref=%s, price=%s\n",
            $index + 1,
            $item['product_name'] ?? 'N/A',
            $item['product_ref'] ?? 'N/A',
            $item['price'] ?? 'N/A'
        );
    }

    echo "\n=== Checkout Process Test Completed Successfully ===\n";
    echo "Order ID: $orderId\n";

} catch (Exception $e) {
    echo "\nERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";

    // Rollback transaction if started
    if (isset($db) && $db->inTransaction()) {
        echo "\nRolling back transaction...\n";
        $db->rollBack();
        echo "Transaction rolled back\n";
    }
}