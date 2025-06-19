<?php
/**
 * Automated User Synchronization Script
 * This script automatically:
 * 1. Fixes all existing users (adds missing users from h8pd_societe to h8pd_user)
 * 2. Installs the database trigger for future automatic synchronization
 * 3. Provides a complete automated solution
 */

require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h1>🚀 Automated User Synchronization System</h1>";
    echo "<p>This script will automatically fix all user synchronization issues and set up automatic handling for future users.</p>";
    
    echo "<div style='background: #f0f8ff; padding: 15px; border-left: 4px solid #007cba; margin: 20px 0;'>";
    echo "<h3>📋 Process Overview:</h3>";
    echo "<ol>";
    echo "<li>✅ Fix existing users (sync h8pd_societe → h8pd_user)</li>";
    echo "<li>✅ Install automatic trigger for future users</li>";
    echo "<li>✅ Verify complete setup</li>";
    echo "</ol>";
    echo "</div>";
    
    // Step 1: Fix existing users
    echo "<h2>Step 1: 🔧 Fixing Existing Users</h2>";
    
    // Find users in h8pd_societe that are missing from h8pd_user
    $query = "SELECT s.rowid, s.nom, s.email 
              FROM h8pd_societe s 
              LEFT JOIN h8pd_user u ON s.rowid = u.fk_soc 
              WHERE u.fk_soc IS NULL AND s.email IS NOT NULL AND s.email != ''";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $missingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($missingUsers)) {
        echo "<p style='color: green;'>✅ All users are already synchronized! No missing users found.</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Found " . count($missingUsers) . " users that need to be added to h8pd_user table.</p>";
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($missingUsers as $user) {
            try {
                // Extract name parts
                $nameParts = explode(' ', trim($user['nom']));
                $firstname = $nameParts[0] ?? '';
                $lastname = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : 'User';
                
                // Generate unique login
                $baseLogin = strtolower(str_replace([' ', '@', '.'], '', $user['email']));
                $baseLogin = substr($baseLogin, 0, strpos($baseLogin, '@') ?: strlen($baseLogin));
                
                $login = $baseLogin;
                $counter = 1;
                while (true) {
                    $checkQuery = "SELECT COUNT(*) FROM h8pd_user WHERE login = :login";
                    $checkStmt = $db->prepare($checkQuery);
                    $checkStmt->bindParam(':login', $login);
                    $checkStmt->execute();
                    
                    if ($checkStmt->fetchColumn() == 0) {
                        break;
                    }
                    
                    $login = $baseLogin . $counter;
                    $counter++;
                }
                
                // Generate default password
                $defaultPassword = $login . '123';
                
                // Insert into h8pd_user
                $insertQuery = "INSERT INTO h8pd_user 
                               (entity, employee, datec, tms, login, pass_crypted, lastname, firstname, email, admin, fk_soc, statut) 
                               VALUES 
                               (1, 1, NOW(), NOW(), :login, MD5(:password), :lastname, :firstname, :email, 0, :fk_soc, 1)";
                
                $insertStmt = $db->prepare($insertQuery);
                $insertStmt->bindParam(':login', $login);
                $insertStmt->bindParam(':password', $defaultPassword);
                $insertStmt->bindParam(':lastname', $lastname);
                $insertStmt->bindParam(':firstname', $firstname);
                $insertStmt->bindParam(':email', $user['email']);
                $insertStmt->bindParam(':fk_soc', $user['rowid']);
                
                if ($insertStmt->execute()) {
                    echo "<p style='color: green;'>✅ Added user: {$user['email']} (login: {$login})</p>";
                    $successCount++;
                } else {
                    echo "<p style='color: red;'>❌ Failed to add user: {$user['email']}</p>";
                    $errorCount++;
                }
                
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error adding user {$user['email']}: " . $e->getMessage() . "</p>";
                $errorCount++;
            }
        }
        
        echo "<div style='background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>📊 Step 1 Results:</h4>";
        echo "<p>✅ Successfully added: {$successCount} users</p>";
        if ($errorCount > 0) {
            echo "<p>❌ Errors: {$errorCount} users</p>";
        }
        echo "</div>";
    }
    
    // Step 2: Install the trigger
    echo "<h2>Step 2: ⚡ Installing Automatic Trigger</h2>";
    
    // Drop existing trigger if it exists
    try {
        $db->exec("DROP TRIGGER IF EXISTS auto_create_user_after_societe_insert");
        echo "<p style='color: green;'>✅ Removed any existing trigger</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠ No existing trigger found (this is normal)</p>";
    }
    
    // Create the new trigger
    $triggerSQL = "
    CREATE TRIGGER auto_create_user_after_societe_insert
    AFTER INSERT ON h8pd_societe
    FOR EACH ROW
    BEGIN
        DECLARE user_login VARCHAR(255);
        DECLARE user_firstname VARCHAR(255);
        DECLARE user_lastname VARCHAR(255);
        DECLARE default_password VARCHAR(255);
        DECLARE login_counter INT DEFAULT 1;
        DECLARE base_login VARCHAR(255);
        
        -- Only create user if email is provided and not empty
        IF NEW.email IS NOT NULL AND NEW.email != '' THEN
            
            -- Extract name parts from nom field
            SET user_firstname = TRIM(SUBSTRING_INDEX(NEW.nom, ' ', 1));
            SET user_lastname = TRIM(SUBSTRING(NEW.nom, LOCATE(' ', NEW.nom) + 1));
            
            -- If no space in nom, use the whole name as firstname
            IF user_lastname = user_firstname THEN
                SET user_lastname = CONCAT('User', NEW.rowid);
            END IF;
            
            -- Create base login from email (part before @)
            SET base_login = LOWER(SUBSTRING_INDEX(NEW.email, '@', 1));
            SET base_login = REPLACE(REPLACE(REPLACE(base_login, ' ', ''), '.', ''), '-', '');
            SET user_login = base_login;
            
            -- Ensure login is unique
            WHILE (SELECT COUNT(*) FROM h8pd_user WHERE login = user_login) > 0 DO
                SET user_login = CONCAT(base_login, login_counter);
                SET login_counter = login_counter + 1;
            END WHILE;
            
            -- Set default password
            SET default_password = CONCAT(user_login, '123');
            
            -- Insert into h8pd_user table
            INSERT INTO h8pd_user (
                entity, 
                employee, 
                datec, 
                tms, 
                login, 
                pass_crypted, 
                lastname, 
                firstname, 
                email, 
                admin, 
                fk_soc, 
                statut
            ) VALUES (
                1,                    -- entity
                1,                    -- employee
                NOW(),                -- datec
                NOW(),                -- tms
                user_login,           -- login
                MD5(default_password), -- pass_crypted (MD5 hashed)
                user_lastname,        -- lastname
                user_firstname,       -- firstname
                NEW.email,            -- email
                0,                    -- admin (not admin)
                NEW.rowid,            -- fk_soc (link to societe)
                1                     -- statut (active)
            );
            
        END IF;
    END";
    
    try {
        $db->exec($triggerSQL);
        echo "<p style='color: green;'>✅ Automatic trigger installed successfully!</p>";
        echo "<p style='color: blue;'>ℹ️ From now on, all new users registered in h8pd_societe will automatically be added to h8pd_user.</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Failed to create trigger: " . $e->getMessage() . "</p>";
        throw $e;
    }
    
    // Step 3: Verification
    echo "<h2>Step 3: 🔍 Verification</h2>";
    
    // Check current user counts
    $societeCount = $db->query("SELECT COUNT(*) FROM h8pd_societe WHERE email IS NOT NULL AND email != ''");
    $userCount = $db->query("SELECT COUNT(*) FROM h8pd_user WHERE fk_soc IS NOT NULL");
    $triggerCount = $db->query("SELECT COUNT(*) FROM information_schema.triggers WHERE trigger_name = 'auto_create_user_after_societe_insert'");
    
    echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>📈 Current Status:</h4>";
    echo "<p>👥 Users in h8pd_societe (with email): " . $societeCount->fetchColumn() . "</p>";
    echo "<p>🔗 Users in h8pd_user (linked): " . $userCount->fetchColumn() . "</p>";
    echo "<p>⚡ Active triggers: " . $triggerCount->fetchColumn() . "</p>";
    echo "</div>";
    
    // Check for any remaining missing users
    $remainingMissing = $db->query(
        "SELECT COUNT(*) FROM h8pd_societe s 
         LEFT JOIN h8pd_user u ON s.rowid = u.fk_soc 
         WHERE u.fk_soc IS NULL AND s.email IS NOT NULL AND s.email != ''"
    );
    
    $missingCount = $remainingMissing->fetchColumn();
    
    if ($missingCount == 0) {
        echo "<div style='background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: center;'>";
        echo "<h2 style='color: green; margin: 0;'>🎉 AUTOMATION COMPLETE! 🎉</h2>";
        echo "<p style='font-size: 18px; margin: 10px 0;'>✅ All users are synchronized</p>";
        echo "<p style='font-size: 18px; margin: 10px 0;'>⚡ Automatic trigger is active</p>";
        echo "<p style='font-size: 16px; color: #666;'>Your system is now fully automated!</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4 style='color: orange;'>⚠ Warning:</h4>";
        echo "<p>There are still {$missingCount} users that couldn't be synchronized. Please check the errors above.</p>";
        echo "</div>";
    }
    
    echo "<h2>🔮 What Happens Next?</h2>";
    echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px;'>";
    echo "<h4>Automatic Process:</h4>";
    echo "<ol>";
    echo "<li>🆕 When a new user registers → automatically added to both h8pd_societe and h8pd_user</li>";
    echo "<li>🛒 When placing orders → no more foreign key constraint errors</li>";
    echo "<li>⚡ Everything happens automatically in the background</li>";
    echo "<li>🔄 No manual intervention required</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4 style='color: green;'>✅ System Status: FULLY AUTOMATED</h4>";
    echo "<p>Your e-commerce system is now ready for automatic order placement without any user registration requirements!</p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4 style='color: red;'>❌ Automation Error:</h4>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Please check your database connection and permissions.</p>";
    echo "</div>";
}
?>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
}

h1, h2, h3, h4 {
    color: #333;
}

p {
    line-height: 1.6;
}

ol, ul {
    line-height: 1.8;
}
</style>