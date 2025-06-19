<?php
// Include database connection
require_once '../app/config/database.php';

// Create database connection
$database = new Database();
$conn = $database->getConnection();

try {
    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Create products table with the correct structure
    $conn->exec("CREATE TABLE IF NOT EXISTS h8pd_product (
        rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        ref VARCHAR(50) NOT NULL,
        ref_ext VARCHAR(50),
        entity INT(11),
        datec DATETIME,
        tms TIMESTAMP,
        virtual TINYINT(1),
        fk_parent INT(11),
        label VARCHAR(255) NOT NULL,
        description TEXT,
        note TEXT,
        customcode VARCHAR(32),
        fk_country INT(11),
        fk_state INT(11),
        price DECIMAL(24,8),
        price_ttc DECIMAL(24,8),
        price_min DECIMAL(24,8),
        price_min_ttc DECIMAL(24,8),
        price_base_type VARCHAR(10),
        price_label VARCHAR(255),
        tva_tx DECIMAL(6,3),
        recuperableonly INT(11),
        localtax1_tx DECIMAL(6,3),
        localtax1_type VARCHAR(10),
        localtax2_tx DECIMAL(6,3),
        localtax2_type VARCHAR(10),
        fk_user_author INT(11),
        fk_user_modif INT(11),
        tosell TINYINT(1),
        tobuy TINYINT(1),
        tobatch TINYINT(1),
        sell_or_eat_by_mandatory TINYINT(1),
        fk_product_type INT(11),
        duration VARCHAR(10),
        seuil_stock_alerte INT(11),
        url VARCHAR(255),
        barcode VARCHAR(180),
        fk_barcode_type INT(11),
        accountancy_code_sell VARCHAR(32),
        accountancy_code_sell_intra VARCHAR(32),
        accountancy_code_sell_export VARCHAR(32),
        accountancy_code_buy VARCHAR(32),
        accountancy_code_buy_intra VARCHAR(32),
        accountancy_code_buy_export VARCHAR(32),
        partnumber VARCHAR(32),
        weight DECIMAL(10,5),
        weight_units TINYINT(1),
        length DECIMAL(10,5),
        length_units TINYINT(1),
        surface DECIMAL(10,5),
        surface_units TINYINT(1),
        volume DECIMAL(10,5),
        volume_units TINYINT(1),
        stock INT(11),
        pmp DECIMAL(24,8),
        fifo DECIMAL(24,8),
        lifo DECIMAL(24,8),
        canvas VARCHAR(32),
        finished TINYINT(1),
        hidden TINYINT(1),
        import_key VARCHAR(14),
        desiredstock INT(11),
        fk_price_expression INT(11),
        fk_unit INT(11),
        cost_price DECIMAL(24,8),
        default_vat_code VARCHAR(10),
        price_autogen TINYINT(1),
        batch_mask VARCHAR(32),
        lifetime INT(11),
        qc_frequency INT(11),
        note_public TEXT,
        model_pdf VARCHAR(255),
        width DECIMAL(10,5),
        width_units TINYINT(1),
        height DECIMAL(10,5),
        height_units TINYINT(1),
        fk_default_warehouse INT(11),
        fk_project INT(11),
        net_measure DECIMAL(10,5),
        net_measure_units TINYINT(1),
        mandatory_period TINYINT(1),
        fk_default_bom INT(11),
        fk_default_workstation INT(11),
        stockable_product TINYINT(1),
        last_main_doc VARCHAR(255)
    ) ENGINE=InnoDB");
    echo "Products table created.<br>";
    
    // Create categories table
    $conn->exec("CREATE TABLE IF NOT EXISTS h8pd_categorie (
        rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        label VARCHAR(100) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    echo "Categories table created.<br>";
    
    // Create users table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS h8pd_user (
        rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(50) NOT NULL,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        pass_crypted VARCHAR(128) NOT NULL,
        admin TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY (login),
        UNIQUE KEY (email)
    ) ENGINE=InnoDB");
    echo "Users table created.<br>";
    
    // Create orders table
    $conn->exec("CREATE TABLE IF NOT EXISTS h8pd_commande (
        rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        ref VARCHAR(50) NOT NULL,
        fk_user INT(11) NOT NULL,
        date_commande DATETIME NOT NULL,
        total_ht DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        total_ttc DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        fk_statut TINYINT(1) DEFAULT 0,
        note_private TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY (ref)
    ) ENGINE=InnoDB");
    echo "Orders table created.<br>";
    
    // Create order details table
    $conn->exec("CREATE TABLE IF NOT EXISTS h8pd_commandedet (
        rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        fk_commande INT(11) NOT NULL,
        fk_product INT(11) NOT NULL,
        qty INT(11) NOT NULL DEFAULT 1,
        price DECIMAL(10,2) NOT NULL,
        total_ht DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    echo "Order details table created.<br>";
    
    // Create cart table
    $conn->exec("CREATE TABLE IF NOT EXISTS h8pd_cart (
        rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        fk_user INT(11) NOT NULL,
        fk_product INT(11) NOT NULL,
        quantity INT(11) NOT NULL DEFAULT 1,
        price DECIMAL(10,2) NOT NULL,
        datec DATETIME NOT NULL,
        UNIQUE KEY (fk_user, fk_product)
    ) ENGINE=InnoDB");
    echo "Cart table created.<br>";
    
    // Insert sample data
    // Add sample categories
    $conn->exec("INSERT INTO h8pd_categorie (label, description) VALUES 
            ('Electronics', 'Electronic devices and accessories'),
            ('Clothing', 'Apparel and fashion items'),
            ('Books', 'Books and publications'),
            ('Home & Kitchen', 'Home and kitchen products')");
    
    // Add sample products with the correct structure
    $conn->exec("INSERT INTO h8pd_product (ref, label, description, price, price_ttc, price_min, price_min_ttc, price_base_type, tva_tx, tosell, tobuy, fk_product_type, stock) VALUES 
            ('PRO001', 'Cahier 300p', 'Ce cahier est un outil indispensable pour organiser vos notes et idées.', 200.00000000, 245.00000000, 185.00000000, 226.62500000, 'HT', 22.500, 1, 1, 0, 50),
            ('PRO002', 'Laptop Pro', 'High-performance laptop for professionals', 1299.99, 1559.99, 1199.99, 1439.99, 'HT', 20.000, 1, 1, 0, 30),
            ('PRO003', 'T-shirt Basic', 'Comfortable cotton t-shirt', 19.99, 23.99, 17.99, 21.59, 'HT', 20.000, 1, 1, 0, 100),
            ('PRO004', 'Jeans Classic', 'Classic blue jeans', 49.99, 59.99, 45.99, 55.19, 'HT', 20.000, 1, 1, 0, 75),
            ('PRO005', 'Programming 101', 'Introduction to programming', 29.99, 35.99, 27.99, 33.59, 'HT', 20.000, 1, 1, 0, 60),
            ('PRO006', 'Coffee Maker', 'Automatic coffee maker', 89.99, 107.99, 79.99, 95.99, 'HT', 20.000, 1, 1, 0, 40)");
    
    echo "Sample data inserted.<br>";
    echo "<br>Database setup completed successfully!";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>