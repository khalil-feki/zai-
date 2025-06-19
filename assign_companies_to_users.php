<?php
require_once 'app/models/UserModel.php';

echo "Starting company assignment for existing users...\n";

try {
    $userModel = new UserModel();
    
    // Get all users without company assignment
    $query = "SELECT rowid, nom as login, email, nom as firstname, '' as lastname FROM h8pd_societe WHERE email IS NOT NULL";
    $conn = $userModel->getConnection();
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($users) . " users without company assignment\n";
    
    if (count($users) > 0) {
        $updated = $userModel->assignCompaniesToUsers();
        echo "Successfully assigned companies to {$updated} users\n";
        
        // Show updated results
        echo "\nUpdated user list:\n";
        $allUsers = $userModel->getAllUsers();
        foreach ($allUsers as $user) {
            echo "User ID: {$user['rowid']}, Login: {$user['login']}, Email: {$user['email']}, fk_soc: " . ($user['fk_soc'] ?? 'NULL') . "\n";
        }
    } else {
        echo "No users found without company assignment\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nScript completed.\n";
?>