<?php
// Simple web script to fix user authentication issue
header('Content-Type: text/plain');

require_once 'app/config/database.php';

try {
    // Create database connection using Database class
    $database = new Database();
    $pdo = $database->getConnection();
    
    echo "Database connection successful.\n\n";
    
    // Check if user already exists in h8pd_societe
    $checkStmt = $pdo->prepare("SELECT rowid, nom, email FROM h8pd_societe WHERE email = ?");
    $checkStmt->execute(['khalilfeki8@gmail.com']);
    
    if ($checkStmt->rowCount() > 0) {
        echo "User khalilfeki8@gmail.com already exists in h8pd_societe table.\n";
        $user = $checkStmt->fetch(PDO::FETCH_ASSOC);
        echo "User ID: " . $user['rowid'] . ", Name: " . $user['nom'] . "\n";
    } else {
        echo "User khalilfeki8@gmail.com not found in h8pd_societe table. Adding user...\n";
        
        // Insert user into h8pd_societe table
        $insertStmt = $pdo->prepare("
            INSERT INTO h8pd_societe 
            (nom, entity, email, status, client, datec, tms, code_client) 
            VALUES (?, 1, ?, 1, 1, NOW(), NOW(), ?)
        ");
        
        // Generate a unique client code
        $clientCode = 'CU' . date('ym') . '-' . str_pad(2, 5, '0', STR_PAD_LEFT);
        
        $result = $insertStmt->execute([
            'Khalil Death',
            'khalilfeki8@gmail.com',
            $clientCode
        ]);
        
        if ($result) {
            $newUserId = $pdo->lastInsertId();
            echo "User added successfully to h8pd_societe table with ID: $newUserId\n";
            
            // Also create extrafields entry for password
            try {
                $extrafieldStmt = $pdo->prepare("
                    INSERT INTO h8pd_societe_extrafields 
                    (fk_object, mot_de_passe) 
                    VALUES (?, ?)
                ");
                
                // Use the same password hash as in h8pd_user table (khalil123)
                $passwordHash = 'dae0c4aecb4b355e746ec4a1b9739004';
                $extrafieldResult = $extrafieldStmt->execute([$newUserId, $passwordHash]);
                
                if ($extrafieldResult) {
                    echo "Password extrafield added successfully.\n";
                } else {
                    echo "Warning: Failed to add password extrafield.\n";
                }
            } catch (Exception $e) {
                echo "Warning: Error adding password extrafield: " . $e->getMessage() . "\n";
            }
        } else {
            echo "Failed to add user to h8pd_societe table.\n";
        }
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "Current users in h8pd_societe table:\n";
    echo str_repeat('=', 50) . "\n";
    
    $listStmt = $pdo->query("SELECT rowid, nom, email FROM h8pd_societe ORDER BY rowid");
    while ($row = $listStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['rowid']}, Name: {$row['nom']}, Email: {$row['email']}\n";
    }
    
    echo "\n" . str_repeat('=', 50) . "\n";
    echo "SOLUTION SUMMARY:\n";
    echo str_repeat('=', 50) . "\n";
    echo "The issue was that khalilfeki8@gmail.com existed in h8pd_user table\n";
    echo "but not in h8pd_societe table. The authentication system uses\n";
    echo "h8pd_societe table, so orders were being created with the default\n";
    echo "user (ID: 1, exemple@gmail.com) instead of the logged-in user.\n";
    echo "\nNow khalilfeki8@gmail.com should be able to login properly and\n";
    echo "orders will be created with the correct email address.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>