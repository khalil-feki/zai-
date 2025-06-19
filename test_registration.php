<?php
require_once 'app/models/UserModel.php';

echo "Testing new user registration with automatic company assignment...\n\n";

try {
    $userModel = new UserModel();
    
    // Test data for new user
    $testUser = [
        'username' => 'testuser' . time(),
        'email' => 'testuser' . time() . '@example.com',
        'password' => 'testpassword123',
        'firstname' => 'Test',
        'lastname' => 'User'
    ];
    
    echo "Attempting to register user: {$testUser['email']}\n";
    
    // Register the user
    $userId = $userModel->register($testUser);
    
    if ($userId) {
        echo "✓ User registered successfully with ID: {$userId}\n";
        
        // Get the user details to verify fk_soc assignment
        $user = $userModel->getUserById($userId);
        if ($user) {
            echo "✓ User details retrieved:\n";
            echo "  - ID: {$user['rowid']}\n";
            echo "  - Login: {$user['login']}\n";
            echo "  - Email: {$user['email']}\n";
            echo "  - Company ID (fk_soc): " . ($user['fk_soc'] ?? 'NULL') . "\n";
            
            if ($user['fk_soc']) {
                echo "✓ SUCCESS: User automatically assigned to company ID {$user['fk_soc']}\n";
            } else {
                echo "⚠ WARNING: User was not assigned to any company\n";
            }
        }
    } else {
        echo "✗ Failed to register user\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";
?>