<?php
require_once 'app/config/database.php';
require_once 'app/models/Order.php';

// Clear any previous output
ob_clean();

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<h2>Order Creation Test</h2>";
    echo "<p>Testing with fixed parameter binding...</p>";
    
    // Test with user ID 1
    $userId = 1;
    
    // Check if user exists
    $userCheck = $conn->prepare("SELECT rowid, email FROM h8pd_societe WHERE rowid = :user_id");
    $userCheck->execute([':user_id' => $userId]);
    $user = $userCheck->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo "<p style='color:red'>User ID $userId not found</p>";
        exit;
    }
    
    echo "<p style='color:green'>User found: ID {$user['rowid']}, Email: {$user['email']}</p>";
    
    // Create test cart items
    $testItems = [
        [
            'product_id' => 1,
            'quantity' => 1,
            'price' => 10.00,
            'label' => 'Test Product'
        ]
    ];
    
    // Create order
    $order = new Order($conn);
    echo "<p>Attempting to create order...</p>";
    
    $orderId = $order->createOrder($userId, $testItems);
    
    if ($orderId) {
        echo "<p style='color:green'><strong>SUCCESS: Order created with ID: $orderId</strong></p>";
        
        // Verify in database
        $verify = $conn->prepare("SELECT ref, fk_soc, note_private FROM h8pd_commande WHERE rowid = :id");
        $verify->execute([':id' => $orderId]);
        $orderData = $verify->fetch(PDO::FETCH_ASSOC);
        
        if ($orderData) {
            echo "<p>Order verified:</p>";
            echo "<ul>";
            echo "<li>Reference: {$orderData['ref']}</li>";
            echo "<li>Society ID: {$orderData['fk_soc']}</li>";
            echo "<li>User Email: {$orderData['note_private']}</li>";
            echo "</ul>";
        }
    } else {
        echo "<p style='color:red'><strong>FAILED: Order creation returned false</strong></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'><strong>ERROR: " . htmlspecialchars($e->getMessage()) . "</strong></p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

// Show recent error logs
echo "<h3>Recent Error Logs:</h3>";
if (file_exists('php_errors.log')) {
    $logs = file_get_contents('php_errors.log');
    echo "<pre>" . htmlspecialchars($logs) . "</pre>";
} else {
    echo "<p>No error log file found.</p>";
}
?>