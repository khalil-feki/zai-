<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h2>Add User ID 9 to h8pd_user Table</h2>";
    echo "<p>Database connection successful.</p>";
    
    // Check if user ID 9 exists in h8pd_user
    $checkUserQuery = "SELECT rowid, login, email FROM h8pd_user WHERE rowid = 9";
    $stmt = $db->prepare($checkUserQuery);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingUser) {
        echo "<p style='color: green;'>User ID 9 already exists in h8pd_user table.</p>";
        echo "<p>Login: {$existingUser['login']}, Email: {$existingUser['email']}</p>";
    } else {
        echo "<p style='color: orange;'>User ID 9 not found in h8pd_user table. Adding...</p>";
        
        // Insert user with ID 9 into h8pd_user table
        $insertUserQuery = "INSERT INTO h8pd_user 
                          (rowid, entity, employee, datec, tms, login, pass_crypted, lastname, firstname, email, admin, statut) 
                          VALUES 
                          (9, 1, 1, NOW(), NOW(), 'khalil', :pass_crypted, 'gh', 'death', 'khalilfeki8@gmail.com', 0, 1)";
        
        $stmt = $db->prepare($insertUserQuery);
        $pass_crypted = md5('khalil123'); // Default password
        $stmt->bindParam(':pass_crypted', $pass_crypted);
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Successfully added user ID 9 to h8pd_user table.</p>";
        } else {
            echo "<p style='color: red;'>Failed to add user ID 9 to h8pd_user table.</p>";
            print_r($stmt->errorInfo());
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
    
    echo "<br><p style='color: blue; font-weight: bold;'>SOLUTION: User ID 9 (khalilfeki8@gmail.com) should now exist in both h8pd_societe and h8pd_user tables, resolving the foreign key constraint error.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>