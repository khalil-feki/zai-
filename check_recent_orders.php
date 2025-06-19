<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    echo "<h2>Recent Orders Analysis</h2>";
    
    // Get recent orders with company and user information
    $stmt = $pdo->query("
        SELECT 
            c.rowid, 
            c.ref, 
            c.fk_soc, 
            c.fk_user_author, 
            c.date_creation,
            s.nom as company_name, 
            s.email as company_email,
            u.login as user_login,
            u.email as user_email
        FROM h8pd_commande c 
        LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid 
        LEFT JOIN h8pd_societe u ON c.fk_user_author = u.rowid 
        ORDER BY c.date_creation DESC 
        LIMIT 10
    ");
    
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr>";
    echo "<th>Order Ref</th>";
    echo "<th>Date</th>";
    echo "<th>Company ID (fk_soc)</th>";
    echo "<th>Company Name</th>";
    echo "<th>Company Email</th>";
    echo "<th>User ID (fk_user_author)</th>";
    echo "<th>User Login</th>";
    echo "<th>User Email</th>";
    echo "</tr>";
    
    foreach($orders as $order) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($order['ref']) . "</td>";
        echo "<td>" . htmlspecialchars($order['date_creation']) . "</td>";
        echo "<td>" . htmlspecialchars($order['fk_soc']) . "</td>";
        echo "<td>" . htmlspecialchars($order['company_name']) . "</td>";
        echo "<td>" . htmlspecialchars($order['company_email']) . "</td>";
        echo "<td>" . htmlspecialchars($order['fk_user_author']) . "</td>";
        echo "<td>" . htmlspecialchars($order['user_login']) . "</td>";
        echo "<td>" . htmlspecialchars($order['user_email']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<h3>Analysis:</h3>";
    echo "<p>This shows the relationship between orders, companies, and users.</p>";
    echo "<p>- <strong>fk_soc</strong>: The company ID that the order belongs to</p>";
    echo "<p>- <strong>fk_user_author</strong>: The user who created the order</p>";
    echo "<p>- <strong>Company Name</strong>: The name of the company the order is assigned to</p>";
    echo "<p>- <strong>User Login</strong>: The login of the user who created the order</p>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>