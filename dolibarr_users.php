<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Dolibarr Users</h1>";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    // Get users from Dolibarr
    $query = "SELECT rowid, nom, firstname, lastname, email, status, client, fournisseur, code_client, datec 
              FROM h8pd_societe 
              WHERE email IS NOT NULL 
              ORDER BY datec DESC 
              LIMIT 50";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr>
                <th>ID</th>
                <th>Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Client</th>
                <th>Supplier</th>
                <th>Client Code</th>
                <th>Created Date</th>
                <th>Actions</th>
              </tr>";
        
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $user['rowid'] . "</td>";
            echo "<td>" . $user['nom'] . "</td>";
            echo "<td>" . $user['firstname'] . "</td>";
            echo "<td>" . $user['lastname'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>" . ($user['status'] == 1 ? 'Active' : 'Inactive') . "</td>";
            echo "<td>" . ($user['client'] == 1 ? 'Yes' : 'No') . "</td>";
            echo "<td>" . ($user['fournisseur'] == 1 ? 'Yes' : 'No') . "</td>";
            echo "<td>" . $user['code_client'] . "</td>";
            echo "<td>" . $user['datec'] . "</td>";
            echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='user_id' value='" . $user['rowid'] . "'>
                        <input type='hidden' name='email' value='" . $user['email'] . "'>
                        <input type='password' name='new_password' placeholder='New Password' required>
                        <button type='submit' name='reset_password'>Reset Password</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Process password reset
        if (isset($_POST['reset_password'])) {
            $userId = $_POST['user_id'];
            $email = $_POST['email'];
            $newPassword = $_POST['new_password'];
            
            // Update password in database
            $hashedPassword = md5($newPassword);
            $updateQuery = "UPDATE h8pd_societe SET pass_crypted = :password WHERE rowid = :id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':id', $userId);
            
            if ($updateStmt->execute()) {
                echo "<p style='color: green;'>Password updated successfully for " . $email . "!</p>";
            } else {
                echo "<p style='color: red;'>Failed to update password.</p>";
            }
        }
    } else {
        echo "<p>No users found in Dolibarr.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>