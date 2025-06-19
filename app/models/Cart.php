<?php
require_once 'app/config/database.php';
require_once 'BaseModel.php';

class Cart extends BaseModel {
    protected $table = 'h8pd_cart';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Add product to cart
     */
    public function addToCart($userId, $productId, $quantity = 1) {
        try {
            // Check if product already exists in cart
            $query = "SELECT rowid, quantity FROM {$this->table} WHERE fk_user = :user_id AND fk_product = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // Update existing item with new quantity
                $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $updateQuery = "UPDATE {$this->table} SET quantity = :quantity WHERE rowid = :rowid";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $updateStmt->bindParam(':rowid', $existingItem['rowid'], PDO::PARAM_INT);
                return $updateStmt->execute();
            } else {
                // Add new item
                $insertQuery = "INSERT INTO {$this->table} (fk_user, fk_product, quantity, datec) VALUES (:user_id, :product_id, :quantity, NOW())";
                $insertStmt = $this->conn->prepare($insertQuery);
                $insertStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $insertStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                return $insertStmt->execute();
            }
        } catch (Exception $e) {
            error_log("Error adding to cart: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get cart items for user
     */
    public function getCartItems($userId) {
        try {
            $query = "SELECT 
                        c.quantity,
                        c.datec as date_creation,
                        p.rowid as product_id,
                        p.label,
                        p.price,
                        p.ref,
                        p.image_name,
                        (c.quantity * p.price) as total_price,
                        p.description
                      FROM {$this->table} c 
                      INNER JOIN h8pd_product p ON c.fk_product = p.rowid 
                      WHERE c.fk_user = :user_id
                      ORDER BY c.datec DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting cart items: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function updateQuantity($userId, $productId, $quantity) {
        try {
            if ($quantity <= 0) {
                return $this->removeFromCart($userId, $productId);
            }
            
            $query = "UPDATE {$this->table} SET quantity = :quantity WHERE fk_user = :user_id AND fk_product = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating cart quantity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Remove item from cart
     */
    public function removeFromCart($userId, $productId) {
        try {
            $query = "DELETE FROM {$this->table} WHERE fk_user = :user_id AND fk_product = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error removing from cart: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Clear entire cart for user
     */
    public function clearCart($userId) {
        try {
            $query = "DELETE FROM {$this->table} WHERE fk_user = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error clearing cart: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get cart total
     */
    public function getCartTotal($userId) {
        try {
            $query = "SELECT SUM(c.quantity * p.price) as total 
                      FROM {$this->table} c 
                      INNER JOIN h8pd_product p ON c.fk_product = p.rowid 
                      WHERE c.fk_user = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            error_log("Error getting cart total: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get cart count
     */
    public function getCartCount($userId) {
        try {
            $query = "SELECT SUM(quantity) as count FROM {$this->table} WHERE fk_user = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error getting cart count: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get a specific cart item for a user and product
     * @param int $userId
     * @param int $productId
     * @return array|null
     */
    public function getCartItem($userId, $productId) {
        $sql = "SELECT c.*, c.datec as date_creation, p.label, p.ref, p.price, 
                       (c.quantity * p.price) as total_price
                FROM h8pd_cart c 
                JOIN h8pd_product p ON c.fk_product = p.rowid 
                WHERE c.fk_user = :user_id AND c.fk_product = :product_id";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            error_log("Error getting cart item: " . $e->getMessage());
            return null;
        }
    }
}
?>