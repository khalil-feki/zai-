<?php
class DolibarrDatabase {
    private $pdo;
    private $prefix;
    private $availableTables = [];
    
    public function __construct() {
        $this->prefix = DB_PREFIX;
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            
            // Cache available tables
            $this->availableTables = $this->getAllTables();
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get a list of all tables in the Dolibarr database
     */
    public function getAllTables() {
        $stmt = $this->pdo->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Check if a table exists in the database
     */
    public function tableExists($tableName) {
        return in_array($tableName, $this->availableTables);
    }
    
    /**
     * Get products from Dolibarr database
     */
    public function getProducts($limit = 10, $offset = 0) {
        $table = $this->prefix . 'product';
        
        if (!$this->tableExists($table)) {
            throw new Exception("Product table not found in database");
        }
        
        // Check if tosell column exists
        $columns = $this->getTableColumns($table);
        $hasTosell = in_array('tosell', $columns);
        
        if ($hasTosell) {
            $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE tosell = 1 LIMIT :offset, :limit");
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM $table LIMIT :offset, :limit");
        }
        
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get product by ID
     */
    public function getProductById($id) {
        $table = $this->prefix . 'product';
        
        if (!$this->tableExists($table)) {
            throw new Exception("Product table not found in database");
        }
        
        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE rowid = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Get product categories
     */
    public function getCategories() {
        $table = $this->prefix . 'categorie';
        
        if (!$this->tableExists($table)) {
            throw new Exception("Category table not found in database");
        }
        
        // Check if type column exists
        $columns = $this->getTableColumns($table);
        $hasType = in_array('type', $columns);
        
        if ($hasType) {
            $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE type = 0"); // 0 = product categories
        } else {
            $stmt = $this->pdo->prepare("SELECT * FROM $table");
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get products in a specific category
     */
    public function getProductsByCategory($categoryId) {
        $productTable = $this->prefix . 'product';
        
        // Check for category-product relationship table
        $categoryProductTable = $this->prefix . 'categorie_product';
        $altCategoryProductTable = $this->prefix . 'categories_products'; // Alternative name
        
        if ($this->tableExists($categoryProductTable)) {
            $relationTable = $categoryProductTable;
            $productField = 'fk_product';
            $categoryField = 'fk_categorie';
        } elseif ($this->tableExists($altCategoryProductTable)) {
            $relationTable = $altCategoryProductTable;
            $productField = 'product_id';
            $categoryField = 'category_id';
        } else {
            // If no relationship table exists, return all products
            return $this->getProducts(100, 0);
        }
        
        $sql = "SELECT p.* FROM $productTable p 
                INNER JOIN $relationTable cp ON p.rowid = cp.$productField 
                WHERE cp.$categoryField = :categoryId";
                
        // Add tosell filter if column exists
        $columns = $this->getTableColumns($productTable);
        if (in_array('tosell', $columns)) {
            $sql .= " AND p.tosell = 1";
        }
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Get product prices
     */
    public function getProductPrices($productId) {
        // Try different price tables
        $priceTables = [
            $this->prefix . 'product_price',
            $this->prefix . 'product_pricelist',
            $this->prefix . 'product_prices'
        ];
        
        foreach ($priceTables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE fk_product = :productId ORDER BY date_price DESC LIMIT 1");
                    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    if ($result) {
                        return $result;
                    }
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        // If no price table found or no price data, get price from product table
        $productTable = $this->prefix . 'product';
        if ($this->tableExists($productTable)) {
            $stmt = $this->pdo->prepare("SELECT rowid, price, price_ttc FROM $productTable WHERE rowid = :productId");
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        }
        
        return null;
    }
    
    /**
     * Get product stock
     */
    public function getProductStock($productId) {
        // Try different stock tables
        $stockTables = [
            $this->prefix . 'product_stock',
            $this->prefix . 'stock',
            $this->prefix . 'product_warehouse_properties'
        ];
        
        foreach ($stockTables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $stmt = $this->pdo->prepare("SELECT SUM(reel) as total_stock FROM $table WHERE fk_product = :productId");
                    $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    if ($result && $result['total_stock'] !== null) {
                        return $result['total_stock'];
                    }
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        // If no stock table found, check if stock field exists in product table
        $productTable = $this->prefix . 'product';
        $columns = $this->getTableColumns($productTable);
        
        if (in_array('stock', $columns)) {
            $stmt = $this->pdo->prepare("SELECT stock FROM $productTable WHERE rowid = :productId");
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result ? $result['stock'] : 0;
        }
        
        return 0; // Default to 0 if no stock information found
    }
    
    /**
     * Get table columns
     */
    private function getTableColumns($tableName) {
        $stmt = $this->pdo->prepare("SHOW COLUMNS FROM $tableName");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }
    
    /**
     * Get customers
     */
    public function getCustomers() {
        $tables = [
            $this->prefix . 'societe',
            $this->prefix . 'customer',
            $this->prefix . 'clients'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $columns = $this->getTableColumns($table);
                    
                    if (in_array('client', $columns)) {
                        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE client = 1 OR client = 3");
                    } else {
                        $stmt = $this->pdo->prepare("SELECT * FROM $table");
                    }
                    
                    $stmt->execute();
                    return $stmt->fetchAll();
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        return []; // Return empty array if no customer table found
    }
    
    /**
     * Get orders
     */
    public function getOrders($customerId = null) {
        $tables = [
            $this->prefix . 'commande',
            $this->prefix . 'orders',
            $this->prefix . 'order'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $columns = $this->getTableColumns($table);
                    $customerField = in_array('fk_soc', $columns) ? 'fk_soc' : 
                                    (in_array('customer_id', $columns) ? 'customer_id' : null);
                    $dateField = in_array('date_commande', $columns) ? 'date_commande' : 
                                (in_array('date_order', $columns) ? 'date_order' : 'date_creation');
                    
                    if ($customerId && $customerField) {
                        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE $customerField = :customerId ORDER BY $dateField DESC");
                        $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
                    } else {
                        $stmt = $this->pdo->prepare("SELECT * FROM $table ORDER BY $dateField DESC");
                    }
                    
                    $stmt->execute();
                    return $stmt->fetchAll();
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        return []; // Return empty array if no order table found
    }
    
    /**
     * Get order details
     */
    public function getOrderDetails($orderId) {
        $tables = [
            $this->prefix . 'commandedet',
            $this->prefix . 'order_detail',
            $this->prefix . 'orderline'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $columns = $this->getTableColumns($table);
                    $orderField = in_array('fk_commande', $columns) ? 'fk_commande' : 
                                (in_array('order_id', $columns) ? 'order_id' : null);
                    
                    if ($orderField) {
                        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE $orderField = :orderId");
                        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                        $stmt->execute();
                        return $stmt->fetchAll();
                    }
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        return []; // Return empty array if no order detail table found
    }
    
    /**
     * Get contacts from Dolibarr database
     */
    public function getContacts($limit = 10, $offset = 0) {
        $tables = [
            $this->prefix . 'socpeople',
            $this->prefix . 'contact',
            $this->prefix . 'contacts'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $stmt = $this->pdo->prepare("SELECT * FROM $table LIMIT :offset, :limit");
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->execute();
                    return $stmt->fetchAll();
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        return []; // Return empty array if no contact table found
    }
    
    /**
     * Get contact by ID
     */
    public function getContactById($id) {
        $tables = [
            $this->prefix . 'socpeople',
            $this->prefix . 'contact',
            $this->prefix . 'contacts'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE rowid = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    if ($result) {
                        return $result;
                    }
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Get contacts for a specific company/customer
     */
    public function getContactsByCompany($companyId) {
        $tables = [
            $this->prefix . 'socpeople',
            $this->prefix . 'contact',
            $this->prefix . 'contacts'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $columns = $this->getTableColumns($table);
                    $companyField = in_array('fk_soc', $columns) ? 'fk_soc' : 
                                   (in_array('company_id', $columns) ? 'company_id' : null);
                    
                    if ($companyField) {
                        $stmt = $this->pdo->prepare("SELECT * FROM $table WHERE $companyField = :companyId");
                        $stmt->bindParam(':companyId', $companyId, PDO::PARAM_INT);
                        $stmt->execute();
                        return $stmt->fetchAll();
                    }
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        return []; // Return empty array if no contact table found
    }
    
    /**
     * Create a new contact
     */
    public function createContact($data) {
        $tables = [
            $this->prefix . 'socpeople',
            $this->prefix . 'contact',
            $this->prefix . 'contacts'
        ];
        
        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                try {
                    $columns = $this->getTableColumns($table);
                    
                    // Prepare field mappings based on available columns
                    $fields = [];
                    $values = [];
                    $params = [];
                    
                    // Map common contact fields
                    $fieldMappings = [
                        'firstname' => ['firstname', 'first_name'],
                        'lastname' => ['lastname', 'last_name', 'name'],
                        'email' => ['email', 'email_address'],
                        'phone' => ['phone', 'phone_pro', 'telephone'],
                        'company_id' => ['fk_soc', 'company_id', 'societe_id'],
                        'address' => ['address'],
                        'zip' => ['zip', 'zipcode', 'postal_code'],
                        'town' => ['town', 'city'],
                        'country' => ['country', 'country_id', 'fk_country'],
                        'note' => ['note', 'note_private', 'comments'],
                        'status' => ['statut', 'status']
                    ];
                    
                    foreach ($fieldMappings as $dataKey => $possibleColumns) {
                        if (isset($data[$dataKey])) {
                            foreach ($possibleColumns as $column) {
                                if (in_array($column, $columns)) {
                                    $fields[] = $column;
                                    $values[] = ':' . $column;
                                    $params[':' . $column] = $data[$dataKey];
                                    break;
                                }
                            }
                        }
                    }
                    
                    // Add entity and creation date if columns exist
                    if (in_array('entity', $columns)) {
                        $fields[] = 'entity';
                        $values[] = '1';
                    }
                    
                    if (in_array('datec', $columns)) {
                        $fields[] = 'datec';
                        $values[] = 'NOW()';
                    } else if (in_array('date_creation', $columns)) {
                        $fields[] = 'date_creation';
                        $values[] = 'NOW()';
                    }
                    
                    // Create SQL query
                    $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
                    $stmt = $this->pdo->prepare($sql);
                    
                    // Bind parameters
                    foreach ($params as $param => $value) {
                        $stmt->bindValue($param, $value);
                    }
                    
                    $stmt->execute();
                    return $this->pdo->lastInsertId();
                } catch (Exception $e) {
                    // Try next table
                    continue;
                }
            }
        }
        
        throw new Exception("No suitable contact table found in the database");
    }
}