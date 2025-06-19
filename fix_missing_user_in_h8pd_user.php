<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h2>Fix Missing User in h8pd_user Table</h2>";
    echo "<p>Database connection successful.</p>";
    
    // Check if user najd@gmail.com exists in h8pd_user
    $checkUserQuery = "SELECT rowid, login, email FROM h8pd_user WHERE email = :email";
    $stmt = $db->prepare($checkUserQuery);
    $stmt->bindParam(':email', $email);
    $email = 'najd@gmail.com';
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingUser) {
        echo "<p style='color: green;'>User najd@gmail.com already exists in h8pd_user table.</p>";
        echo "<p>User ID: {$existingUser['rowid']}, Login: {$existingUser['login']}</p>";
    } else {
        echo "<p style='color: orange;'>User najd@gmail.com not found in h8pd_user table. Adding...</p>";
        
        // Get user details from h8pd_societe
        $getSocieteQuery = "SELECT rowid, nom, email FROM h8pd_societe WHERE email = :email";
        $stmt = $db->prepare($getSocieteQuery);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $societeUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($societeUser) {
            // Insert user into h8pd_user table
            $insertUserQuery = "INSERT INTO h8pd_user 
                              (entity, employee, datec, tms, login, pass_crypted, lastname, firstname, email, admin, statut) 
                              VALUES 
                              (1, 1, NOW(), NOW(), :login, :pass_crypted, :lastname, :firstname, :email, 0, 1)";
            
            $stmt = $db->prepare($insertUserQuery);
            $login = 'najd';
            $pass_crypted = md5('najd123'); // Default password
            $lastname = 'feki';
            $firstname = 'najd';
            
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':pass_crypted', $pass_crypted);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':email', $email);
            
            if ($stmt->execute()) {
                $newUserId = $db->lastInsertId();
                echo "<p style='color: green;'>Successfully added user to h8pd_user table with ID: {$newUserId}</p>";
                
                // Update h8pd_societe to link to the new user
                $updateSocieteQuery = "UPDATE h8pd_societe SET fk_user_creat = :user_id WHERE rowid = :societe_id";
                $stmt = $db->prepare($updateSocieteQuery);
                $stmt->bindParam(':user_id', $newUserId);
                $stmt->bindParam(':societe_id', $societeUser['rowid']);
                $stmt->execute();
                
                echo "<p style='color: green;'>Updated h8pd_societe to link to new user.</p>";
            } else {
                echo "<p style='color: red;'>Failed to add user to h8pd_user table.</p>";
            }
        } else {
            echo "<p style='color: red;'>User not found in h8pd_societe table.</p>";
        }
    }
    
    echo "<br><h3>Current users in h8pd_user table:</h3>";
    $listUsersQuery = "SELECT rowid, login, email, lastname, firstname FROM h8pd_user ORDER BY rowid";
    $stmt = $db->prepare($listUsersQuery);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "<p>ID: {$user['rowid']}, Login: {$user['login']}, Name: {$user['firstname']} {$user['lastname']}, Email: {$user['email']}</p>";
    }
    
    echo "<br><p style='color: blue; font-weight: bold;'>SOLUTION: Now the user najd@gmail.com should exist in both h8pd_societe and h8pd_user tables, allowing orders to be created without foreign key constraint errors.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>