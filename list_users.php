<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Set page title
$pageTitle = "User Management";

// Display header
include 'app/views/partials/header.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Create a test user
    echo "<h3>Creating Test User</h3>";
    
    $name = "Test User";
    $password = "Test123!";
    $firstname = "Test";
    $lastname = "User";
    $email = "testuser@example.com";
    
    // Hash password - Dolibarr uses MD5 for older installations
    $hashedPassword = md5($password);
    
    // Check if user already exists
    $checkQuery = "SELECT rowid FROM h8pd_societe WHERE name = :name OR email = :email";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bindParam(':name', $name);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() > 0) {
        echo "Test user already exists.<br>";
    } else {
        // Insert test user
        $insertQuery = "INSERT INTO h8pd_societe (name, firstname, lastname, email, pass_crypted, entity, datec, status) 
                       VALUES (:name, :firstname, :lastname, :email, :pass_crypted, 1, NOW(), 1)";
        
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':name', $name);
        $insertStmt->bindParam(':firstname', $firstname);
        $insertStmt->bindParam(':lastname', $lastname);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':pass_crypted', $hashedPassword);
        
        if ($insertStmt->execute()) {
            echo "<div style='background-color: #dff0d8; padding: 10px; border-radius: 5px;'>";
            echo "<strong>Test User Created Successfully!</strong><br>";
            echo "Name: " . $name . "<br>";
            echo "Password: " . $password . "<br>";
            echo "You can now try to login with these credentials.";
            echo "</div>";
        } else {
            echo "Failed to create test user.";
        }
    }
    
    // Check table structure
    echo "<h3>Table Structure Check</h3>";
    $tableQuery = "SHOW COLUMNS FROM h8pd_societe";
    $tableStmt = $conn->prepare($tableQuery);
    $tableStmt->execute();
    
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($column = $tableStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // List users
    echo "<h3>Existing Users</h3>";
    $query = "SELECT rowid, name, firstname, lastname, email FROM h8pd_societe";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['rowid'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No users found in the database.";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Display footer
include 'app/views/partials/footer.php';
?>