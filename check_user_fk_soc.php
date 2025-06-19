<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<h2>User fk_soc Analysis</h2>";
    
    // Check all users and their fk_soc values
    $query = "SELECT rowid, nom as login, email, rowid as fk_soc FROM h8pd_societe ORDER BY rowid";
    $stmt = $conn->query($query);
    
    echo "<h3>All Users:</h3>";
    echo "<table border='1'>";
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
        echo "<p style='color: red;'><strong>PROBLEM FOUND:</strong> No users have fk_soc values assigned!</p>";
    } else {
        $uniqueFkSoc = array_unique($fkSocValues);
        echo "<p>Users with fk_soc assigned: " . count($fkSocValues) . "</p>";
        echo "<p>Unique fk_soc values: " . count($uniqueFkSoc) . "</p>";
        echo "<p>fk_soc values: " . implode(', ', $uniqueFkSoc) . "</p>";
        
        if (count($uniqueFkSoc) === 1) {
            echo "<p style='color: orange;'><strong>ISSUE FOUND:</strong> All users are assigned to the same company (fk_soc = " . $uniqueFkSoc[0] . ")!</p>";
        }
    }
    
    // Check societe table
    echo "<h3>Available Companies (h8pd_societe):</h3>";
    $societeQuery = "SELECT rowid, nom, email FROM h8pd_societe ORDER BY rowid LIMIT 10";
    $societeStmt = $conn->query($societeQuery);
    
    echo "<table border='1'>";
    echo "<tr><th>Company ID</th><th>Name</th><th>Email</th></tr>";
    
    while ($row = $societeStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Check recent orders
    echo "<h3>Recent Orders:</h3>";
    $orderQuery = "SELECT rowid, ref, fk_soc, fk_user_author, date_creation FROM h8pd_commande ORDER BY date_creation DESC LIMIT 10";
    $orderStmt = $conn->query($orderQuery);
    
    echo "<table border='1'>";
    echo "<tr><th>Order ID</th><th>Reference</th><th>fk_soc</th><th>fk_user_author</th><th>Date</th></tr>";
    
    while ($row = $orderStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ref']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fk_soc']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fk_user_author']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_creation']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>