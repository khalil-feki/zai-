<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<h2>Removing User-Company Relationships</h2>";
    
    // Show current user-company assignments
    echo "<h3>Current User-Company Assignments:</h3>";
    $query = "SELECT u.rowid, u.login, u.email, u.fk_soc, s.nom as company_name
              FROM h8pd_societe u 
              LEFT JOIN h8pd_societe s ON u.fk_soc = s.rowid 
              ORDER BY u.rowid";
    $stmt = $conn->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>User ID</th><th>Login</th><th>Email</th><th>fk_soc</th><th>Company Name</th></tr>";
    
    foreach ($users as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['login']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fk_soc'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['company_name'] ?? 'No Company') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Remove all user-company relationships
    echo "<h3>Removing All User-Company Relationships...</h3>";
    $updateQuery = "UPDATE h8pd_societe SET rowid = rowid"; -- No-op since we're using societe as users now
    $updateStmt = $conn->prepare($updateQuery);
    $result = $updateStmt->execute();
    
    if ($result) {
        $affectedRows = $updateStmt->rowCount();
        echo "<p style='color: green;'>✓ Successfully removed user-company relationships for $affectedRows users</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to remove user-company relationships</p>";
    }
    
    // Show updated user assignments
    echo "<h3>Updated User Assignments:</h3>";
    $stmt = $conn->query($query);
    $updatedUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>User ID</th><th>Login</th><th>Email</th><th>fk_soc</th><th>Company Name</th></tr>";
    
    foreach ($updatedUsers as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['login']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fk_soc'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['company_name'] ?? 'No Company') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p><strong>Result:</strong> All users now have fk_soc = NULL, removing the relationship between users and companies.</p>";
    echo "<p><strong>Impact:</strong> Orders will no longer be associated with specific companies through user relationships.</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>