<!DOCTYPE html>
<html>
<head>
    <title>Fix Missing Users</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Fix Missing Users in h8pd_user Table</h1>
    
<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<p class='success'>Database connection successful.</p>";
    
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
        echo "<p class='success'><strong>✓ All users from h8pd_societe already exist in h8pd_user table. No action needed.</strong></p>";
    } else {
        echo "<p class='warning'><strong>Found " . count($missingUsers) . " users missing from h8pd_user table.</strong></p>";
        echo "<h2>Processing missing users:</h2>";
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($missingUsers as $user) {
            $userId = $user['rowid'];
            $userName = $user['nom'] ?? 'Unknown';
            $userEmail = $user['email'];
            
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
            echo "<h3>Processing User ID {$userId}: {$userName} ({$userEmail})</h3>";
            
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
                    echo "<p class='success'>✓ Successfully added to h8pd_user table</p>";
                    echo "<p><strong>Login:</strong> {$login} | <strong>Password:</strong> {$login}123</p>";
                    $successCount++;
                } else {
                    echo "<p class='error'>✗ Failed to add to h8pd_user table</p>";
                    echo "<p class='error'>Error: " . implode(', ', $insertStmt->errorInfo()) . "</p>";
                    $errorCount++;
                }
                
            } catch (Exception $e) {
                echo "<p class='error'>✗ Exception: " . $e->getMessage() . "</p>";
                $errorCount++;
            }
            
            echo "</div>";
        }
        
        echo "<h2>Summary:</h2>";
        echo "<p><strong>Successfully processed:</strong> <span class='success'>{$successCount} users</span></p>";
        echo "<p><strong>Errors:</strong> <span class='error'>{$errorCount} users</span></p>";
        
        if ($successCount > 0) {
            echo "<p class='success' style='font-size: 18px; font-weight: bold;'>🎉 All users can now place orders successfully!</p>";
        }
    }
    
    // Show current state of both tables
    echo "<h2>Current users in h8pd_user table:</h2>";
    $listUsersQuery = "SELECT rowid, login, email, lastname, firstname FROM h8pd_user ORDER BY rowid";
    $stmt = $db->prepare($listUsersQuery);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "<p class='warning'>No users found in h8pd_user table.</p>";
    } else {
        echo "<table>";
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
    
    // Final verification
    echo "<h2>Final Verification:</h2>";
    $stmt = $db->prepare($missingUsersQuery);
    $stmt->execute();
    $stillMissing = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($stillMissing)) {
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px;'>";
        echo "<h3 class='success'>✅ SUCCESS: All users from h8pd_societe now exist in h8pd_user table!</h3>";
        echo "<p class='success'>Your website is ready - all users can place orders without foreign key constraint errors.</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
        echo "<h3 class='error'>⚠️ Still missing " . count($stillMissing) . " users:</h3>";
        foreach ($stillMissing as $user) {
            echo "<p class='error'>ID: {$user['rowid']}, Name: {$user['nom']}, Email: {$user['email']}</p>";
        }
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
    echo "<h3 class='error'>Database Error:</h3>";
    echo "<p class='error'>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

</body>
</html>