<?php
require_once 'app/config/database.php';
require_once 'app/services/DolibarrService.php';

echo "Checking and fixing user fk_soc assignments...\n\n";

try {
    // Create database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    // Check current status
    $query = "SELECT COUNT(*) as total_users, 
                     COUNT(fk_soc) as users_with_company,
                     COUNT(*) - COUNT(fk_soc) as users_without_company
              FROM h8pd_societe WHERE email IS NOT NULL";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Current Status:\n";
    echo "- Total users with email: {$stats['total_users']}\n";
    echo "- Users with company assigned: {$stats['users_with_company']}\n";
    echo "- Users without company: {$stats['users_without_company']}\n\n";
    
    if ($stats['users_without_company'] == 0) {
        echo "✓ All users already have companies assigned!\n";
        exit;
    }
    
    // Get users without company assignment (limit to 5 for testing)
    $query = "SELECT rowid, login, email, firstname, lastname 
              FROM h8pd_societe 
              WHERE fk_soc IS NULL AND email IS NOT NULL 
              LIMIT 5";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Processing first 5 users without company assignment:\n";
    
    $dolibarrService = new DolibarrService();
    $updated = 0;
    
    foreach ($users as $user) {
        echo "\nProcessing user: {$user['email']} (ID: {$user['rowid']})\n";
        
        try {
            // Try to find existing company by email
            $existingCustomer = $dolibarrService->getCustomerByEmail($user['email']);
            $companyId = null;
            
            if ($existingCustomer && isset($existingCustomer['id'])) {
                $companyId = $existingCustomer['id'];
                echo "  ✓ Found existing company ID: {$companyId}\n";
            } else {
                // Create new company
                $customerData = [
                    'name' => trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')),
                    'email' => $user['email'],
                    'client' => 1
                ];
                
                echo "  → Creating new company for: {$customerData['name']}\n";
                $newCustomer = $dolibarrService->createCustomer($customerData);
                
                if ($newCustomer && isset($newCustomer['id'])) {
                    $companyId = $newCustomer['id'];
                    echo "  ✓ Created new company ID: {$companyId}\n";
                } else {
                    echo "  ✗ Failed to create company\n";
                    continue;
                }
            }
            
            if ($companyId) {
                // Update user with company ID
                $updateQuery = "UPDATE h8pd_societe SET rowid = :company_id WHERE rowid = :user_id"; -- No-op since we're using societe as users now
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bindParam(':company_id', $companyId);
                $updateStmt->bindParam(':user_id', $user['rowid']);
                
                if ($updateStmt->execute()) {
                    $updated++;
                    echo "  ✓ Updated user with company ID {$companyId}\n";
                } else {
                    echo "  ✗ Failed to update user\n";
                }
            }
            
        } catch (Exception $e) {
            echo "  ✗ Error processing user: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== SUMMARY ===\n";
    echo "Successfully updated {$updated} users\n";
    
    // Show final status
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $finalStats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "\nFinal Status:\n";
    echo "- Users with company assigned: {$finalStats['users_with_company']}\n";
    echo "- Users without company: {$finalStats['users_without_company']}\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nScript completed.\n";
?>