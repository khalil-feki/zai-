<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h2>Fix All Missing Users in h8pd_user Table</h2>";
    echo "<p>Database connection successful.</p>";
    
    // Get all users from h8pd_societe who are not in h8pd_user
    $missingUsersQuery = "
        SELECT s.rowid, s.nom, s.email 
        FROM h8pd_societe s 
        LEFT JOIN h8pd_user u ON s.rowid = u.rowid 
        WHERE u.rowid IS NULL 
        AND s.email IS NOT NULL 
        AND s.email != ''
        ORDER BY s.rowid
    ";
    
    $stmt = $db->prepare($missingUsersQuery);
    $stmt->execute();
    $missingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($missingUsers)) {
        echo "<p style='color: green;'>All users from h8pd_societe already exist in h8pd_user table. No action needed.</p>";
    } else {
        echo "<p style='color: orange;'>Found " . count($missingUsers) . " users missing from h8pd_user table.</p>";
        echo "<h3>Processing missing users:</h3>";
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($missingUsers as $user) {
            $userId = $user['rowid'];
            $userName = $user['nom'];
            $userEmail = $user['email'];
            
            echo "<p><strong>Processing User ID {$userId}:</strong> {$userName} ({$userEmail})</p>";
            
            try {
                // Extract first and last name from nom field
                $nameParts = explode(' ', trim($userName), 2);
                $firstname = $nameParts[0] ?? 'User';
                $lastname = $nameParts[1] ?? $userId;
                
                // Create login from email (part before @)
                $login = explode('@', $userEmail)[0];
                
                // Ensure login is unique
                $checkLoginQuery = "SELECT COUNT(*) FROM h8pd_user WHERE login = :login";
                $checkStmt = $db->prepare($checkLoginQuery);
                $checkStmt->bindParam(':login', $login);
                $checkStmt->execute();
                $loginExists = $checkStmt->fetchColumn();
                
                if ($loginExists > 0) {
                    $login = $login . '_' . $userId; // Make it unique
                }
                
                // Insert user into h8pd_user table
                $insertUserQuery = "INSERT INTO h8pd_user 
                                  (rowid, entity, employee, datec, tms, login, pass_crypted, lastname, firstname, email, admin, statut) 
                                  VALUES 
                                  (:rowid, 1, 1, NOW(), NOW(), :login, :pass_crypted, :lastname, :firstname, :email, 0, 1)";
                
                $insertStmt = $db->prepare($insertUserQuery);
                $pass_crypted = md5($login . '123'); // Default password pattern
                $insertStmt->bindParam(':rowid', $userId);
                $insertStmt->bindParam(':login', $login);
                $insertStmt->bindParam(':pass_crypted', $pass_crypted);
                $insertStmt->bindParam(':lastname', $lastname);
                $insertStmt->bindParam(':firstname', $firstname);
                $insertStmt->bindParam(':email', $userEmail);
                
                if ($insertStmt->execute()) {
                    echo "<p style='color: green; margin-left: 20px;'>✓ Successfully added to h8pd_user table</p>";
                    echo "<p style='margin-left: 20px;'>Login: {$login}, Password: {$login}123</p>";
                    $successCount++;
                } else {
                    echo "<p style='color: red; margin-left: 20px;'>✗ Failed to add to h8pd_user table</p>";
                    echo "<p style='margin-left: 20px;'>Error: " . implode(', ', $insertStmt->errorInfo()) . "</p>";
                    $errorCount++;
                }
                
            } catch (Exception $e) {
                echo "<p style='color: red; margin-left: 20px;'>✗ Exception: " . $e->getMessage() . "</p>";
                $errorCount++;
            }
            
            echo "<hr>";
        }
        
        echo "<h3>Summary:</h3>";
        echo "<p><strong>Successfully processed:</strong> {$successCount} users</p>";
        echo "<p><strong>Errors:</strong> {$errorCount} users</p>";
        
        if ($successCount > 0) {
            echo "<p style='color: green; font-weight: bold;'>All users can now place orders successfully!</p>";
        }
    }
    
    // Show current state of both tables
    echo "<br><h3>Current users in h8pd_user table:</h3>";
    $listUsersQuery = "SELECT rowid, login, email, lastname, firstname FROM h8pd_user ORDER BY rowid";
    $stmt = $db->prepare($listUsersQuery);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "<p>No users found in h8pd_user table.</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Login</th><th>Name</th><th>Email</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['rowid']}</td>";
            echo "<td>{$user['login']}</td>";
            echo "<td>{$user['firstname']} {$user['lastname']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Verify no missing users remain
    echo "<br><h3>Verification - Users still missing from h8pd_user:</h3>";
    $stmt = $db->prepare($missingUsersQuery);
    $stmt->execute();
    $stillMissing = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($stillMissing)) {
        echo "<p style='color: green; font-weight: bold;'>✓ All users from h8pd_societe now exist in h8pd_user table!</p>";
        echo "<p style='color: green;'>Your website is ready - all users can place orders without issues.</p>";
    } else {
        echo "<p style='color: red;'>Still missing " . count($stillMissing) . " users:</p>";
        foreach ($stillMissing as $user) {
            echo "<p>ID: {$user['rowid']}, Name: {$user['nom']}, Email: {$user['email']}</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>