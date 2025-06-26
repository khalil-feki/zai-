<?php
// Diagnostic script to test password reset functionality
// This will help identify what's causing the issue

require_once 'app/config/database.php';
require_once 'app/models/User.php';

echo "<h2>Password Reset Diagnostic Test</h2>";
echo "<hr>";

try {
    // Test 1: Database Connection
    echo "<h3>1. Testing Database Connection</h3>";
    $database = new Database();
    $conn = $database->getConnection();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Test 2: Check if reset_tokens table exists
    echo "<h3>2. Checking reset_tokens Table</h3>";
    $checkTable = "SHOW TABLES LIKE 'reset_tokens'";
    $result = $conn->query($checkTable);
    
    if ($result->rowCount() > 0) {
        echo "<p style='color: green;'>✓ reset_tokens table exists</p>";
    } else {
        echo "<p style='color: red;'>✗ reset_tokens table does NOT exist</p>";
        echo "<p><strong>Creating reset_tokens table...</strong></p>";
        
        $createTable = "CREATE TABLE IF NOT EXISTS reset_tokens (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            token VARCHAR(64) NOT NULL,
            expires DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_token (token),
            INDEX idx_expires (expires),
            FOREIGN KEY (user_id) REFERENCES h8pd_societe(rowid) ON DELETE CASCADE
        ) ENGINE=InnoDB";
        
        $conn->exec($createTable);
        echo "<p style='color: green;'>✓ reset_tokens table created successfully</p>";
    }
    
    // Test 3: Check User model methods
    echo "<h3>3. Testing User Model Methods</h3>";
    $userModel = new User();
    
    if (method_exists($userModel, 'findByEmail')) {
        echo "<p style='color: green;'>✓ findByEmail method exists</p>";
    } else {
        echo "<p style='color: red;'>✗ findByEmail method missing</p>";
    }
    
    if (method_exists($userModel, 'saveResetToken')) {
        echo "<p style='color: green;'>✓ saveResetToken method exists</p>";
    } else {
        echo "<p style='color: red;'>✗ saveResetToken method missing</p>";
    }
    
    if (method_exists($userModel, 'verifyResetToken')) {
        echo "<p style='color: green;'>✓ verifyResetToken method exists</p>";
    } else {
        echo "<p style='color: red;'>✗ verifyResetToken method missing</p>";
    }
    
    // Test 4: Check PHP mail configuration
    echo "<h3>4. Testing PHP Mail Configuration</h3>";
    if (function_exists('mail')) {
        echo "<p style='color: green;'>✓ PHP mail function is available</p>";
        
        // Check mail settings
        $sendmail_path = ini_get('sendmail_path');
        $smtp = ini_get('SMTP');
        $smtp_port = ini_get('smtp_port');
        
        echo "<p><strong>Mail Settings:</strong></p>";
        echo "<ul>";
        echo "<li>Sendmail Path: " . ($sendmail_path ?: 'Not set') . "</li>";
        echo "<li>SMTP Server: " . ($smtp ?: 'Not set') . "</li>";
        echo "<li>SMTP Port: " . ($smtp_port ?: 'Not set') . "</li>";
        echo "</ul>";
        
        if (empty($sendmail_path) && empty($smtp)) {
            echo "<p style='color: orange;'>⚠ Warning: No mail configuration found. This might prevent emails from being sent.</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ PHP mail function is not available</p>";
    }
    
    // Test 5: Test with a sample email (if provided)
    echo "<h3>5. Test Password Reset Process</h3>";
    echo "<form method='post'>";
    echo "<p>Enter an email to test the password reset process:</p>";
    echo "<input type='email' name='test_email' placeholder='test@example.com' required>";
    echo "<button type='submit' name='test_reset'>Test Reset Process</button>";
    echo "</form>";
    
    if (isset($_POST['test_reset']) && !empty($_POST['test_email'])) {
        $testEmail = $_POST['test_email'];
        echo "<p><strong>Testing with email: $testEmail</strong></p>";
        
        // Check if user exists
        $user = $userModel->findByEmail($testEmail);
        if ($user) {
            echo "<p style='color: green;'>✓ User found with email: $testEmail</p>";
            
            // Generate token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Try to save token
            $saved = $userModel->saveResetToken($user['rowid'], $token, $expires);
            if ($saved) {
                echo "<p style='color: green;'>✓ Reset token saved successfully</p>";
                echo "<p><strong>Reset Link:</strong> <a href='?page=auth&action=reset-password&token=$token&email=" . urlencode($testEmail) . "'>Click here to reset password</a></p>";
            } else {
                echo "<p style='color: red;'>✗ Failed to save reset token</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠ No user found with email: $testEmail</p>";
        }
    }
    
    echo "<hr>";
    echo "<h3>Summary</h3>";
    echo "<p>If all tests pass, the password reset functionality should work. If you're still having issues:</p>";
    echo "<ol>";
    echo "<li>Check your server's email configuration</li>";
    echo "<li>Check spam/junk folders</li>";
    echo "<li>Verify the email address exists in the system</li>";
    echo "<li>Check server error logs</li>";
    echo "</ol>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>