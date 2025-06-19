<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    echo "✅ Database connected\n\n";
    
    // Check h8pd_commande table structure
    echo "📋 h8pd_commande table structure:\n";
    $result = $conn->query("DESCRIBE h8pd_commande");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "   {$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']}\n";
    }
    
    echo "\n📋 h8pd_commandedet table structure:\n";
    $result = $conn->query("DESCRIBE h8pd_commandedet");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "   {$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']}\n";
    }
    
    // Check if tables exist
    echo "\n🔍 Checking table existence:\n";
    $tables = ['h8pd_commande', 'h8pd_commandedet', 'h8pd_product', 'h8pd_societe'];
    
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        $exists = $result->rowCount() > 0;
        echo "   $table: " . ($exists ? "✅ EXISTS" : "❌ NOT FOUND") . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>