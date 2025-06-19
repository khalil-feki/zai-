<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h2>Add User ID 14 to h8pd_user Table</h2>";
    echo "<p>Database connection successful.</p>";
    
    // Check if user ID 14 exists in h8pd_user
    $checkUserQuery = "SELECT rowid, login, email FROM h8pd_user WHERE rowid = 14";
    $stmt = $db->prepare($checkUserQuery);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingUser) {
        echo "<p style='color: green;'>User ID 14 already exists in h8pd_user table.</p>";
        echo "<p>Login: {$existingUser['login']}, Email: {$existingUser['email']}</p>";
    } else {
        echo "<p style='color: orange;'>User ID 14 not found in h8pd_user table. Adding...</p>";
        
        // Get user details from h8pd_societe
        $societeQuery = "SELECT rowid, nom, email FROM h8pd_societe WHERE rowid = 14";
        $societeStmt = $db->prepare($societeQuery);
        $societeStmt->execute();
        $societeUser = $societeStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($societeUser) {
            echo "<p>Found user in h8pd_societe: Name: {$societeUser['nom']}, Email: {$societeUser['email']}</p>";
            
            // Extract first and last name from nom field
            $nameParts = explode(' ', trim($societeUser['nom']), 2);
            $firstname = $nameParts[0] ?? 'User';
            $lastname = $nameParts[1] ?? '14';
            
            // Create login from email (part before @)
            $login = explode('@', $societeUser['email'])[0];
            
            // Insert user with ID 14 into h8pd_user table
            $insertUserQuery = "INSERT INTO h8pd_user 
                              (rowid, entity, employee, datec, tms, login, pass_crypted, lastname, firstname, email, admin, statut) 
                              VALUES 
                              (14, 1, 1, NOW(), NOW(), :login, :pass_crypted, :lastname, :firstname, :email, 0, 1)";
            
            $stmt = $db->prepare($insertUserQuery);
            $pass_crypted = md5($login . '123'); // Default password pattern
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':pass_crypted', $pass_crypted);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':email', $societeUser['email']);
            
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Successfully added user ID 14 to h8pd_user table.</p>";
                echo "<p>Login: {$login}, Password: {$login}123, Name: {$firstname} {$lastname}, Email: {$societeUser['email']}</p>";
            } else {
                echo "<p style='color: red;'>Failed to add user ID 14 to h8pd_user table.</p>";
                print_r($stmt->errorInfo());
            }
        } else {
            echo "<p style='color: red;'>User ID 14 not found in h8pd_societe table either!</p>";
        }
    }
    
    echo "<br><h3>Current users in h8pd_user table:</h3>";
    $listUsersQuery = "SELECT rowid, login, email, lastname, firstname FROM h8pd_user ORDER BY rowid";
    $stmt = $db->prepare($listUsersQuery);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "<p>No users found in h8pd_user table.</p>";
    } else {
        foreach ($users as $user) {
            echo "<p>ID: {$user['rowid']}, Login: {$user['login']}, Name: {$user['firstname']} {$user['lastname']}, Email: {$user['email']}</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>