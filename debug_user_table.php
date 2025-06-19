<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Fix the syntax error on this line
echo "<h1>Dolibarr Societe Table Debug</h1>";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Check if h8pd_societe table exists
    $query = "SHOW TABLES LIKE 'h8pd_societe'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        echo "<p style='color:red'>Table h8pd_societe does not exist!</p>";
    } else {
        echo "<p style='color:green'>Table h8pd_societe exists.</p>";
        
        // Show table structure
        echo "<h2>Table Structure:</h2>";
        $descQuery = "DESCRIBE h8pd_societe";
        $descStmt = $conn->prepare($descQuery);
        $descStmt->execute();
        
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        while ($column = $descStmt->fetch(PDO::FETCH_ASSOC)) {
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
        
        // Check for required fields for user authentication
        $requiredFields = ['nom', 'email', 'pass_crypted', 'status', 'datec'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            $fieldQuery = "SHOW COLUMNS FROM h8pd_societe LIKE '$field'";
            $fieldStmt = $conn->prepare($fieldQuery);
            $fieldStmt->execute();
            
            if ($fieldStmt->rowCount() == 0) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            echo "<p style='color:red'>Missing required fields for user authentication: " . implode(', ', $missingFields) . "</p>";
            
            // Generate SQL to add missing fields
            echo "<h3>SQL to Add Missing Fields:</h3>";
            echo "<pre>";
            echo "ALTER TABLE h8pd_societe\n";
            foreach ($missingFields as $field) {
                switch ($field) {
                    case 'pass_crypted':
                        echo "ADD COLUMN pass_crypted VARCHAR(128) DEFAULT NULL,\n";
                        break;
                    case 'nom':
                        echo "ADD COLUMN nom VARCHAR(128) NOT NULL,\n";
                        break;
                    case 'email':
                        echo "ADD COLUMN email VARCHAR(100) DEFAULT NULL,\n";
                        break;
                    case 'status':
                        echo "ADD COLUMN status TINYINT(1) DEFAULT 1,\n";
                        break;
                    case 'datec':
                        echo "ADD COLUMN datec DATETIME DEFAULT CURRENT_TIMESTAMP,\n";
                        break;
                }
            }
            echo ";\n";
            echo "</pre>";
        } else {
            echo "<p style='color:green'>All required fields for user authentication are present.</p>";
        }
    }
    
    // Test a simple query
    echo "<h2>Sample Entries:</h2>";
    $userQuery = "SELECT rowid, nom as name, email, status, datec FROM h8pd_societe LIMIT 5";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->execute();
    
    if ($userStmt->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Created Date</th></tr>";
        
        while ($row = $userStmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['rowid'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['datec'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No entries found in the database.</p>";
    }
    
    // Create SQL to update User model
    echo "<h2>User Model Update:</h2>";
    echo "<p>Based on the actual structure of your h8pd_societe table, here's how your User model should be updated:</p>";
    
    echo "<pre>";
    echo "class User extends BaseModel {
    protected \$table = 'h8pd_societe';
    
    // Update field mappings to match Dolibarr structure
    protected \$fieldMappings = [
        'name' => 'nom',
        'firstname' => 'firstname', // Add if missing
        'lastname' => 'lastname',   // Add if missing
        'password' => 'pass_crypted'
    ];
    
    // Rest of your User model...
}";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>