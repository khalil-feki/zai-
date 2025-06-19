<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>User Password Check</h1>";

// Create database connection
$db = new Database();
$conn = $db->getConnection();

// First, let's check the structure of the extrafields table
echo "<h2>Checking Table Structure</h2>";
try {
    $query = "DESCRIBE h8pd_societe_extrafields";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    $passwordColumn = null;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
        }
        echo "</tr>";
        
        // Check if this might be a password column
        $fieldName = strtolower($row['Field']);
        if (strpos($fieldName, 'pass') !== false || strpos($fieldName, 'mot_de_passe') !== false) {
            $passwordColumn = $row['Field'];
        }
    }
    echo "</table>";
    
    if ($passwordColumn) {
        echo "<p style='color:green'>Found potential password column: <strong>{$passwordColumn}</strong></p>";
    } else {
        echo "<p style='color:orange'>No password column found. We'll need to add one.</p>";
        
        // Add the password column
        $query = "ALTER TABLE h8pd_societe_extrafields ADD COLUMN mot_de_passe VARCHAR(128) DEFAULT NULL";
        $stmt = $conn->prepare($query);
        
        if ($stmt->execute()) {
            echo "<p style='color:green'>✓ Added 'mot_de_passe' column to extrafields table!</p>";
            $passwordColumn = 'mot_de_passe';
        } else {
            echo "<p style='color:red'>✗ Failed to add password column.</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error checking table structure: " . $e->getMessage() . "</p>";
}

$email = "lotfi@gmail.com";
$password = "505050";
$hashedPassword = md5($password);

echo "<p>Checking user: <strong>{$email}</strong></p>";
echo "<p>Password: {$password}</p>";
echo "<p>MD5 Hash: {$hashedPassword}</p>";

// Check in h8pd_societe table
try {
    // First check if pass_crypted column exists in h8pd_societe
    $query = "SHOW COLUMNS FROM h8pd_societe LIKE 'pass_crypted'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $hasPassCrypted = ($stmt->rowCount() > 0);
    
    if ($hasPassCrypted) {
        $query = "SELECT rowid, nom, email, pass_crypted FROM h8pd_societe WHERE email = :email";
    } else {
        $query = "SELECT rowid, nom, email FROM h8pd_societe WHERE email = :email";
    }
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<h2>User found in h8pd_societe table</h2>";
        echo "<table border='1' cellpadding='5'>";
        
        if ($hasPassCrypted) {
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password Hash</th><th>Match?</th></tr>";
            echo "<tr>";
            echo "<td>" . $user['rowid'] . "</td>";
            echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . (isset($user['pass_crypted']) ? $user['pass_crypted'] : 'NULL') . "</td>";
            echo "<td>" . ((isset($user['pass_crypted']) && $user['pass_crypted'] === $hashedPassword) ? 'YES ✓' : 'NO ✗') . "</td>";
        } else {
            echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
            echo "<tr>";
            echo "<td>" . $user['rowid'] . "</td>";
            echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        }
        
        echo "</tr>";
        echo "</table>";
        
        // Check in extrafields table using the detected password column
        if ($passwordColumn) {
            $query = "SELECT rowid, fk_object, {$passwordColumn} FROM h8pd_societe_extrafields WHERE fk_object = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $user['rowid']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $extrafields = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<h2>User found in h8pd_societe_extrafields table</h2>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>FK_Object</th><th>Password Hash</th><th>Match?</th></tr>";
                echo "<tr>";
                echo "<td>" . $extrafields['rowid'] . "</td>";
                echo "<td>" . $extrafields['fk_object'] . "</td>";
                echo "<td>" . ($extrafields[$passwordColumn] ?? 'NULL') . "</td>";
                echo "<td>" . (($extrafields[$passwordColumn] === $hashedPassword) ? 'YES ✓' : 'NO ✗') . "</td>";
                echo "</tr>";
                echo "</table>";
                
                // If password doesn't match, offer to update it
                if ($extrafields[$passwordColumn] !== $hashedPassword) {
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='user_id' value='" . $user['rowid'] . "'>";
                    echo "<input type='hidden' name='action' value='update_password'>";
                    echo "<p><button type='submit'>Update Password to '505050'</button></p>";
                    echo "</form>";
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_password') {
                        $userId = $_POST['user_id'];
                        
                        $query = "UPDATE h8pd_societe_extrafields SET {$passwordColumn} = :pass WHERE fk_object = :id";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $userId);
                        $stmt->bindParam(':pass', $hashedPassword);
                        
                        if ($stmt->execute()) {
                            echo "<p style='color:green'>✓ Password updated in extrafields table!</p>";
                        } else {
                            echo "<p style='color:red'>✗ Failed to update password.</p>";
                        }
                    }
                }
            } else {
                echo "<h2>User NOT found in h8pd_societe_extrafields table</h2>";
                echo "<p>The password should be in the extrafields table. Let's fix this:</p>";
                
                // Add password to extrafields
                if ($hasPassCrypted && !empty($user['pass_crypted'])) {
                    $query = "INSERT INTO h8pd_societe_extrafields (fk_object, {$passwordColumn}) VALUES (:id, :pass)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $user['rowid']);
                    $stmt->bindParam(':pass', $user['pass_crypted']);
                    
                    if ($stmt->execute()) {
                        echo "<p style='color:green'>✓ Password added to extrafields table!</p>";
                    } else {
                        echo "<p style='color:red'>✗ Failed to add password to extrafields table.</p>";
                    }
                } else {
                    echo "<p>No password found in main table to migrate.</p>";
                    
                    // Set new password
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='user_id' value='" . $user['rowid'] . "'>";
                    echo "<input type='hidden' name='action' value='set_password'>";
                    echo "<p><button type='submit'>Set Password to '505050'</button></p>";
                    echo "</form>";
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'set_password') {
                        $userId = $_POST['user_id'];
                        
                        // Insert into extrafields
                        $query = "INSERT INTO h8pd_societe_extrafields (fk_object, {$passwordColumn}) VALUES (:id, :pass)";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $userId);
                        $stmt->bindParam(':pass', $hashedPassword);
                        
                        if ($stmt->execute()) {
                            echo "<p style='color:green'>✓ Password set in extrafields table!</p>";
                        } else {
                            echo "<p style='color:red'>✗ Failed to set password in extrafields table.</p>";
                        }
                    }
                }
            }
        } else {
            echo "<p style='color:red'>Cannot check extrafields table without a password column.</p>";
        }
    } else {
        echo "<h2>User NOT found in h8pd_societe table</h2>";
        echo "<p>The email address does not exist in the database.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}

// Add a section to update the User.php model
echo "<h2>Update User Model</h2>";
echo "<p>After identifying the correct password column, you'll need to update your User.php model.</p>";
echo "<p>Replace the <code>passwordField</code> property with: <code>protected \$passwordField = '".($passwordColumn ? $passwordColumn : 'mot_de_passe')."';</code></p>";
?>