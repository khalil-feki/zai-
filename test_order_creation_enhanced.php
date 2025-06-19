<?php
require_once 'app/config/database.php';
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';
require_once 'app/models/User.php';

echo "<h2>Enhanced Order Creation Test Script</h2>";
echo "<pre>";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Test 1: Database Connection
    echo "\n=== Test 1: Database Connection ===\n";
    $database = new Database();
    $conn = $database->getConnection();
    if ($conn) {
        echo "✓ Database connection successful\n";
    } else {
        echo "✗ Database connection failed\n";
        exit;
    }

    // Test 2: Detailed Order Creation with Error Logging
    echo "\n=== Test 2: Detailed Order Creation ===\n";
    
    // Get a test user with valid society mapping
    $testUserQuery = "SELECT u.rowid as user_id, s.rowid as societe_id, s.nom as company_name
                      FROM h8pd_societe u 
                      JOIN h8pd_societe s ON u.rowid = s.rowid 
                      WHERE u.rowid = 3";
    $testUserStmt = $conn->prepare($testUserQuery);
    $testUserStmt->execute();
    $testUser = $testUserStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$testUser) {
        echo "✗ User ID 3 has no valid society mapping\n";
        exit;
    }
    
    echo "✓ User ID 3 mapped to Society ID {$testUser['societe_id']} ({$testUser['company_name']})\n";
    
    // Test 3: Verify Society Record
    echo "\n=== Test 3: Society Record Verification ===\n";
    $societeQuery = "SELECT * FROM h8pd_societe WHERE rowid = :societe_id";
    $societeStmt = $conn->prepare($societeQuery);
    $societeStmt->bindParam(':societe_id', $testUser['societe_id'], PDO::PARAM_INT);
    $societeStmt->execute();
    $societeData = $societeStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($societeData) {
        echo "✓ Society record exists:\n";
        echo "  - ID: {$societeData['rowid']}\n";
        echo "  - Name: {$societeData['nom']}\n";
        echo "  - Status: {$societeData['status']}\n";
    } else {
        echo "✗ Society record not found\n";
    }
    
    // Test 4: Create Test Items with Proper Structure
    echo "\n=== Test 4: Test Items Preparation ===\n";
    $testItems = [
        [
            'product_id' => 1,
            'quantity' => 2,
            'price' => 25.50,
            'label' => 'Test Product 1'
        ],
        [
            'product_id' => 2,
            'quantity' => 1,
            'price' => 15.75,
            'label' => 'Test Product 2'
        ]
    ];
    
    echo "✓ Test items prepared:\n";
    foreach ($testItems as $item) {
        echo "  - Product ID: {$item['product_id']}, Qty: {$item['quantity']}, Price: {$item['price']}\n";
    }
    
    // Test 5: Verify Products Exist
    echo "\n=== Test 5: Product Verification ===\n";
    foreach ($testItems as $item) {
        $productQuery = "SELECT rowid, label, price FROM h8pd_product WHERE rowid = :product_id";
        $productStmt = $conn->prepare($productQuery);
        $productStmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
        $productStmt->execute();
        $productData = $productStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($productData) {
            echo "✓ Product {$item['product_id']} exists: {$productData['label']}\n";
        } else {
            echo "✗ Product {$item['product_id']} not found\n";
        }
    }
    
    // Test 6: Order Creation with Detailed Error Handling
    echo "\n=== Test 6: Order Creation with Error Details ===\n";
    
    $userId = $testUser['user_id'];
    $testAddress = 'Test Address, Test City, Test Country';
    
    echo "Attempting to create order for User ID: $userId\n";
    echo "Address: $testAddress\n";
    echo "Items count: " . count($testItems) . "\n";
    
    // Clear any previous error logs
    error_clear_last();
    
    // Create order with detailed logging
    $order = new Order($conn);
    
    // Capture any PHP errors
    ob_start();
    $orderId = $order->createOrder($userId, $testItems, $testAddress);
    $output = ob_get_clean();
    
    if ($output) {
        echo "PHP Output during order creation: $output\n";
    }
    
    $lastError = error_get_last();
    if ($lastError) {
        echo "Last PHP Error: {$lastError['message']} in {$lastError['file']} on line {$lastError['line']}\n";
    }
    
    if ($orderId) {
        echo "✓ Order created successfully with ID: $orderId\n";
        
        // Verify order in database
        $verifyQuery = "SELECT * FROM h8pd_commande WHERE rowid = :order_id";
        $verifyStmt = $conn->prepare($verifyQuery);
        $verifyStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $verifyStmt->execute();
        $orderData = $verifyStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($orderData) {
            echo "✓ Order verified in database:\n";
            echo "  - Reference: {$orderData['ref']}\n";
            echo "  - Society ID: {$orderData['fk_soc']}\n";
            echo "  - Total HT: {$orderData['total_ht']}\n";
            echo "  - Total TTC: {$orderData['total_ttc']}\n";
        }
    } else {
        echo "✗ Order creation failed\n";
        
        // Check error logs
        echo "\n=== Error Log Analysis ===\n";
        
        // Try to get more specific error information
        $errorInfo = $conn->errorInfo();
        if ($errorInfo[0] !== '00000') {
            echo "Database Error: {$errorInfo[2]}\n";
        }
        
        // Check if it's a constraint violation
        echo "\nTesting constraint violations:\n";
        
        // Test 1: Check if user exists
        $userCheckQuery = "SELECT rowid FROM h8pd_societe WHERE rowid = :user_id";
        $userCheckStmt = $conn->prepare($userCheckQuery);
        $userCheckStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $userCheckStmt->execute();
        if ($userCheckStmt->rowCount() > 0) {
            echo "✓ User $userId exists\n";
        } else {
            echo "✗ User $userId does not exist\n";
        }
        
        // Test 2: Check if society exists
        $socCheckQuery = "SELECT rowid FROM h8pd_societe WHERE rowid = :soc_id";
        $socCheckStmt = $conn->prepare($socCheckQuery);
        $socCheckStmt->bindParam(':soc_id', $testUser['societe_id'], PDO::PARAM_INT);
        $socCheckStmt->execute();
        if ($socCheckStmt->rowCount() > 0) {
            echo "✓ Society {$testUser['societe_id']} exists\n";
        } else {
            echo "✗ Society {$testUser['societe_id']} does not exist\n";
        }
    }
    
    // Test 7: Manual Order Insertion Test
    echo "\n=== Test 7: Manual Order Insertion ===\n";
    
    try {
        $conn->beginTransaction();
        
        $manualQuery = "INSERT INTO h8pd_commande (
            ref, entity, fk_soc, fk_user_author, date_creation, date_commande,
            total_ht, total_tva, total_ttc, amount_ht, fk_statut
        ) VALUES (
            'TEST-001', 1, :soc_id, :user_id, NOW(), CURDATE(),
            50.00, 11.25, 61.25, 50.00, 1
        )";
        
        $manualStmt = $conn->prepare($manualQuery);
        $manualStmt->bindParam(':soc_id', $testUser['societe_id'], PDO::PARAM_INT);
        $manualStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        
        if ($manualStmt->execute()) {
            $manualOrderId = $conn->lastInsertId();
            echo "✓ Manual order insertion successful: ID $manualOrderId\n";
            
            // Clean up test order
            $cleanupQuery = "DELETE FROM h8pd_commande WHERE rowid = :order_id";
            $cleanupStmt = $conn->prepare($cleanupQuery);
            $cleanupStmt->bindParam(':order_id', $manualOrderId, PDO::PARAM_INT);
            $cleanupStmt->execute();
            echo "✓ Test order cleaned up\n";
        } else {
            echo "✗ Manual order insertion failed\n";
            $errorInfo = $manualStmt->errorInfo();
            echo "Error: {$errorInfo[2]}\n";
        }
        
        $conn->rollback();
        
    } catch (Exception $e) {
        $conn->rollback();
        echo "✗ Manual insertion error: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "\n✗ Critical error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Enhanced Test Complete ===\n";
echo "</pre>";
?>