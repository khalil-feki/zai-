<?php
// Script to get client email for order WEB-20250618164354
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
    
    echo "=== CLIENT EMAIL FOR ORDER WEB-20250618164354 ===\n\n";
    
    // Get the specific order and user information
    $stmt = $pdo->prepare("
        SELECT 
            c.rowid as order_id,
            c.ref as order_ref,
            c.ref_client,
            c.date_creation,
            c.fk_user_author,
            c.fk_soc,
            u.email as user_email,
            u.firstname,
            u.lastname,
            u.login,
            s.email as company_email,
            s.nom as company_name
        FROM h8pd_commande c
        LEFT JOIN h8pd_societe u ON c.fk_user_author = u.rowid
        LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid
        WHERE c.ref_client = 'WEB-20250618164354'
    ");
    
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($order) {
        echo "✅ ORDER FOUND:\n";
        echo "   Order ID: {$order['order_id']}\n";
        echo "   Order Reference: {$order['order_ref']}\n";
        echo "   Client Reference: {$order['ref_client']}\n";
        echo "   Date Created: {$order['date_creation']}\n";
        echo "   User ID: {$order['fk_user_author']}\n";
        echo "   Company ID: {$order['fk_soc']}\n";
        echo "\n📧 CLIENT EMAIL: {$order['user_email']}\n";
        echo "   Client Name: {$order['firstname']} {$order['lastname']}\n";
        echo "   Client Login: {$order['login']}\n";
        echo "\n🏢 COMPANY INFO:\n";
        echo "   Company Name: {$order['company_name']}\n";
        echo "   Company Email: {$order['company_email']}\n";
    } else {
        echo "❌ Order not found with ref_client 'WEB-20250618164354'\n";
    }
    
    // Also check user ID 2 details directly
    echo "\n\n=== USER ID 2 DETAILS ===\n";
    $userStmt = $pdo->prepare("SELECT * FROM h8pd_societe WHERE rowid = 2");
    $userStmt->execute();
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User ID 2 Email: {$user['email']}\n";
        echo "User ID 2 Name: {$user['firstname']} {$user['lastname']}\n";
        echo "User ID 2 Login: {$user['login']}\n";
    } else {
        echo "User ID 2 not found\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>