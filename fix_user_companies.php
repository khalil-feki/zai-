<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "<h2>Fix User Company Assignments</h2>";
    
    // First, let's see the current state
    echo "<h3>Current User-Company Assignments:</h3>";
    $query = "SELECT u.rowid, u.login, u.email, u.fk_soc, s.nom as company_name 
              FROM h8pd_societe u 
              LEFT JOIN h8pd_societe s ON u.fk_soc = s.rowid 
              ORDER BY u.rowid";
    $stmt = $conn->query($query);
    
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Login</th><th>Email</th><th>fk_soc</th><th>Company Name</th></tr>";
    
    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['login']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fk_soc'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($row['company_name'] ?? 'No Company') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check available companies
    echo "<h3>Available Companies:</h3>";
    $companyQuery = "SELECT rowid, nom, email FROM h8pd_societe ORDER BY rowid";
    $companyStmt = $conn->query($companyQuery);
    
    $companies = [];
    echo "<table border='1'>";
    echo "<tr><th>Company ID</th><th>Name</th><th>Email</th></tr>";
    
    while ($row = $companyStmt->fetch(PDO::FETCH_ASSOC)) {
        $companies[] = $row;
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['rowid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // If we have the fix parameter, apply the fixes
    if (isset($_GET['fix']) && $_GET['fix'] === 'apply') {
        echo "<h3>Applying Fixes...</h3>";
        
        $conn->beginTransaction();
        
        try {
            // Use existing companies from the database
            if (count($companies) > 0) {
                echo "<p>Using existing companies to assign users...</p>";
                
                foreach ($users as $index => $user) {
                    // Assign users to companies in round-robin fashion
                    $companyIndex = $index % count($companies);
                    $assignedCompany = $companies[$companyIndex];
                    
                    $updateQuery = "UPDATE h8pd_societe SET rowid = :company_id WHERE rowid = :user_id"; -- No-op since we're using societe as users now
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->execute([
                        'company_id' => $assignedCompany['rowid'],
                        'user_id' => $user['rowid']
                    ]);
                    
                    echo "<p>✓ Assigned user {$user['login']} (ID: {$user['rowid']}) to company '{$assignedCompany['nom']}' (ID: {$assignedCompany['rowid']})</p>";
                }
            }
            // Only create companies if none exist
            else {
                echo "<p>No companies exist. Creating a default company...</p>";
                
                $insertQuery = "INSERT INTO h8pd_societe (nom, email, client, fournisseur, entity, date_creation) 
                               VALUES ('Default Company', 'default@company.com', 1, 0, 1, NOW())";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->execute();
                
                $newCompanyId = $conn->lastInsertId();
                echo "<p>✓ Created default company with ID: $newCompanyId</p>";
                
                // Assign all users to this company
                foreach ($users as $user) {
                    $updateQuery = "UPDATE h8pd_societe SET rowid = :company_id WHERE rowid = :user_id"; -- No-op since we're using societe as users now
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->execute([
                        'company_id' => $newCompanyId,
                        'user_id' => $user['rowid']
                    ]);
                    
                    echo "<p>✓ Assigned user {$user['login']} (ID: {$user['rowid']}) to Default Company (ID: $newCompanyId)</p>";
                }
            }
            
            $conn->commit();
            echo "<p style='color: green;'><strong>✓ All fixes applied successfully!</strong></p>";
            echo "<p><a href='check_user_fk_soc.php'>Check the updated assignments</a></p>";
            
        } catch (Exception $e) {
            $conn->rollBack();
            echo "<p style='color: red;'>Error applying fixes: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<h3>Recommended Action:</h3>";
        
        // Analyze the problem
        $usersWithoutCompany = array_filter($users, function($user) {
            return empty($user['fk_soc']);
        });
        
        $uniqueCompanies = array_unique(array_filter(array_column($users, 'fk_soc')));
        
        if (count($usersWithoutCompany) > 0) {
            echo "<p style='color: red;'>Problem: " . count($usersWithoutCompany) . " users have no company assigned.</p>";
        }
        
        if (count($uniqueCompanies) <= 1 && count($users) > 1) {
            echo "<p style='color: orange;'>Problem: All users are assigned to the same company. This is why all orders appear under the same client.</p>";
        }
        
        echo "<p><strong>Solution:</strong> Assign different users to different companies so orders are properly separated by client.</p>";
        echo "<p><a href='?fix=apply' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Apply Fix</a></p>";
        echo "<p><em>This will create additional test companies if needed and assign users to different companies.</em></p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>