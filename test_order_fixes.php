<?php
/**
 * Test Script for Order Placement Fixes
 * Tests all the issues identified by the AI expert
 */

require_once 'app/config/database.php';
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Product.php';

echo "=== Order Placement Fixes Test ===\n\n";

try {
    // Test 1: Check decimal precision in database
    echo "1. Testing decimal precision...\n";
    $pdo = new PDO($dsn, $username, $password, $options);
    
    $result = $pdo->query("DESCRIBE h8pd_product");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if (in_array($column['Field'], ['price', 'price_ttc', 'price_min', 'price_min_ttc'])) {
            echo "   {$column['Field']}: {$column['Type']}\n";
        }
    }
    
    $result = $pdo->query("DESCRIBE h8pd_commande");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if (in_array($column['Field'], ['total_ht', 'total_ttc'])) {
            echo "   commande.{$column['Field']}: {$column['Type']}\n";
        }
    }
    
    // Test 2: Order reference generation
    echo "\n2. Testing order reference generation...\n";
    $orderModel = new Order();
    
    for ($i = 0; $i < 5; $i++) {
        $ref = $orderModel->getNextOrderNumber();
        echo "   Generated reference: $ref\n";
        usleep(100000); // 100ms delay to ensure different timestamps
    }
    
    // Test 3: Create test order with proper data
    echo "\n3. Testing order creation with sample data...\n";
    
    // Sample order items with proper decimal precision
    $testItems = [
        [
            'product_id' => 1,
            'price' => 199.99,
            'quantity' => 2,
            'total_price' => 399.98
        ],
        [
            'product_id' => 2,
            'price' => 49.50,
            'quantity' => 1,
            'total_price' => 49.50
        ]
    ];
    
    $testUserId = 1; // Assuming user ID 1 exists
    
    echo "   Creating test order...\n";
    $orderId = $orderModel->createOrder($testUserId, $testItems);
    
    if ($orderId) {
        echo "   ✅ Order created successfully with ID: $orderId\n";
        
        // Verify order data
        $orderDetails = $pdo->prepare("SELECT * FROM h8pd_commande WHERE rowid = ?");
        $orderDetails->execute([$orderId]);
        $order = $orderDetails->fetch(PDO::FETCH_ASSOC);
        
        echo "   Order Reference: {$order['ref']}\n";
        echo "   Total HT: {$order['total_ht']}\n";
        echo "   Total TTC: {$order['total_ttc']}\n";
        
        // Verify order items
        $orderItems = $pdo->prepare("SELECT * FROM h8pd_commandedet WHERE fk_commande = ?");
        $orderItems->execute([$orderId]);
        $items = $orderItems->fetchAll(PDO::FETCH_ASSOC);
        
        echo "   Order Items Count: " . count($items) . "\n";
        foreach ($items as $item) {
            echo "     - Product {$item['fk_product']}: Qty {$item['qty']}, Price {$item['price']}, Total {$item['total_ht']}\n";
        }
        
    } else {
        echo "   ❌ Order creation failed\n";
    }
    
    // Test 4: Check for any remaining issues
    echo "\n4. Checking for potential issues...\n";
    
    // Check if total_ht is properly set
    $ordersWithoutTotalHt = $pdo->query("SELECT COUNT(*) as count FROM h8pd_commande WHERE total_ht = 0 AND total_ttc > 0");
    $count = $ordersWithoutTotalHt->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($count > 0) {
        echo "   ⚠️  Warning: $count orders have total_ttc but no total_ht\n";
    } else {
        echo "   ✅ All orders have proper total_ht values\n";
    }
    
    echo "\n=== Test Completed ===\n";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>