<?php
/**
 * Order Management Script
 * Demonstrates all table relationships for h8pd_commande
 */

require_once 'app/config/database.php';

class OrderManagementScript {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    /**
     * Get complete order information with all related data
     */
    public function getCompleteOrderInfo($orderId) {
        $orderData = [];
        
        // 1. Main order information
        $orderQuery = "SELECT 
            c.*,
            s.nom as customer_name,
            s.email as customer_email,
            u_author.login as author_name,
            u_valid.login as validator_name,
            p.title as project_title
        FROM h8pd_commande c
        LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid
        LEFT JOIN h8pd_societe u_author ON c.fk_user_author = u_author.rowid
        LEFT JOIN h8pd_societe u_valid ON c.fk_user_valid = u_valid.rowid
        LEFT JOIN h8pd_projet p ON c.fk_projet = p.rowid
        WHERE c.rowid = :order_id";
        
        $stmt = $this->conn->prepare($orderQuery);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderData['order'] = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 2. Order line items
        $detailsQuery = "SELECT 
            cd.*,
            pr.label as product_name,
            pr.price as product_price
        FROM h8pd_commandedet cd
        LEFT JOIN h8pd_product pr ON cd.fk_product = pr.rowid
        WHERE cd.fk_commande = :order_id
        ORDER BY cd.rang";
        
        $stmt = $this->conn->prepare($detailsQuery);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderData['details'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 3. Order extrafields
        $extraQuery = "SELECT * FROM h8pd_commande_extrafields WHERE fk_object = :order_id";
        $stmt = $this->conn->prepare($extraQuery);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderData['extrafields'] = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 4. Related files
        $filesQuery = "SELECT * FROM h8pd_ecm_files 
                      WHERE src_object_type = 'commande' AND src_object_id = :order_id";
        $stmt = $this->conn->prepare($filesQuery);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderData['files'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $orderData;
    }
    
    /**
     * Create a complete order with all related entries
     */
    public function createCompleteOrder($orderData, $orderItems) {
        try {
            $this->conn->beginTransaction();
            
            // 1. Create main order
            $orderQuery = "INSERT INTO h8pd_commande (
                ref, entity, fk_soc, date_creation, date_valid, date_commande,
                fk_user_author, fk_statut, total_ht, total_tva, total_ttc,
                multicurrency_code, multicurrency_tx, multicurrency_total_ht,
                multicurrency_total_tva, multicurrency_total_ttc
            ) VALUES (
                :ref, 1, :fk_soc, NOW(), NOW(), CURDATE(),
                :fk_user_author, 1, :total_ht, :total_tva, :total_ttc,
                'TND', 1.0, :total_ht, :total_tva, :total_ttc
            )";
            
            $stmt = $this->conn->prepare($orderQuery);
            $stmt->execute($orderData);
            $orderId = $this->conn->lastInsertId();
            
            // 2. Create order details
            foreach ($orderItems as $item) {
                $detailQuery = "INSERT INTO h8pd_commandedet (
                    fk_commande, fk_product, description, tva_tx, qty,
                    price, subprice, total_ht, total_tva, total_ttc,
                    multicurrency_code, multicurrency_subprice,
                    multicurrency_total_ht, multicurrency_total_tva, multicurrency_total_ttc
                ) VALUES (
                    :fk_commande, :fk_product, :description, :tva_tx, :qty,
                    :price, :subprice, :total_ht, :total_tva, :total_ttc,
                    'TND', :subprice, :total_ht, :total_tva, :total_ttc
                )";
                
                $item['fk_commande'] = $orderId;
                $stmt = $this->conn->prepare($detailQuery);
                $stmt->execute($item);
            }
            
            // 3. Create file entry
            $ref = $orderData['ref'];
            $pdfFilename = $ref . '.pdf';
            $filepath = 'commande/' . $ref;
            $fileLabel = md5($pdfFilename . time());
            $fileRef = md5($filepath . time());
            
            $fileQuery = "INSERT INTO h8pd_ecm_files (
                ref, label, entity, filename, filepath, fullpath_orig,
                gen_or_uploaded, date_c, tms, fk_user_c, position,
                src_object_type, src_object_id
            ) VALUES (
                :file_ref, :file_label, 1, :filename, :filepath, '',
                'generated', NOW(), NOW(), 0, 1,
                'commande', :order_id
            )";
            
            $stmt = $this->conn->prepare($fileQuery);
            $stmt->bindParam(':file_ref', $fileRef);
            $stmt->bindParam(':file_label', $fileLabel);
            $stmt->bindParam(':filename', $pdfFilename);
            $stmt->bindParam(':filepath', $filepath);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            $this->conn->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception("Order creation failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get all related tables information
     */
    public function getTableRelationships() {
        return [
            'core_tables' => [
                'h8pd_commande' => 'Main orders table',
                'h8pd_commandedet' => 'Order line items',
                'h8pd_commande_extrafields' => 'Order custom fields',
                'h8pd_commandedet_extrafields' => 'Order details custom fields'
            ],
            'supplier_tables' => [
                'h8pd_commande_fournisseur' => 'Supplier orders',
                'h8pd_commande_fournisseurdet' => 'Supplier order details',
                'h8pd_commande_fournisseur_extrafields' => 'Supplier order custom fields',
                'h8pd_commande_fournisseurdet_extrafields' => 'Supplier order details custom fields',
                'h8pd_commande_fournisseur_log' => 'Supplier order logs'
            ],
            'file_management' => [
                'h8pd_ecm_files' => 'Order documents and PDFs'
            ],
            'referenced_tables' => [
                'h8pd_societe' => 'Customers/Companies',
                'h8pd_societe' => 'Companies (authors, validators)',
                'h8pd_projet' => 'Projects',
                'h8pd_product' => 'Products'
            ]
        ];
    }
    
    /**
     * Validate order data integrity
     */
    public function validateOrderIntegrity($orderId) {
        $issues = [];
        
        // Check if order exists
        $orderCheck = "SELECT COUNT(*) as count FROM h8pd_commande WHERE rowid = :order_id";
        $stmt = $this->conn->prepare($orderCheck);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()['count'] == 0) {
            $issues[] = "Order {$orderId} does not exist";
            return $issues;
        }
        
        // Check order details
        $detailsCheck = "SELECT COUNT(*) as count FROM h8pd_commandedet WHERE fk_commande = :order_id";
        $stmt = $this->conn->prepare($detailsCheck);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()['count'] == 0) {
            $issues[] = "Order {$orderId} has no line items";
        }
        
        // Check file entries
        $fileCheck = "SELECT COUNT(*) as count FROM h8pd_ecm_files 
                     WHERE src_object_type = 'commande' AND src_object_id = :order_id";
        $stmt = $this->conn->prepare($fileCheck);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()['count'] == 0) {
            $issues[] = "Order {$orderId} has no associated files";
        }
        
        // Check foreign key relationships
        $fkCheck = "SELECT 
            c.rowid,
            CASE WHEN s.rowid IS NULL THEN 'Missing customer' ELSE NULL END as customer_issue,
            CASE WHEN u.rowid IS NULL THEN 'Missing author' ELSE NULL END as author_issue
        FROM h8pd_commande c
        LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid
        LEFT JOIN h8pd_societe u ON c.fk_user_author = u.rowid
        WHERE c.rowid = :order_id";
        
        $stmt = $this->conn->prepare($fkCheck);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $fkResult = $stmt->fetch();
        
        if ($fkResult['customer_issue']) $issues[] = $fkResult['customer_issue'];
        if ($fkResult['author_issue']) $issues[] = $fkResult['author_issue'];
        
        return $issues;
    }
    
    /**
     * Generate order statistics
     */
    public function getOrderStatistics() {
        $stats = [];
        
        // Total orders
        $totalQuery = "SELECT COUNT(*) as total FROM h8pd_commande";
        $stmt = $this->conn->prepare($totalQuery);
        $stmt->execute();
        $stats['total_orders'] = $stmt->fetch()['total'];
        
        // Orders by status
        $statusQuery = "SELECT fk_statut, COUNT(*) as count FROM h8pd_commande GROUP BY fk_statut";
        $stmt = $this->conn->prepare($statusQuery);
        $stmt->execute();
        $stats['by_status'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Total revenue
        $revenueQuery = "SELECT SUM(total_ttc) as total_revenue FROM h8pd_commande";
        $stmt = $this->conn->prepare($revenueQuery);
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetch()['total_revenue'];
        
        // Orders with files
        $filesQuery = "SELECT COUNT(DISTINCT src_object_id) as orders_with_files 
                      FROM h8pd_ecm_files WHERE src_object_type = 'commande'";
        $stmt = $this->conn->prepare($filesQuery);
        $stmt->execute();
        $stats['orders_with_files'] = $stmt->fetch()['orders_with_files'];
        
        return $stats;
    }
}

// Usage example
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    try {
        $orderScript = new OrderManagementScript();
        
        echo "=== Order Management Script ===\n\n";
        
        // Show table relationships
        echo "Table Relationships:\n";
        $relationships = $orderScript->getTableRelationships();
        foreach ($relationships as $category => $tables) {
            echo "\n" . strtoupper(str_replace('_', ' ', $category)) . ":\n";
            foreach ($tables as $table => $description) {
                echo "  - {$table}: {$description}\n";
            }
        }
        
        // Show statistics
        echo "\n\nOrder Statistics:\n";
        $stats = $orderScript->getOrderStatistics();
        foreach ($stats as $key => $value) {
            if (is_array($value)) {
                echo "  {$key}:\n";
                foreach ($value as $item) {
                    echo "    - Status {$item['fk_statut']}: {$item['count']} orders\n";
                }
            } else {
                echo "  {$key}: {$value}\n";
            }
        }
        
        // Example: Get complete order info for order ID 1
        if (isset($_GET['order_id'])) {
            $orderId = (int)$_GET['order_id'];
            echo "\n\nComplete Order Information for Order #{$orderId}:\n";
            $orderInfo = $orderScript->getCompleteOrderInfo($orderId);
            print_r($orderInfo);
            
            // Validate order integrity
            echo "\nOrder Integrity Check:\n";
            $issues = $orderScript->validateOrderIntegrity($orderId);
            if (empty($issues)) {
                echo "  ✓ Order integrity is valid\n";
            } else {
                echo "  ✗ Issues found:\n";
                foreach ($issues as $issue) {
                    echo "    - {$issue}\n";
                }
            }
        }
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
?>