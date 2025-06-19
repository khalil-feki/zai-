<?php
// Test script to verify ref_client field is set with user email
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
    
    // Search for the specific order reference
    $searchRef = 'WEB-20250618164354';
    
    echo "=== SEARCHING FOR ORDER: $searchRef ===\n";
    
    $stmt = $pdo->prepare("
        SELECT 
            c.ref, 
            c.ref_client, 
            c.fk_user_author, 
            c.fk_soc,
            c.date_creation,
            u.email as user_email, 
            u.firstname,
            u.lastname,
            s.email as societe_email,
            s.nom as societe_name
        FROM h8pd_commande c 
        LEFT JOIN h8pd_societe u ON c.fk_user_author = u.rowid 
        LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid 
        WHERE c.ref = ? OR c.ref_client = ? OR c.ref LIKE ? OR c.ref_client LIKE ?
    ");
    
    $likePattern = '%20250618164354%';
    $stmt->execute([$searchRef, $searchRef, $likePattern, $likePattern]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($results)) {
        foreach ($results as $order) {
            echo "\n=== ORDER FOUND ===\n";
            echo "Order Reference (ref): " . ($order['ref'] ?? 'NULL') . "\n";
            echo "Client Reference (ref_client): " . ($order['ref_client'] ?? 'NULL') . "\n";
            echo "Date Created: " . ($order['date_creation'] ?? 'NULL') . "\n";
            echo "User ID: " . ($order['fk_user_author'] ?? 'NULL') . "\n";
            echo "CLIENT EMAIL: " . ($order['user_email'] ?? 'NULL') . "\n";
            echo "User Name: " . trim(($order['firstname'] ?? '') . ' ' . ($order['lastname'] ?? '')) . "\n";
            echo "Societe ID: " . ($order['fk_soc'] ?? 'NULL') . "\n";
            echo "Societe Email: " . ($order['societe_email'] ?? 'NULL') . "\n";
            echo "Societe Name: " . ($order['societe_name'] ?? 'NULL') . "\n";
            echo "==================\n";
        }
    } else {
        echo "No order found with reference containing '$searchRef' or '20250618164354'.\n";
    }
    
    // Show recent orders to understand current pattern
    echo "\n\n=== RECENT ORDERS (Last 10) ===\n";
    $stmt2 = $pdo->prepare("
        SELECT 
            c.ref, 
            c.ref_client, 
            c.date_creation,
            u.email as user_email,
            u.firstname,
            u.lastname
        FROM h8pd_commande c 
        LEFT JOIN h8pd_societe u ON c.fk_user_author = u.rowid 
        ORDER BY c.date_creation DESC 
        LIMIT 10
    ");
    $stmt2->execute();
    $recentOrders = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($recentOrders as $order) {
        echo "Ref: {$order['ref']}, Ref_client: {$order['ref_client']}, Date: {$order['date_creation']}, User: {$order['firstname']} {$order['lastname']} ({$order['user_email']})\n";
    }
    
    // Check if ref_client field exists and has proper structure
    echo "\n\n=== CHECKING ref_client FIELD USAGE ===\n";
    $stmt3 = $pdo->prepare("
        SELECT 
            COUNT(*) as total_orders,
            COUNT(CASE WHEN ref_client IS NOT NULL AND ref_client != '' THEN 1 END) as orders_with_ref_client,
            COUNT(CASE WHEN ref_client LIKE '%@%' THEN 1 END) as orders_with_email_ref_client
        FROM h8pd_commande
    ");
    $stmt3->execute();
    $stats = $stmt3->fetch(PDO::FETCH_ASSOC);
    
    echo "Total orders: {$stats['total_orders']}\n";
    echo "Orders with ref_client: {$stats['orders_with_ref_client']}\n";
    echo "Orders with email in ref_client: {$stats['orders_with_email_ref_client']}\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>