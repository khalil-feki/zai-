<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    echo "<h2>Remove User 9 Script</h2>";
    
    // Check if user exists in h8pd_user
    $checkUserStmt = $pdo->prepare("SELECT * FROM h8pd_user WHERE rowid = 9");
    $checkUserStmt->execute();
    $userExists = $checkUserStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($userExists) {
        echo "<p>User ID 9 found in h8pd_user table:</p>";
        echo "<pre>" . print_r($userExists, true) . "</pre>";
        
        // Remove from h8pd_user table
        $deleteUserStmt = $pdo->prepare("DELETE FROM h8pd_user WHERE rowid = 9");
        if ($deleteUserStmt->execute()) {
            echo "<p style='color: green;'>✓ Successfully removed user ID 9 from h8pd_user table</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to remove user ID 9 from h8pd_user table</p>";
        }
    } else {
        echo "<p style='color: orange;'>User ID 9 not found in h8pd_user table</p>";
    }
    
    // Check if user exists in h8pd_societe
    $checkSocieteStmt = $pdo->prepare("SELECT * FROM h8pd_societe WHERE rowid = 9");
    $checkSocieteStmt->execute();
    $societeExists = $checkSocieteStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($societeExists) {
        echo "<p>User ID 9 found in h8pd_societe table:</p>";
        echo "<pre>" . print_r($societeExists, true) . "</pre>";
        
        // Remove from h8pd_societe table
        $deleteSocieteStmt = $pdo->prepare("DELETE FROM h8pd_societe WHERE rowid = 9");
        if ($deleteSocieteStmt->execute()) {
            echo "<p style='color: green;'>✓ Successfully removed user ID 9 from h8pd_societe table</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to remove user ID 9 from h8pd_societe table</p>";
        }
    } else {
        echo "<p style='color: orange;'>User ID 9 not found in h8pd_societe table</p>";
    }
    
    echo "<hr>";
    echo "<h3>Current Users in h8pd_user:</h3>";
    $listUsersStmt = $pdo->prepare("SELECT rowid, login, email FROM h8pd_user ORDER BY rowid");
    $listUsersStmt->execute();
    $users = $listUsersStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($users) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Login</th><th>Email</th></tr>";
        foreach ($users as $user) {
            echo "<tr><td>{$user['rowid']}</td><td>{$user['login']}</td><td>{$user['email']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found in h8pd_user table</p>";
    }
    
    echo "<h3>Current Users in h8pd_societe:</h3>";
    $listSocieteStmt = $pdo->prepare("SELECT rowid, nom, email FROM h8pd_societe ORDER BY rowid");
    $listSocieteStmt->execute();
    $societes = $listSocieteStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($societes) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        foreach ($societes as $societe) {
            echo "<tr><td>{$societe['rowid']}</td><td>{$societe['nom']}</td><td>{$societe['email']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No companies found in h8pd_societe table</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>