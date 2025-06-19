<?php
// Simple script to check orders in database
try {
    $host = "c137d.myd.infomaniak.com";
    $db_name = "c137d_app_dolibarr_20";
    $username = "c137d_ecom";
    $password = "Ecom2024@";
    
    $pdo = new PDO(
        "mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8",
        $username,
        $password,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
    
    echo "Connected to database successfully.\n\n";
    
    // Check if the specific order exists
    echo "=== SEARCHING FOR ORDER: WEB-20250618164354 ===\n";
    $stmt = $pdo->prepare("SELECT * FROM h8pd_commande WHERE ref LIKE '%20250618%' OR ref_client LIKE '%20250618%'");
    $stmt->execute();
    $orders = $stmt->fetchAll();
    
    if (empty($orders)) {
        echo "No orders found with reference containing '20250618'.\n";
    } else {
        foreach ($orders as $order) {
            echo "Found order:\n";
            echo "  ID: " . $order['rowid'] . "\n";
            echo "  Ref: " . $order['ref'] . "\n";
            echo "  Ref_client: " . ($order['ref_client'] ?? 'NULL') . "\n";
            echo "  Date: " . $order['date_creation'] . "\n";
            echo "  User ID: " . $order['fk_user_author'] . "\n";
            echo "  Company ID: " . $order['fk_soc'] . "\n";
            echo "\n";
        }
    }
    
    // Show the most recent 5 orders
    echo "\n=== MOST RECENT 5 ORDERS ===\n";
    $stmt2 = $pdo->prepare("SELECT rowid, ref, ref_client, date_creation, fk_user_author FROM h8pd_commande ORDER BY date_creation DESC LIMIT 5");
    $stmt2->execute();
    $recentOrders = $stmt2->fetchAll();
    
    foreach ($recentOrders as $order) {
        echo "ID: {$order['rowid']}, Ref: {$order['ref']}, Ref_client: {$order['ref_client']}, Date: {$order['date_creation']}, User: {$order['fk_user_author']}\n";
    }
    
    // Check table structure
    echo "\n=== TABLE STRUCTURE ===\n";
    $stmt3 = $pdo->prepare("DESCRIBE h8pd_commande");
    $stmt3->execute();
    $columns = $stmt3->fetchAll();
    
    foreach ($columns as $column) {
        if (in_array($column['Field'], ['ref', 'ref_client', 'fk_user_author', 'fk_soc'])) {
            echo "{$column['Field']}: {$column['Type']} - {$column['Null']} - {$column['Default']}\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>