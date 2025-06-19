<?php
require_once 'app/config/database.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';

echo "<h2>Order Placement Fix Verification</h2>";
echo "<style>body{font-family:Arial,sans-serif;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

try {
    // Test database connection
    $database = new Database();
    $conn = $database->getConnection();
    echo "<span class='success'>✓ Database connection successful</span><br>";
    
    // Test user lookup
    $userId = 1;
    $userModel = new User();
    $user = $userModel->findById($userId);
    
    if ($user) {
        echo "<span class='success'>✓ User found: {$user['email']}</span><br>";
    } else {
        echo "<span class='error'>✗ User not found</span><br>";
        exit;
    }
    
    // Create test order items
    $testItems = [
        [
            'product_id' => 1,
            'quantity' => 2,
            'price' => 15.50,
            'total_price' => 31.00
        ],
        [
            'product_id' => 2,
            'quantity' => 1,
            'price' => 25.00
            // Note: no total_price to test calculation
        ]
    ];
    
    echo "<span class='info'>Testing order creation with " . count($testItems) . " items...</span><br>";
    
    // Create order
    $orderModel = new Order();
    $orderId = $orderModel->createOrder($userId, $testItems);
    
    if ($orderId) {
        echo "<span class='success'>✓ Order created successfully! Order ID: $orderId</span><br>";
        
        // Verify order in database
        $orderQuery = "SELECT ref, fk_soc, total_ht, total_ttc, note_private FROM h8pd_commande WHERE rowid = :order_id";
        $orderStmt = $conn->prepare($orderQuery);
        $orderStmt->execute(['order_id' => $orderId]);
        $orderData = $orderStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($orderData) {
            echo "<div style='margin:10px 0; padding:10px; background:#f0f8ff; border:1px solid #ccc;'>";
            echo "<strong>Order Details:</strong><br>";
            echo "Reference: {$orderData['ref']}<br>";
            echo "Society ID: {$orderData['fk_soc']}<br>";
            echo "Total HT: {$orderData['total_ht']}<br>";
            echo "Total TTC: {$orderData['total_ttc']}<br>";
            echo "Notes: " . substr($orderData['note_private'], 0, 100) . "...<br>";
            echo "</div>";
            
            // Check order items
            $itemsQuery = "SELECT fk_product, price, qty, total_ht FROM h8pd_commandedet WHERE fk_commande = :order_id";
            $itemsStmt = $conn->prepare($itemsQuery);
            $itemsStmt->execute(['order_id' => $orderId]);
            $orderItems = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<strong>Order Items (" . count($orderItems) . "):</strong><br>";
            foreach ($orderItems as $item) {
                echo "- Product {$item['fk_product']}: {$item['qty']} x {$item['price']} = {$item['total_ht']}<br>";
            }
            
            echo "<span class='success'>✓ Order verification complete!</span><br>";
        } else {
            echo "<span class='error'>✗ Order not found in database</span><br>";
        }
    } else {
        echo "<span class='error'>✗ Order creation failed</span><br>";
    }
    
} catch (Exception $e) {
    echo "<span class='error'>✗ Exception: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

// Show recent error logs
echo "<h3>Recent Error Logs:</h3>";
if (file_exists('php_errors.log')) {
    $logs = file_get_contents('php_errors.log');
    $recentLogs = array_slice(explode("\n", $logs), -10); // Last 10 lines
    echo "<pre style='background:#f5f5f5;padding:10px;'>" . htmlspecialchars(implode("\n", $recentLogs)) . "</pre>";
} else {
    echo "<p>No error log file found.</p>";
}
?>