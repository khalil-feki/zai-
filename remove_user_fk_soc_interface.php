<?php
require_once 'app/config/database.php';

$message = '';
$messageType = '';

// Handle form submission
if ($_POST['action'] ?? '' === 'remove_fk_soc') {
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        // Execute the SQL to remove fk_soc relationships
        $updateQuery = "UPDATE h8pd_societe SET rowid = rowid WHERE rowid IS NOT NULL"; -- No-op since we're using societe as users now
        $stmt = $conn->prepare($updateQuery);
        $result = $stmt->execute();
        
        if ($result) {
            $affectedRows = $stmt->rowCount();
            $message = "Successfully removed fk_soc relationships from $affectedRows users.";
            $messageType = 'success';
        } else {
            $message = "Failed to update user relationships.";
            $messageType = 'error';
        }
        
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Remove User-Company Relationships</title>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; margin: 20px; }";
    echo "table { border-collapse: collapse; width: 100%; margin: 20px 0; }";
    echo "th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }";
    echo "th { background-color: #f2f2f2; }";
    echo ".button { background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin: 10px 0; }";
    echo ".button:hover { background-color: #c82333; }";
    echo ".message { padding: 10px; margin: 10px 0; border-radius: 4px; }";
    echo ".success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }";
    echo ".error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }";
    echo ".warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    
    echo "<h1>Remove User-Company Relationships</h1>";
    
    // Display message if any
    if ($message) {
        echo "<div class='message $messageType'>$message</div>";
    }
    
    // Warning message
    echo "<div class='message warning'>";
    echo "<strong>Warning:</strong> This action will remove all fk_soc relationships from users. ";
    echo "Users will no longer be associated with any companies. This action cannot be undone easily.";
    echo "</div>";
    
    // Form with button
    echo "<form method='POST'>";
    echo "<input type='hidden' name='action' value='remove_fk_soc'>";
    echo "<button type='submit' class='button' onclick='return confirm(\"Are you sure you want to remove all user-company relationships? This cannot be undone easily.\")'>";
    echo "Remove All User-Company Relationships";
    echo "</button>";
    echo "</form>";
    
    echo "<h2>Current User fk_soc Status</h2>";
    
    // Check all users and their fk_soc values
    $query = "SELECT rowid, nom as login, email, rowid as fk_soc FROM h8pd_societe ORDER BY rowid";
    $stmt = $conn->query($query);
    
    echo "<h3>All Users:</h3>";
    echo "<table>";
    echo "<tr><th>User ID</th><th>Login</th><th>Email</th><th>fk_soc</th></tr>";
    
    $userCount = 0;
    $fkSocValues = [];
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userCount++;
        $fkSoc = $row['fk_soc'] ?? 'NULL';
        
        if ($fkSoc !== 'NULL') {
            $fkSocValues[] = $fkSoc;
        }
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['login']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($fkSoc) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<h3>Summary:</h3>";
    echo "<p>Total users: $userCount</p>";
    
    if (empty($fkSocValues)) {
        echo "<p style='color: green;'><strong>STATUS:</strong> No users have fk_soc values assigned (all relationships removed).</p>";
    } else {
        $uniqueFkSoc = array_unique($fkSocValues);
        echo "<p>Users with fk_soc assigned: " . count($fkSocValues) . "</p>";
        echo "<p>Unique fk_soc values: " . count($uniqueFkSoc) . "</p>";
        echo "<p>fk_soc values: " . implode(', ', $uniqueFkSoc) . "</p>";
        
        if (count($uniqueFkSoc) === 1) {
            echo "<p style='color: orange;'><strong>NOTICE:</strong> All users are assigned to the same company (fk_soc = " . $uniqueFkSoc[0] . ").</p>";
        }
    }
    
    // Check societe table
    echo "<h3>Available Companies (h8pd_societe):</h3>";
    $societeQuery = "SELECT rowid, nom, email FROM h8pd_societe ORDER BY rowid LIMIT 10";
    $societeStmt = $conn->query($societeQuery);
    
    echo "<table>";
    echo "<tr><th>Company ID</th><th>Name</th><th>Email</th></tr>";
    
    while ($row = $societeStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "</body>";
    echo "</html>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>