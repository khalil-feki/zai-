<?php
require_once 'app/config/database.php';
require_once 'BaseModel.php';

class Category extends BaseModel {
    protected $table = 'h8pd_categorie';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all categories
     * @return array Array of categories
     */
    public function getAll() {
        try {
            $query = "SELECT * FROM {$this->table} ORDER BY label ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Category::getAll: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get category by ID
     * @param int $id Category ID
     * @return array|false Category data or false if not found
     */
    public function getById($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE rowid = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Category::getById: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create category-product relationship table if it doesn't exist
     * @return bool True if successful, false otherwise
     */
    public function createRelationshipTable() {
        try {
            $query = "CREATE TABLE IF NOT EXISTS h8pd_categorie_product (
                rowid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                fk_categorie INT(11) NOT NULL,
                fk_product INT(11) NOT NULL,
                UNIQUE KEY (fk_categorie, fk_product),
                FOREIGN KEY (fk_categorie) REFERENCES {$this->table}(rowid) ON DELETE CASCADE,
                FOREIGN KEY (fk_product) REFERENCES h8pd_product(rowid) ON DELETE CASCADE
            )";
            
            $this->conn->exec($query);
            return true;
        } catch (Exception $e) {
            error_log("Error creating category-product relationship table: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Add product to category
     * @param int $categoryId Category ID
     * @param int $productId Product ID
     * @return bool True if successful, false otherwise
     */
    public function addProduct($categoryId, $productId) {
        try {
            // Check if relationship table exists, create if not
            $this->createRelationshipTable();
            
            $query = "INSERT IGNORE INTO h8pd_categorie_product (fk_categorie, fk_product) 
                      VALUES (:category_id, :product_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error adding product to category: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get products in a category
     * @param int $categoryId Category ID
     * @return array Array of products
     */
    public function getProducts($categoryId) {
        try {
            // Check if relationship table exists
            $checkQuery = "SHOW TABLES LIKE 'h8pd_categorie_product'";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                // Use relationship table
                $query = "SELECT p.* FROM h8pd_product p
                          INNER JOIN h8pd_categorie_product cp ON p.rowid = cp.fk_product
                          WHERE cp.fk_categorie = :category_id
                          ORDER BY p.label ASC";
            } else {
                // Fallback to direct category field if it exists
                $query = "SELECT p.* FROM h8pd_product p
                          WHERE p.fk_categorie = :category_id OR p.fk_product_type = :category_id
                          ORDER BY p.label ASC";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting products in category: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get all categories that have products
     * @return array Array of categories with products
     */
    public function getCategoriesWithProducts() {
        try {
            // Check if relationship table exists
            $checkQuery = "SHOW TABLES LIKE 'h8pd_categorie_product'";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                // Use relationship table
                $query = "SELECT DISTINCT c.* FROM {$this->table} c
                          INNER JOIN h8pd_categorie_product cp ON c.rowid = cp.fk_categorie
                          INNER JOIN h8pd_product p ON cp.fk_product = p.rowid
                          WHERE p.tosell = 1
                          ORDER BY c.label ASC";
            } else {
                // Fallback to direct category field
                $query = "SELECT DISTINCT c.* FROM {$this->table} c
                          INNER JOIN h8pd_product p ON (c.rowid = p.fk_categorie OR c.rowid = p.fk_product_type)
                          WHERE p.tosell = 1
                          ORDER BY c.label ASC";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in Category::getCategoriesWithProducts: " . $e->getMessage());
            return [];
        }
    }
}
?>