<?php

require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Checking Database Tables ===\n\n";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Tables to check
    $tables = [
        'h8pd_commande' => [
            'ref',
            'fk_soc',
            'date_creation',
            'fk_user_author',
            'fk_statut',
            'total_ttc'
        ],
        'h8pd_commandedet' => [
            'fk_commande',
            'fk_product',
            'price',
            'total_ttc'
        ],
        'h8pd_ecm_files' => [
            'ref',
            'filename',
            'filepath',
            'date_c',
            'src_object_type',
            'src_object_id'
        ]
    ];

    foreach ($tables as $table => $columns) {
        echo "Checking table: $table\n";
        
        // Check if table exists
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() === 0) {
            echo "ERROR: Table $table does not exist!\n";
            continue;
        }
        
        // Get table columns
        $stmt = $db->query("DESCRIBE $table");
        $tableColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "Found columns: " . implode(", ", $tableColumns) . "\n";
        
        // Check required columns
        $missingColumns = array_diff($columns, $tableColumns);
        if (!empty($missingColumns)) {
            echo "ERROR: Missing required columns in $table: " . implode(", ", $missingColumns) . "\n";
        } else {
            echo "All required columns present in $table\n";
        }
        
        // Get sample row
        $stmt = $db->query("SELECT * FROM $table LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            echo "Sample row structure:\n";
            print_r($row);
        } else {
            echo "Table is empty\n";
        }
        echo "\n";
    }

    echo "=== Database Check Complete ===\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}