<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "<h1>Create Automatic User Synchronization Trigger</h1>";
    echo "<p>This script creates a MySQL trigger that automatically adds users to h8pd_user table whenever they are added to h8pd_societe.</p>";
    
    // First, drop the trigger if it exists
    $dropTriggerSQL = "DROP TRIGGER IF EXISTS auto_create_user_after_societe_insert";
    
    echo "<h2>Step 1: Removing existing trigger (if any)</h2>";
    try {
        $db->exec($dropTriggerSQL);
        echo "<p style='color: green;'>✓ Existing trigger removed successfully</p>";
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠ No existing trigger found (this is normal): " . $e->getMessage() . "</p>";
    }
    
    // Create the trigger
    $createTriggerSQL = "
    CREATE TRIGGER auto_create_user_after_societe_insert
    AFTER INSERT ON h8pd_societe
    FOR EACH ROW
    BEGIN
        DECLARE user_login VARCHAR(255);
        DECLARE user_firstname VARCHAR(255);
        DECLARE user_lastname VARCHAR(255);
        DECLARE default_password VARCHAR(255);
        
        -- Only create user if email is provided and not empty
        IF NEW.email IS NOT NULL AND NEW.email != '' THEN
            
            -- Extract name parts from nom field
            SET user_firstname = TRIM(SUBSTRING_INDEX(NEW.nom, ' ', 1));
            SET user_lastname = TRIM(SUBSTRING(NEW.nom, LOCATE(' ', NEW.nom) + 1));
            
            -- If no space in nom, use the whole name as firstname
            IF user_lastname = user_firstname THEN
                SET user_lastname = CONCAT('User', NEW.rowid);
            END IF;
            
            -- Create login from email (part before @)
            SET user_login = SUBSTRING_INDEX(NEW.email, '@', 1);
            
            -- Ensure login is unique by appending user ID if needed
            IF (SELECT COUNT(*) FROM h8pd_user WHERE login = user_login) > 0 THEN
                SET user_login = CONCAT(user_login, '_', NEW.rowid);
            END IF;
            
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
    END
    ";
    
    echo "<h2>Step 2: Creating new automatic trigger</h2>";
    try {
        $db->exec($createTriggerSQL);
        echo "<p style='color: green; font-weight: bold;'>✅ SUCCESS: Automatic user creation trigger installed!</p>";
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h3>What this trigger does:</h3>";
        echo "<ul>";
        echo "<li>🔄 <strong>Automatically runs</strong> whenever a new user is added to h8pd_societe</li>";
        echo "<li>👤 <strong>Creates corresponding entry</strong> in h8pd_user table</li>";
        echo "<li>🔑 <strong>Generates login</strong> from email address</li>";
        echo "<li>🔒 <strong>Sets default password</strong> as {login}123</li>";
        echo "<li>🔗 <strong>Links tables</strong> via fk_soc foreign key</li>";
        echo "<li>✅ <strong>Prevents future</strong> foreign key constraint errors</li>";
        echo "</ul>";
        echo "</div>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Failed to create trigger: " . $e->getMessage() . "</p>";
        echo "<p>This might be due to insufficient database privileges. You may need to run this with elevated MySQL permissions.</p>";
    }
    
    // Test the trigger by showing current triggers
    echo "<h2>Step 3: Verification</h2>";
    try {
        $stmt = $db->query("SHOW TRIGGERS LIKE 'h8pd_societe'");
        $triggers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($triggers)) {
            echo "<p style='color: green;'>✓ Active triggers on h8pd_societe table:</p>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Trigger Name</th><th>Event</th><th>Timing</th><th>Statement</th></tr>";
            foreach ($triggers as $trigger) {
                echo "<tr>";
                echo "<td>{$trigger['Trigger']}</td>";
                echo "<td>{$trigger['Event']}</td>";
                echo "<td>{$trigger['Timing']}</td>";
                echo "<td style='max-width: 300px; word-wrap: break-word;'>" . substr($trigger['Statement'], 0, 100) . "...</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: orange;'>⚠ No triggers found on h8pd_societe table</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error checking triggers: " . $e->getMessage() . "</p>";
    }
    
    // Show example of what happens
    echo "<h2>Step 4: How It Works</h2>";
    echo "<div style='background: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 5px;'>";
    echo "<h3>Example Scenario:</h3>";
    echo "<p><strong>When:</strong> A new user is added to h8pd_societe with email 'john.doe@example.com' and name 'John Doe'</p>";
    echo "<p><strong>Trigger automatically:</strong></p>";
    echo "<ol>";
    echo "<li>Creates login: 'john.doe' (from email)</li>";
    echo "<li>Sets password: 'john.doe123' (login + '123')</li>";
    echo "<li>Splits name: firstname='John', lastname='Doe'</li>";
    echo "<li>Inserts into h8pd_user with proper foreign key link</li>";
    echo "<li>Orders can now be placed without constraint errors!</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<h2>Step 5: Testing Instructions</h2>";
    echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px;'>";
    echo "<p><strong>To test the trigger:</strong></p>";
    echo "<ol>";
    echo "<li>Try registering a new user through your website</li>";
    echo "<li>Check that the user appears in both h8pd_societe AND h8pd_user tables</li>";
    echo "<li>Attempt to place an order - it should work without foreign key errors</li>";
    echo "</ol>";
    echo "<p><strong>Note:</strong> This trigger only affects NEW users. Existing users still need the fix script we created earlier.</p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px;'>";
    echo "<h3 style='color: red;'>Database Connection Error:</h3>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    line-height: 1.6;
}
h1, h2, h3 {
    color: #333;
}
table {
    margin: 10px 0;
}
th, td {
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
</style>