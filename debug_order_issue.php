<?php
// Debug script to understand the order reference issue
require_once 'app/config/database.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "=== DEBUGGING ORDER REFERENCE ISSUE ===\n\n";
    
    // 1. Check if the specific order exists
    echo "1. Searching for order reference 'WEB-20250618164354':\n";
    $stmt = $conn->prepare("SELECT * FROM h8pd_commande WHERE ref LIKE '%20250618164354%' OR ref_client LIKE '%20250618164354%'");
    $stmt->execute();
    $specificOrder = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($specificOrder)) {
        echo "   ❌ No order found with reference containing '20250618164354'\n";
    } else {
        foreach ($specificOrder as $order) {
            echo "   ✅ Found order:\n";
            echo "      ID: {$order['rowid']}\n";
            echo "      Ref: {$order['ref']}\n";
            echo "      Ref_client: {$order['ref_client']}\n";
            echo "      Date: {$order['date_creation']}\n";
            echo "      User ID: {$order['fk_user_author']}\n";
        }
    }
    
    // 2. Check recent orders to see current format
    echo "\n2. Recent orders (last 5):\n";
    $stmt2 = $conn->prepare("SELECT rowid, ref, ref_client, date_creation, fk_user_author FROM h8pd_commande ORDER BY date_creation DESC LIMIT 5");
    $stmt2->execute();
    $recentOrders = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($recentOrders as $order) {
        echo "   ID: {$order['rowid']}, Ref: {$order['ref']}, Ref_client: {$order['ref_client']}, Date: {$order['date_creation']}\n";
    }
    
    // 3. Check if ref_client field is being populated
    echo "\n3. Checking ref_client field usage:\n";
    $stmt3 = $conn->prepare("SELECT COUNT(*) as total, COUNT(CASE WHEN ref_client IS NOT NULL AND ref_client != '' THEN 1 END) as with_ref_client FROM h8pd_commande");
    $stmt3->execute();
    $stats = $stmt3->fetch(PDO::FETCH_ASSOC);
    echo "   Total orders: {$stats['total']}\n";
    echo "   Orders with ref_client: {$stats['with_ref_client']}\n";
    
    // 4. Check table structure
    echo "\n4. Table structure for ref_client field:\n";
    $stmt4 = $conn->prepare("DESCRIBE h8pd_commande");
    $stmt4->execute();
    $columns = $stmt4->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if ($column['Field'] === 'ref_client') {
            echo "   ref_client: {$column['Type']} - Null: {$column['Null']} - Default: {$column['Default']}\n";
            break;
        }
    }
    
    // 5. Check if there are any orders from June 18, 2025
    echo "\n5. Orders from June 18, 2025:\n";
    $stmt5 = $conn->prepare("SELECT * FROM h8pd_commande WHERE DATE(date_creation) = '2025-06-18'");
    $stmt5->execute();
    $june18Orders = $stmt5->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($june18Orders)) {
        echo "   ❌ No orders found from June 18, 2025\n";
    } else {
        foreach ($june18Orders as $order) {
            echo "   ✅ Order from June 18: ID {$order['rowid']}, Ref: {$order['ref']}, Ref_client: {$order['ref_client']}\n";
        }
    }
    
    // 6. Search for any order with similar timestamp
    echo "\n6. Orders with similar timestamp pattern:\n";
    $stmt6 = $conn->prepare("SELECT * FROM h8pd_commande WHERE ref LIKE '%164354%' OR ref_client LIKE '%164354%'");
    $stmt6->execute();
    $similarOrders = $stmt6->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($similarOrders)) {
        echo "   ❌ No orders found with timestamp '164354'\n";
    } else {
        foreach ($similarOrders as $order) {
            echo "   ✅ Similar order: ID {$order['rowid']}, Ref: {$order['ref']}, Ref_client: {$order['ref_client']}\n";
        }
    }
    
    echo "\n=== DEBUG COMPLETE ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>