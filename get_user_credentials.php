<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Existing User Credentials</h1>";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Get a sample user from the database
    $query = "SELECT rowid, nom, email FROM h8pd_societe WHERE email IS NOT NULL LIMIT 5";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th></tr>";
        
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $user['rowid'] . "</td>";
            echo "<td>" . $user['nom'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>Password is encrypted in database. Use 'password' for testing.</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        echo "<p>Note: To login with these accounts, you can set their passwords using the following SQL:</p>";
        echo "<pre>";
        echo "UPDATE h8pd_societe SET pass_crypted = '5f4dcc3b5aa765d61d8327deb882cf99' WHERE email = 'user_email@example.com';\n";
        echo "</pre>";
        echo "<p>This sets the password to 'password' (MD5 hash).</p>";
        
    } else {
        echo "<p>No users found with email addresses.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>