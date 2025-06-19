<?php
require_once 'app/config/database.php';
require_once 'BaseModel.php';

class Order extends BaseModel {
    protected $table = 'h8pd_commande';
    private $lockFile;
    
    public function __construct() {
        parent::__construct();
        $this->lockFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'order_lock';
        $this->ensureCommandeDirectoryExists();
    }

    private function ensureCommandeDirectoryExists() {
        $commandeDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'commande';
        if (!file_exists($commandeDir)) {
            if (!@mkdir($commandeDir, 0755, true)) {
                error_log("Failed to create commande directory: $commandeDir");
                throw new Exception("Failed to create required directory");
            }
            error_log("Created commande directory: $commandeDir");
        }
        
        if (!is_writable($commandeDir)) {
            error_log("Commande directory is not writable: $commandeDir");
            throw new Exception("Order directory is not writable");
        }
    }

    public function getUserOrders($userId) {
        try {
            $query = "SELECT c.rowid as id, c.date_creation as date_created, c.*, s.nom as customer_name 
                      FROM {$this->table} c 
                      LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid 
                      WHERE c.fk_user_author = :user_id 
                      ORDER BY c.date_creation DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting user orders: " . $e->getMessage());
            return [];
        }
    }

    public function getOrdersByEmail($email) {
        try {
            $query = "SELECT c.rowid as id, c.date_creation as date_created, c.*, s.nom as customer_name, s.email as customer_email 
                      FROM {$this->table} c 
                      LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid 
                      WHERE c.ref_client = :email
                      ORDER BY c.date_creation DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Found " . count($orders) . " orders for email: {$email}");
            return $orders;
        } catch (Exception $e) {
            error_log("Error getting orders by email: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderDetails($orderId, $userId) {
        try {
            $query = "SELECT c.rowid as id, c.date_creation as date_created, c.*, s.nom as customer_name, s.email as customer_email 
                      FROM {$this->table} c 
                      LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid 
                      WHERE c.rowid = :id AND c.fk_user_author = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            error_log("Error getting order details: " . $e->getMessage());
            return new PDOStatement();
        }
    }

    public function getOrderItems($orderId) {
        try {
            $query = "SELECT od.*, p.label as product_name, p.ref as product_ref 
                      FROM h8pd_commandedet od 
                      INNER JOIN h8pd_product p ON od.fk_product = p.rowid 
                      WHERE od.fk_commande = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting order items: " . $e->getMessage());
            return [];
        }
    }

    private function acquireLock() {
        $maxAttempts = 10;
        $attempt = 0;
        
        while ($attempt < $maxAttempts) {
            if (!file_exists($this->lockFile)) {
                if (@file_put_contents($this->lockFile, getmypid())) {
                    return true;
                }
            }
            usleep(100000); // 100ms
            $attempt++;
        }
        return false;
    }

    private function releaseLock() {
        if (file_exists($this->lockFile)) {
            @unlink($this->lockFile);
        }
    }

    public function createOrder($orderData, $items) {
        // Extract data from orderData array
        $userId = $orderData['user_id'];
        $dolibarrOrderId = $orderData['dolibarr_order_id'] ?? null;
        $notePrivate = $orderData['notes'] ?? null;
        $notePublic = $orderData['notes'] ?? null;
        
        if (empty($items)) {
            error_log("Cannot create order: No items provided");
            return false;
        }

        try {
            $this->conn->beginTransaction();

            // Get user data including email and name for proper order reference
            $userQuery = "SELECT rowid, email, nom FROM h8pd_societe WHERE rowid = :user_id";
            $userStmt = $this->conn->prepare($userQuery);
            $userStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $userStmt->execute();
            $userResult = $userStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$userResult) {
                throw new Exception("User not found with ID: $userId");
            }
            
            $userEmail = $userResult['email'] ?? 'unknown';
            $userName = $userResult['nom'] ?? 'Unknown User';
            
            error_log("Creating order for user: $userId, email: $userEmail, name: $userName");

            // Generate a more robust unique reference
            $microtime = microtime(true);
            $timestamp = date('YmdHis', floor($microtime));
            $microseconds = sprintf('%06d', ($microtime - floor($microtime)) * 1000000);
            $randomSuffix = mt_rand(10000, 99999);
            $ref = 'WEB-' . $timestamp . '-' . $microseconds . '-' . $randomSuffix;
            
            // Add a check to ensure uniqueness with better error handling
            $checkQuery = "SELECT COUNT(*) FROM {$this->table} WHERE ref = :ref";
            $checkStmt = $this->conn->prepare($checkQuery);
            $maxAttempts = 10;
            $attempts = 0;
            
            do {
                $checkStmt->bindParam(':ref', $ref, PDO::PARAM_STR);
                $checkStmt->execute();
                if ($checkStmt->fetchColumn() == 0) {
                    break; // Reference is unique
                }
                $attempts++;
                $ref = 'WEB-' . $timestamp . '-' . $microseconds . '-' . mt_rand(10000, 99999) . '-' . $attempts;
            } while ($attempts < $maxAttempts);
            
            if ($attempts >= $maxAttempts) {
                throw new Exception("Unable to generate unique order reference after $maxAttempts attempts");
            }
            
            // Calculate totals (assuming no tax for simplicity, can be enhanced)
            $total_ht = 0;
            $total_ttc = 0;
            foreach ($items as $item) {
                if (!isset($item['price']) || !isset($item['product_id']) || !isset($item['quantity'])) {
                    throw new Exception("Invalid item data: missing price, product_id, or quantity");
                }
                // Calculate item total if not provided
                if (isset($item['total_price'])) {
                    $item_total = round($item['total_price'], 2);
                } else {
                    $item_total = round($item['price'] * $item['quantity'], 2);
                }
                $total_ht += $item_total;
                $total_ttc += $item_total; // Assuming no tax for now
            }
            
            // Round totals to 2 decimal places
            $total_ht = round($total_ht, 2);
            $total_ttc = round($total_ttc, 2);

            // Use provided notes or create default ones
            if ($notePrivate === null) {
                $notePrivate = 'Order created from web application';
                if ($dolibarrOrderId) {
                    $notePrivate .= ' - Dolibarr Order ID: ' . $dolibarrOrderId;
                }
            }
            
            if ($notePublic === null) {
                $notePublic = 'Web order';
                if ($dolibarrOrderId) {
                    $notePublic .= ' - Ref: DOL-' . $dolibarrOrderId;
                }
            }

            // Since users are stored in h8pd_societe table, the user ID is the societe ID
            $societeId = $userId;
            
            // Insert order header with both total_ht and total_ttc
            $query = "INSERT INTO {$this->table} 
                      (ref, ref_client, entity, fk_soc, fk_user_author, date_commande, date_creation, fk_statut, total_ht, total_ttc, note_private) 
                      VALUES 
                      (:ref, :ref_client, 1, :fk_soc, :fk_user_author, NOW(), NOW(), 1, :total_ht, :total_ttc, :note_private)";

            $stmt = $this->conn->prepare($query);
            
            // Bind parameters individually for better error handling
            $stmt->bindParam(':ref', $ref, PDO::PARAM_STR);
            $stmt->bindParam(':ref_client', $userEmail, PDO::PARAM_STR);
            $stmt->bindParam(':fk_soc', $societeId, PDO::PARAM_INT);
            $stmt->bindParam(':fk_user_author', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':total_ht', $total_ht, PDO::PARAM_STR);
            $stmt->bindParam(':total_ttc', $total_ttc, PDO::PARAM_STR);
            $stmt->bindParam(':note_private', $notePrivate, PDO::PARAM_STR);
            
            error_log("Order creation query: " . $query);
            error_log("Order creation params: ref=$ref, ref_client=$userEmail, fk_soc=$societeId, fk_user_author=$userId, total_ht=$total_ht, total_ttc=$total_ttc");

            $stmt->execute();
            $orderId = $this->conn->lastInsertId();

            // Insert order items with proper decimal precision
            foreach ($items as $position => $item) {
                $detailQuery = "INSERT INTO h8pd_commandedet 
                               (fk_commande, fk_product, price, qty, total_ht) 
                               VALUES 
                               (:order_id, :product_id, :price, :quantity, :total)";

                $detailStmt = $this->conn->prepare($detailQuery);
                
                // Calculate total if not provided
                $itemTotal = isset($item['total_price']) ? $item['total_price'] : ($item['price'] * $item['quantity']);
                $roundedPrice = round($item['price'], 2);
                $roundedTotal = round($itemTotal, 2);
                
                // Bind parameters individually
                $detailStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $detailStmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
                $detailStmt->bindParam(':price', $roundedPrice, PDO::PARAM_STR);
                $detailStmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $detailStmt->bindParam(':total', $roundedTotal, PDO::PARAM_STR);

                $detailStmt->execute();
                
                error_log("Inserted order item: product_id={$item['product_id']}, price=$roundedPrice, qty={$item['quantity']}, total=$roundedTotal");
            }

            // Clear cart after successful order creation
            $clearCartQuery = "DELETE FROM h8pd_cart WHERE fk_user = :user_id";
            $clearStmt = $this->conn->prepare($clearCartQuery);
            $clearStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $clearStmt->execute();
            
            error_log("Cleared cart for user: $userId");
            
            $this->conn->commit();
            error_log("Order created successfully with ID: $orderId, Reference: $ref");
            return $orderId;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("PDO Error creating order: " . $e->getMessage());
            error_log("Error Code: " . $e->getCode());
            error_log("SQL State: " . $e->errorInfo[0] ?? 'Unknown');
            return false;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("General Error creating order: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function getNextOrderNumber() {
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        return sprintf('ORD%d%04d', $timestamp, $random);
    }

    public function getOrderById($orderId) {
        try {
            $query = "SELECT c.*, s.nom as customer_name, s.email as customer_email 
                      FROM {$this->table} c 
                      LEFT JOIN h8pd_societe s ON c.fk_soc = s.rowid 
                      WHERE c.rowid = :order_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting order by ID: " . $e->getMessage());
            return false;
        }
    }
}
?>