<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Extrafields Authentication Test</h1>";

// Create database connection
$db = new Database();
$conn = $db->getConnection();

// Create User model
$userModel = new User();

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        echo "<h2>Testing Login</h2>";
        echo "<p>Email: " . htmlspecialchars($email) . "</p>";
        
        $user = $userModel->login($email, $password);
        
        if ($user) {
            echo "<p style='color:green'>✓ Login successful!</p>";
            echo "<h3>User Details:</h3>";
            echo "<table border='1' cellpadding='5'>";
            foreach ($user as $key => $value) {
                echo "<tr><td><strong>" . htmlspecialchars($key) . "</strong></td><td>" . htmlspecialchars($value ?? 'NULL') . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>✗ Login failed</p>";
        }
    } elseif ($action === 'register') {
        $userData = [
            'firstname' => $_POST['firstname'] ?? '',
            'lastname' => $_POST['lastname'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'company_name' => $_POST['company_name'] ?? ''
        ];
        
        echo "<h2>Testing Registration</h2>";
        
        $userId = $userModel->register($userData);
        
        if ($userId) {
            echo "<p style='color:green'>✓ Registration successful! User ID: " . $userId . "</p>";
            echo "<p>You can now login with:</p>";
            echo "<ul>";
            echo "<li>Email: " . htmlspecialchars($userData['email']) . "</li>";
            echo "<li>Password: " . htmlspecialchars($userData['password']) . "</li>";
            echo "</ul>";
        } else {
            echo "<p style='color:red'>✗ Registration failed</p>";
        }
    } elseif ($action === 'update_password') {
        $userId = $_POST['user_id'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        
        echo "<h2>Testing Password Update</h2>";
        
        if ($userModel->updatePassword($userId, $newPassword)) {
            echo "<p style='color:green'>✓ Password updated successfully!</p>";
        } else {
            echo "<p style='color:red'>✗ Password update failed</p>";
        }
    }
}

// Display test forms
echo "<h2>Test Login</h2>";
echo "<form method='post'>";
echo "<input type='hidden' name='action' value='login'>";
echo "<p><input type='email' name='email' placeholder='Email' required></p>";
echo "<p><input type='password' name='password' placeholder='Password' required></p>";
echo "<p><button type='submit'>Test Login</button></p>";
echo "</form>";

echo "<h2>Test Registration</h2>";
echo "<form method='post'>";
echo "<input type='hidden' name='action' value='register'>";
echo "<p><input type='text' name='firstname' placeholder='First Name' required></p>";
echo "<p><input type='text' name='lastname' placeholder='Last Name' required></p>";
echo "<p><input type='email' name='email' placeholder='Email' required></p>";
echo "<p><input type='password' name='password' placeholder='Password' required></p>";
echo "<p><input type='text' name='company_name' placeholder='Company Name (optional)'></p>";
echo "<p><button type='submit'>Test Registration</button></p>";
echo "</form>";

// Display existing users
echo "<h2>Existing Users</h2>";
try {
    $query = "SELECT s.rowid, s.nom, s.email, IF(e.pass_crypted IS NOT NULL, 'Yes', 'No') as has_password
              FROM h8pd_societe s
              LEFT JOIN h8pd_societe_extrafields e ON s.rowid = e.fk_object
              WHERE s.email IS NOT NULL
              ORDER BY s.rowid DESC
              LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Has Password</th><th>Actions</th></tr>";
        
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $user['rowid'] . "</td>";
            echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . $user['has_password'] . "</td>";
            echo "<td>";
            echo "<form method='post' style='display:inline;'>";
            echo "<input type='hidden' name='action' value='update_password'>";
            echo "<input type='hidden' name='user_id' value='" . $user['rowid'] . "'>";
            echo "<input type='password' name='new_password' placeholder='New Password' required>";
            echo "<button type='submit'>Update Password</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No users found with email addresses.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>