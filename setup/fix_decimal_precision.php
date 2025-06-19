<?php
/**
 * Database Migration Script
 * Fixes decimal precision mismatch between product and order tables
 * 
 * Issue: Product table uses DECIMAL(24,8) but order tables use DECIMAL(10,2)
 * Solution: Standardize to DECIMAL(10,2) for consistency
 */

require_once '../app/config/database.php';

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Connected to database successfully.\n";
    
    // Start transaction
    $pdo->beginTransaction();
    
    echo "Starting decimal precision migration...\n";
    
    // Update product table to use DECIMAL(10,2) instead of DECIMAL(24,8)
    $alterQueries = [
        "ALTER TABLE h8pd_product MODIFY COLUMN price DECIMAL(10,2) DEFAULT NULL",
        "ALTER TABLE h8pd_product MODIFY COLUMN price_ttc DECIMAL(10,2) DEFAULT NULL",
        "ALTER TABLE h8pd_product MODIFY COLUMN price_min DECIMAL(10,2) DEFAULT NULL",
        "ALTER TABLE h8pd_product MODIFY COLUMN price_min_ttc DECIMAL(10,2) DEFAULT NULL"
    ];
    
    foreach ($alterQueries as $query) {
        echo "Executing: $query\n";
        $pdo->exec($query);
        echo "✓ Success\n";
    }
    
    // Commit transaction
    $pdo->commit();
    echo "\n✅ Migration completed successfully!\n";
    echo "All decimal precision issues have been resolved.\n";
    
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    exit(1);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "❌ Unexpected error: " . $e->getMessage() . "\n";
    exit(1);
}
?>