<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Login Diagnostic Tool</h1>";

// Create database connection
$db = new Database();
$conn = $db->getConnection();

// First, let's check the actual column structure of the table
echo "<h2>Table Structure Check</h2>";
try {
    $tableStructureQuery = "DESCRIBE h8pd_societe";
    $structureStmt = $conn->prepare($tableStructureQuery);
    $structureStmt->execute();
    $tableColumns = $structureStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Found " . count($tableColumns) . " columns in h8pd_societe table</p>";
    
    // Look for potential password columns
    $passwordColumn = null;
    $potentialPasswordColumns = ['pass_crypted', 'password', 'pass', 'user_pass', 'passwd', 'pass_temp'];
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Column</th><th>Type</th><th>Potential Password Field?</th></tr>";
    
    foreach ($tableColumns as $column) {
        $isPotentialPassword = in_array($column['Field'], $potentialPasswordColumns);
        if ($isPotentialPassword) {
            $passwordColumn = $column['Field'];
        }
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
        echo "<td>" . ($isPotentialPassword ? "Yes" : "No") . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    if ($passwordColumn) {
        echo "<p style='color:green'>Found potential password column: " . $passwordColumn . "</p>";
    } else {
        echo "<p style='color:red'>No potential password column found. We need to add one.</p>";
        
        // Add a button to create the password column
        echo "<form method='post'>";
        echo "<input type='hidden' name='action' value='add_password_column'>";
        echo "<button type='submit'>Add Password Column to h8pd_societe</button>";
        echo "</form>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error checking table structure: " . $e->getMessage() . "</p>";
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add_password_column') {
        try {
            // Add the password column to the table
            $alterQuery = "ALTER TABLE h8pd_societe ADD COLUMN password VARCHAR(255)";
            $conn->exec($alterQuery);
            
            echo "<p style='color:green'>Successfully added 'password' column to h8pd_societe table!</p>";
            echo "<p>Please refresh this page to see the updated table structure.</p>";
            
            // Also update the User model to use this new column
            echo "<p style='color:orange'>Important: You need to update your User.php model to use the 'password' column instead of 'pass_crypted'</p>";
            
        } catch (Exception $e) {
            echo "<p style='color:red'>Error adding password column: " . $e->getMessage() . "</p>";
        }
    } else if ($action === 'test_login') {
        echo "<h2>Testing Login for: " . htmlspecialchars($email) . "</h2>";
        
        // Check if user exists
        $query = "SELECT * FROM h8pd_societe WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p style='color:green'>✓ User found in database</p>";
            
            // Use the detected password column or default to 'password'
            $passwordField = $passwordColumn ?? 'password';
            
            // Check password field
            if (isset($user[$passwordField]) && !empty($user[$passwordField])) {
                echo "<p style='color:green'>✓ Password hash exists: " . $user[$passwordField] . "</p>";
                
                // Test password
                $hashedPassword = md5($password);
                echo "<p>Input password MD5 hash: " . $hashedPassword . "</p>";
                
                if ($hashedPassword === $user[$passwordField]) {
                    echo "<p style='color:green'>✓ Password matches!</p>";
                    echo "<p style='font-weight:bold;color:green'>Login should work correctly.</p>";
                } else {
                    echo "<p style='color:red'>✗ Password does not match</p>";
                    echo "<p>To fix this, you can update the password:</p>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='user_id' value='" . $user['rowid'] . "'>";
                    echo "<input type='hidden' name='email' value='" . $email . "'>";
                    echo "<input type='hidden' name='password_field' value='" . $passwordField . "'>";
                    echo "<input type='password' name='new_password' placeholder='New Password' required>";
                    echo "<button type='submit' name='action' value='reset_password'>Reset Password</button>";
                    echo "</form>";
                }
            } else {
                echo "<p style='color:red'>✗ No password hash found for this user</p>";
                echo "<p>To fix this, you need to set a password:</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='user_id' value='" . $user['rowid'] . "'>";
                echo "<input type='hidden' name='email' value='" . $email . "'>";
                echo "<input type='hidden' name='password_field' value='" . ($passwordField ?? 'password') . "'>";
                echo "<input type='password' name='new_password' placeholder='New Password' required>";
                echo "<button type='submit' name='action' value='reset_password'>Set Password</button>";
                echo "</form>";
            }
            
            // Display user details
            echo "<h3>User Details:</h3>";
            echo "<table border='1' cellpadding='5'>";
            foreach ($user as $key => $value) {
                echo "<tr><td><strong>" . htmlspecialchars($key) . "</strong></td><td>" . htmlspecialchars($value ?? 'NULL') . "</td></tr>";
            }
            echo "</table>";
            
        } else {
            echo "<p style='color:red'>✗ No user found with this email</p>";
            echo "<p>Would you like to create this user?</p>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='email' value='" . htmlspecialchars($email) . "'>";
            echo "<input type='text' name='firstname' placeholder='First Name' required><br>";
            echo "<input type='text' name='lastname' placeholder='Last Name' required><br>";
            echo "<input type='password' name='password' placeholder='Password' required><br>";
            echo "<button type='submit' name='action' value='create_user'>Create User</button>";
            echo "</form>";
        }
    } else if ($action === 'reset_password') {
        $userId = $_POST['user_id'];
        $email = $_POST['email'];
        $newPassword = $_POST['new_password'];
        $passwordField = $_POST['password_field'] ?? 'password';
        
        try {
            // Check if the column exists
            $checkColumnQuery = "SHOW COLUMNS FROM h8pd_societe LIKE :column_name";
            $checkStmt = $conn->prepare($checkColumnQuery);
            $checkStmt->bindParam(':column_name', $passwordField);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() == 0) {
                // Column doesn't exist, create it
                $alterQuery = "ALTER TABLE h8pd_societe ADD COLUMN {$passwordField} VARCHAR(255)";
                $conn->exec($alterQuery);
                echo "<p style='color:green'>Created missing password column: {$passwordField}</p>";
            }
            
            // Update password in database
            $hashedPassword = md5($newPassword);
            $updateQuery = "UPDATE h8pd_societe SET {$passwordField} = :password WHERE rowid = :id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':id', $userId);
            
            if ($updateStmt->execute()) {
                echo "<p style='color:green'>Password updated successfully for " . htmlspecialchars($email) . "!</p>";
                echo "<p>You can now login with:</p>";
                echo "<ul>";
                echo "<li>Email: " . htmlspecialchars($email) . "</li>";
                echo "<li>Password: " . htmlspecialchars($newPassword) . "</li>";
                echo "</ul>";
                
                // Also update the User model to use the correct password field
                echo "<p style='color:orange'>Important: You need to update your User.php model to use the '{$passwordField}' column instead of 'pass_crypted'</p>";
            } else {
                echo "<p style='color:red'>Failed to update password.</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color:red'>Error updating password: " . $e->getMessage() . "</p>";
        }
    } else if ($action === 'create_user') {
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        
        $user = new User();
        $result = $user->register([
            'email' => $email,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'password' => $password
        ]);
        
        if ($result) {
            echo "<p style='color:green'>User created successfully!</p>";
            echo "<p>You can now login with:</p>";
            echo "<ul>";
            echo "<li>Email: " . htmlspecialchars($email) . "</li>";
            echo "<li>Password: " . htmlspecialchars($password) . "</li>";
            echo "</ul>";
        } else {
            echo "<p style='color:red'>Failed to create user.</p>";
        }
    }
}

// Display login test form
echo "<h2>Test Login Credentials</h2>";
echo "<form method='post'>";
echo "<input type='email' name='email' placeholder='Email' required><br>";
echo "<input type='password' name='password' placeholder='Password' required><br>";
echo "<button type='submit' name='action' value='test_login'>Test Login</button>";
echo "</form>";

// Display existing users
echo "<h2>Existing Users</h2>";
$query = "SELECT rowid, nom, email FROM h8pd_societe WHERE email IS NOT NULL ORDER BY rowid DESC LIMIT 10";
$stmt = $conn->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>";
    
    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $user['rowid'] . "</td>";
        echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='email' value='" . htmlspecialchars($user['email']) . "'>";
        echo "<input type='hidden' name='password' value='test123'>";
        echo "<button type='submit' name='action' value='test_login'>Test</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>No users found with email addresses.</p>";
}
?>