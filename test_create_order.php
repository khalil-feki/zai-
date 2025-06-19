<?php
require_once 'app/config/database.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';
require_once 'app/models/Product.php';

echo "<h2>Order Creation Test Script</h2>";
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

    // Test 2: Check if user exists in societe table
    echo "\n=== Test 2: User/Societe Check ===\n";
    $testUserId = 1; // Change this to your actual user ID
    
    $userQuery = "SELECT rowid, nom, email FROM h8pd_societe WHERE rowid = :user_id";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->bindParam(':user_id', $testUserId, PDO::PARAM_INT);
    $userStmt->execute();
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "✓ User found: ID {$user['rowid']}, Name: {$user['nom']}, Email: {$user['email']}\n";
    } else {
        echo "✗ User not found with ID $testUserId\n";
        echo "Available users:\n";
        $allUsersQuery = "SELECT rowid, nom, email FROM h8pd_societe WHERE email IS NOT NULL LIMIT 5";
        $allUsersStmt = $conn->prepare($allUsersQuery);
        $allUsersStmt->execute();
        while ($u = $allUsersStmt->fetch(PDO::FETCH_ASSOC)) {
            echo "  - ID: {$u['rowid']}, Name: {$u['nom']}, Email: {$u['email']}\n";
        }
        exit;
    }

    // Test 3: Get test products
    echo "\n=== Test 3: Product Check ===\n";
    $productQuery = "SELECT rowid, label, price FROM h8pd_product WHERE tosell = 1 LIMIT 3";
    $productStmt = $conn->prepare($productQuery);
    $productStmt->execute();
    $products = $productStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($products) > 0) {
        echo "✓ Found " . count($products) . " products:\n";
        foreach ($products as $product) {
            echo "  - ID: {$product['rowid']}, Name: {$product['label']}, Price: {$product['price']}\n";
        }
    } else {
        echo "✗ No products found\n";
        exit;
    }

    // Test 4: Create test order
    echo "\n=== Test 4: Creating Test Order ===\n";
    
    // Prepare cart items
    $cartItems = [];
    foreach ($products as $product) {
        $cartItems[] = [
            'product_id' => $product['rowid'],
            'label' => $product['label'],
            'price' => $product['price'],
            'quantity' => rand(1, 3)
        ];
    }
    
    // Test address
    $testAddress = "Test Address, 123 Main St, Test City";
    
    echo "Cart items prepared:\n";
    foreach ($cartItems as $item) {
        echo "  - {$item['label']}: {$item['quantity']} x {$item['price']} TND\n";
    }
    
    // Create order using Order model
    // Add this after the existing code, before creating the order
    echo "\n=== Checking Error Logs ===\n";
    
    // Enable error logging to display
    ini_set('log_errors', 1);
    ini_set('error_log', 'php_errors.log');
    
    // Add more detailed error handling
    try {
        $orderModel = new Order();
        
        // Add debug info before creating order
        echo "About to create order with User ID: $testUserId\n";
        echo "Cart items count: " . count($cartItems) . "\n";
        
        $orderId = $orderModel->createOrder($testUserId, $cartItems, $testAddress);
        
        if ($orderId) {
            echo "\n✓ Order created successfully! Order ID: $orderId\n";
        } else {
            echo "\n✗ Order creation returned false\n";
            
            // Check if error log file exists and show recent errors
            if (file_exists('php_errors.log')) {
                echo "\nRecent errors from php_errors.log:\n";
                $errors = file_get_contents('php_errors.log');
                $lines = explode("\n", $errors);
                $recentLines = array_slice($lines, -10); // Last 10 lines
                foreach ($recentLines as $line) {
                    if (!empty(trim($line))) {
                        echo "  $line\n";
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo "\n✗ Exception caught: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
    
    // Verify order in database
    echo "\n=== Test 5: Verifying Order in Database ===\n";
    $verifyQuery = "SELECT * FROM h8pd_commande WHERE rowid = :order_id";
    $verifyStmt = $conn->prepare($verifyQuery);
    $verifyStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $verifyStmt->execute();
    $orderData = $verifyStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($orderData) {
        echo "✓ Order found in database:\n";
        echo "  - Order ID: {$orderData['rowid']}\n";
        echo "  - Reference: {$orderData['ref']}\n";
        echo "  - Societe ID: {$orderData['fk_soc']}\n";
        echo "  - Total HT: {$orderData['total_ht']} TND\n";
        echo "  - Total TTC: {$orderData['total_ttc']} TND\n";
        echo "  - Status: {$orderData['fk_statut']}\n";
        echo "  - Created: {$orderData['date_creation']}\n";
        
        // Check order details
        $detailsQuery = "SELECT * FROM h8pd_commandedet WHERE fk_commande = :order_id";
        $detailsStmt = $conn->prepare($detailsQuery);
        $detailsStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $detailsStmt->execute();
        $orderDetails = $detailsStmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\n  Order Details (" . count($orderDetails) . " items):\n";
        foreach ($orderDetails as $detail) {
            echo "    - Product ID: {$detail['fk_product']}, Qty: {$detail['qty']}, Price: {$detail['subprice']}, Total: {$detail['total_ttc']}\n";
        }
    } else {
        echo "✗ Order not found in database!\n";
    }
} catch (Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
?>