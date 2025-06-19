<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Setting up Local Development Database ===\n\n";

try {
    // Connect to MySQL without selecting a database
    $pdo = new PDO(
        'mysql:host=localhost',
        'root',
        '',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    
    // Create database if it doesn't exist
    $dbName = 'c137d_app_dolibarr_20';
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbName' created or already exists\n";
    
    // Select the database
    $pdo->exec("USE `$dbName`");
    
    // Create required tables
    $tables = [
        'h8pd_commande' => "
            CREATE TABLE IF NOT EXISTS h8pd_commande (
                rowid INT AUTO_INCREMENT PRIMARY KEY,
                ref VARCHAR(30) NOT NULL,
                fk_soc INT,
                date_creation DATETIME,
                fk_user_author INT,
                fk_statut INT DEFAULT 0,
                total_ttc DOUBLE(24,8) DEFAULT 0,
                UNIQUE KEY uk_commande_ref (ref)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            
        'h8pd_commandedet' => "
            CREATE TABLE IF NOT EXISTS h8pd_commandedet (
                rowid INT AUTO_INCREMENT PRIMARY KEY,
                fk_commande INT NOT NULL,
                fk_product INT NOT NULL,
                price DOUBLE(24,8) DEFAULT 0,
                total_ttc DOUBLE(24,8) DEFAULT 0,
                FOREIGN KEY (fk_commande) REFERENCES h8pd_commande(rowid)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            
        'h8pd_ecm_files' => "
            CREATE TABLE IF NOT EXISTS h8pd_ecm_files (
                rowid INT AUTO_INCREMENT PRIMARY KEY,
                ref VARCHAR(128) NOT NULL,
                filename VARCHAR(255) NOT NULL,
                filepath VARCHAR(255) NOT NULL,
                date_c DATETIME,
                src_object_type VARCHAR(32),
                src_object_id INT,
                UNIQUE KEY uk_ecm_files_ref (ref)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    ];
    
    // Create each table
    foreach ($tables as $tableName => $sql) {
        $pdo->exec($sql);
        echo "Table '$tableName' created or already exists\n";
    }
    
    echo "\n=== Local Development Database Setup Complete ===\n";
    echo "You can now run the test_db_tables.php script to verify the setup\n";
    
} catch (PDOException $e) {
    echo "\nERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}