<?php
require_once '../app/config/config.php';
require_once '../app/config/database.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>User Migration Tool</h1>";
echo "<p>Migration no longer needed - using h8pd_societe directly for user management.</p>";

// Create database connection
$db = new Database();
$conn = $db->getConnection();

// Check if tables exist
try {
    $tables = ['h8pd_societe']; // No longer using h8pd_user
    $tablesExist = true;
    
    foreach ($tables as $table) {
        $query = "SHOW TABLES LIKE '$table'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            echo "<p style='color:red'>Table $table does not exist!</p>";
            $tablesExist = false;
        }
    }
    
    if (!$tablesExist) {
        echo "<p>Using h8pd_societe table directly for user management.</p>";
        exit;
    }
    
    // Count users in both tables
    $query = "SELECT COUNT(*) as count FROM h8pd_societe WHERE email IS NOT NULL";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $societeCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    $query = "SELECT COUNT(*) as count FROM h8pd_user";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    echo "<p>Found $societeCount customers with email addresses in h8pd_societe table.</p>";
    echo "<p>Found $userCount users in h8pd_user table.</p>";
    
    // Process migration if form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'migrate') {
        echo "<h2>Migration Results</h2>";
        
        // Migrate users from h8pd_societe to h8pd_user
        $query = "SELECT rowid, nom, firstname, lastname, email, pass_crypted FROM h8pd_societe WHERE email IS NOT NULL";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $societeUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $migrated = 0;
        $linked = 0;
        $errors = 0;
        
        foreach ($societeUsers as $user) {
            // Check if user already exists in h8pd_user
            $checkQuery = "SELECT rowid FROM h8pd_user WHERE email = :email";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bindParam(':email', $user['email']);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                // User exists, link them
                $userId = $checkStmt->fetch(PDO::FETCH_ASSOC)['rowid'];
                
                $linkQuery = "UPDATE h8pd_societe SET fk_user = :user_id WHERE rowid = :societe_id";
                $linkStmt = $conn->prepare($linkQuery);
                $linkStmt->bindParam(':user_id', $userId);
                $linkStmt->bindParam(':societe_id', $user['rowid']);
                
                if ($linkStmt->execute()) {
                    $linked++;
                    echo "<p style='color:green'>✓ Linked existing user: " . htmlspecialchars($user['email']) . "</p>";
                } else {
                    $errors++;
                    echo "<p style='color:red'>✗ Failed to link user: " . htmlspecialchars($user['email']) . "</p>";
                }
            } else {
                // Create new user in h8pd_user
                $login = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $user['nom']));
                if (empty($login)) {
                    $login = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $user['email']));
                }
                
                $insertQuery = "INSERT INTO h8pd_user (login, firstname, lastname, email, pass_crypted) 
                               VALUES (:login, :firstname, :lastname, :email, :pass_crypted)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bindParam(':login', $login);
                $insertStmt->bindParam(':firstname', $user['firstname']);
                $insertStmt->bindParam(':lastname', $user['lastname']);
                $insertStmt->bindParam(':email', $user['email']);
                $insertStmt->bindParam(':pass_crypted', $user['pass_crypted']);
                
                if ($insertStmt->execute()) {
                    $newUserId = $conn->lastInsertId();
                    
                    // Link the new user to the societe
                    $linkQuery = "UPDATE h8pd_societe SET fk_user = :user_id WHERE rowid = :societe_id";
                    $linkStmt = $conn->prepare($linkQuery);
                    $linkStmt->bindParam(':user_id', $newUserId);
                    $linkStmt->bindParam(':societe_id', $user['rowid']);
                    
                    if ($linkStmt->execute()) {
                        $migrated++;
                        echo "<p style='color:green'>✓ Migrated user: " . htmlspecialchars($user['email']) . "</p>";
                    } else {
                        $errors++;
                        echo "<p style='color:red'>✗ Failed to link newly created user: " . htmlspecialchars($user['email']) . "</p>";
                    }
                } else {
                    $errors++;
                    echo "<p style='color:red'>✗ Failed to create user: " . htmlspecialchars($user['email']) . "</p>";
                }
            }
        }
        
        echo "<h3>Summary</h3>";
        echo "<p>Migrated: $migrated users</p>";
        echo "<p>Linked: $linked users</p>";
        echo "<p>Errors: $errors</p>";
        
        echo "<h3>Next Steps</h3>";
        echo "<p>Now you need to update your User model to use the h8pd_user table instead of h8pd_societe.</p>";
        echo "<p>Edit the file: <code>app/models/User.php</code></p>";
        echo "<pre style='background-color:#f5f5f5;padding:10px;border-radius:5px;'>";
        echo "protected \$table = 'h8pd_user'; // Changed from h8pd_societe to h8pd_user\n";
        echo "protected \$passwordField = 'pass_crypted';";
        echo "</pre>";
    }
    
    // Display migration form
    echo "<form method='post'>";
    echo "<input type='hidden' name='action' value='migrate'>";
    echo "<p><button type='submit' style='padding:10px;'>Start Migration</button></p>";
    echo "</form>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>