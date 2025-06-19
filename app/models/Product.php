<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'BaseModel.php';

class Product extends BaseModel {
    protected $table = 'h8pd_product';
    protected $tosell_filter = false;
    protected $defaultImagePath = 'public/uploads/products/default.jpg';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function setTosellFilter($value) {
        $this->tosell_filter = $value;
        return $this;
    }
    
    /**
     * Standardize image URL construction across all methods
     * @param array $product Product data containing image information
     * @return string Formatted image URL or default image path
     */
    private function formatImageUrl($product) {
        // Case 1: No image name provided - use default
        if (empty($product['image_name'])) {
            return $this->defaultImagePath;
        }
        
        // Case 2: Determine the correct path based on available data
        $imagePath = '';
        
        if (!empty($product['image_path'])) {
            // Check if filepath already includes 'public/uploads'
            if (strpos($product['image_path'], 'public/uploads') === 0) {
                $imagePath = $product['image_path'] . '/' . $product['image_name'];
            } else {
                $imagePath = 'public/uploads/' . $product['image_path'] . '/' . $product['image_name'];
            }
        } else {
            // Default product images folder
            $imagePath = 'public/uploads/products/' . $product['image_name'];
        }
        
        // Case 3: Verify the image exists, otherwise use default
        if (file_exists($imagePath)) {
            return $imagePath;
        } else {
            // Log missing image for debugging purposes
            error_log("Product image not found: {$imagePath}, using default");
            return $this->defaultImagePath;
        }
    }
    
    /**
     * Find all products with optional filtering
     */
    public function findAll($limit = 0, $offset = 0, $search = null) {
        try {
            // Debug log
            error_log("Product::findAll - Fetching products with limit: $limit, offset: $offset, search: " . ($search ?? 'null'));
            
            // Modified query to remove dependency on h8pd_ecm_files table
            $query = "SELECT p.* FROM " . $this->table . " p WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Add search filter if provided
            if ($search) {
                $query .= " AND (p.label LIKE :search OR p.description LIKE :search OR p.ref LIKE :search)";
            }
            
            $query .= " ORDER BY p.datec DESC";
            
            if ($limit > 0) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $this->conn->prepare($query);
            
            // Bind parameters
            if ($search) {
                $searchParam = '%' . $search . '%';
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }
            
            if ($limit > 0) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug log the SQL query and results
            error_log("Product::findAll - SQL Query: " . $query);
            error_log("Product::findAll - Found " . count($products) . " products");
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::findAll: " . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            return [];
        }
    }
    
    /**
     * Get default image URL for a product
     * @param array $product Product data
     * @return string Image URL
     */
    public function getDefaultImageUrl($product) {
        $productId = $product['rowid'];
        $productRef = $product['ref'];
    
        // Check if product has image_name field populated
        if (!empty($product['image_name'])) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/zai/public/img/products/' . $product['image_name'];
            
            // Check if file exists locally
            if (file_exists($imagePath)) {
                return LOCAL_IMAGE_BASE_URL . $product['image_name'];
            }
        }
        
        // Check if product has image_path field populated (fallback)
        if (!empty($product['image_path'])) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/zai/public/img/products/' . $product['image_path'];
            
            // Check if file exists locally
            if (file_exists($imagePath)) {
                return LOCAL_IMAGE_BASE_URL . $product['image_path'];
            }
        }
        
        // Try to find image by product ID or reference
        $possibleFilenames = [
            $productId . '.jpg',
            $productId . '.png',
            $productRef . '.jpg',
            $productRef . '.png',
            strtolower($productRef) . '.jpg',
            strtolower($productRef) . '.png'
        ];
        
        foreach ($possibleFilenames as $filename) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/zai/public/img/products/' . $filename;
            if (file_exists($imagePath)) {
                return LOCAL_IMAGE_BASE_URL . $filename;
            }
        }
        
        // Fallback to default image
        return LOCAL_IMAGE_BASE_URL . DEFAULT_PRODUCT_IMAGE;
    }
    
    /**
     * Find a product by its ID
     */
    public function findById($id) {
        try {
            // Modified query to remove dependency on h8pd_ecm_files table
            $query = "SELECT p.* FROM " . $this->table . " p WHERE p.rowid = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $product;
        } catch (Exception $e) {
            error_log("Error in Product::findById: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count total number of products
     */
    public function count() {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND tosell = 1";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? (int)$result['total'] : 0;
        } catch (Exception $e) {
            error_log("Error in Product::count: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get minimum value of a column
     */
    public function min($column = 'price') {
        try {
            $query = "SELECT MIN(" . $column . ") as min_value FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? (float)$result['min_value'] : 0;
        } catch (Exception $e) {
            error_log("Error in Product::min: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get maximum value of a column
     */
    public function max($column = 'price') {
        try {
            $query = "SELECT MAX(" . $column . ") as max_value FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? (float)$result['max_value'] : 0;
        } catch (Exception $e) {
            error_log("Error in Product::max: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Find products by category
     */
    public function findByCategory($categoryId, $limit = 0, $offset = 0) {
        try {
            // Check if the category-product relationship table exists
            $categoryProductTable = 'h8pd_categorie_product';
            
            // Query to check if table exists
            $checkTableQuery = "SHOW TABLES LIKE '{$categoryProductTable}'";
            $checkStmt = $this->conn->prepare($checkTableQuery);
            $checkStmt->execute();
            $tableExists = $checkStmt->rowCount() > 0;
            
            if ($tableExists) {
                // Use the relationship table
                $query = "SELECT p.* FROM {$this->table} p 
                          INNER JOIN {$categoryProductTable} cp ON p.rowid = cp.fk_product 
                          WHERE cp.fk_categorie = :category_id";
            } else {
                // Fallback to using the category field in the product table if it exists
                $query = "SELECT p.* FROM {$this->table} p 
                          WHERE p.fk_categorie = :category_id OR p.fk_product_type = :category_id";
            }
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Add ordering
            $query .= " ORDER BY p.datec DESC";
            
            // Add limit if provided
            if ($limit > 0) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            
            if ($limit > 0) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URLs for each product
            foreach ($products as &$product) {
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::findByCategory: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Find products by specific attribute
     */
    public function findByAttribute($attribute, $value, $operator = '=', $limit = 0, $offset = 0) {
        try {
            // Debug log
            error_log("Product::findByAttribute - Finding products with {$attribute} {$operator} {$value}");
            
            // Modified query to remove dependency on h8pd_ecm_files table
            $query = "SELECT p.* FROM " . $this->table . " p WHERE p.{$attribute} {$operator} :value";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Add ordering
            $query .= " ORDER BY p.datec DESC";
            
            // Add limit if provided
            if ($limit > 0) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $this->conn->prepare($query);
            
            // Adjust parameter binding based on operator
            if ($operator == 'LIKE') {
                $bindValue = '%' . $value . '%';
            } else {
                $bindValue = $value;
            }
            
            $stmt->bindParam(':value', $bindValue);
            
            if ($limit > 0) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug log
            error_log("Product::findByAttribute - Found " . count($products) . " products");
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::findByAttribute: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Find products by tag or type
     */
    public function findByTag($tag, $limit = 0, $offset = 0) {
        try {
            // Debug log
            error_log("Product::findByTag - Finding products with tag: {$tag}");
            
            // Modified query to remove dependency on h8pd_ecm_files table
            $query = "SELECT p.* FROM " . $this->table . " p 
                     WHERE (p.label LIKE :tag OR p.description LIKE :tag OR p.ref LIKE :tag)";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Add ordering
            $query .= " ORDER BY p.datec DESC";
            
            // Add limit if provided
            if ($limit > 0) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $this->conn->prepare($query);
            $tagParam = '%' . $tag . '%';
            $stmt->bindParam(':tag', $tagParam, PDO::PARAM_STR);
            
            if ($limit > 0) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug log
            error_log("Product::findByTag - Found " . count($products) . " products");
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::findByTag: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get random products (excluding a specific product)
     */
    public function getRandomProducts($limit = 4, $excludeId = null) {
        try {
            // Debug log
            error_log("Product::getRandomProducts - Getting random products, limit: $limit, excludeId: " . ($excludeId ?? 'null'));
            
            // Modified query to remove dependency on h8pd_ecm_files table
            $query = "SELECT p.* FROM " . $this->table . " p WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Exclude specific product if provided
            if ($excludeId) {
                $query .= " AND p.rowid != :exclude_id";
            }
            
            // MySQL uses RAND(), SQLite uses RANDOM()
            // Try to make it work with both database types
            try {
                $query .= " ORDER BY RAND() LIMIT :limit";
                
                $stmt = $this->conn->prepare($query);
                
                if ($excludeId) {
                    $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
                }
                
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                // If RAND() fails, try RANDOM() for SQLite
                error_log("Product::getRandomProducts - RAND() failed, trying RANDOM(): " . $e->getMessage());
                
                $query = str_replace("RAND()", "RANDOM()", $query);
                $stmt = $this->conn->prepare($query);
                
                if ($excludeId) {
                    $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
                }
                
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug log
            error_log("Product::getRandomProducts - Found " . count($products) . " random products");
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::getRandomProducts: " . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            return [];
        }
    }
    
    /**
     * Search products with filters
     */
    public function search($keyword = null, $minPrice = null, $maxPrice = null, $limit = 0, $offset = 0) {
        try {
            // Debug log
            error_log("Product::search - Searching products with keyword: " . ($keyword ?? 'null') . 
                      ", price range: " . ($minPrice ?? 'min') . "-" . ($maxPrice ?? 'max'));
            
            $query = "SELECT p.* FROM " . $this->table . " p WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Add keyword search if provided
            if ($keyword) {
                $query .= " AND (p.label LIKE :keyword OR p.description LIKE :keyword OR p.ref LIKE :keyword)";
            }
            
            // Add price range filters if provided
            if ($minPrice !== null) {
                $query .= " AND p.price >= :min_price";
            }
            
            if ($maxPrice !== null) {
                $query .= " AND p.price <= :max_price";
            }
            
            $query .= " ORDER BY p.datec DESC";
            
            if ($limit > 0) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $this->conn->prepare($query);
            
            // Bind parameters
            if ($keyword) {
                $keywordParam = '%' . $keyword . '%';
                $stmt->bindParam(':keyword', $keywordParam, PDO::PARAM_STR);
            }
            
            if ($minPrice !== null) {
                $stmt->bindParam(':min_price', $minPrice, PDO::PARAM_STR);
            }
            
            if ($maxPrice !== null) {
                $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_STR);
            }
            
            if ($limit > 0) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug log
            error_log("Product::search - Found " . count($products) . " products");
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::search: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get product details for cart
     * @param int $id Product ID
     * @return array|false Product data or false if not found
     */
    public function getForCart($id) {
        try {
            // Get basic product information
            $query = "SELECT p.rowid, p.ref, p.label, p.description, p.price, p.tosell 
                     FROM " . $this->table . " p 
                     WHERE p.rowid = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                // Set default image information
                $product['image_path'] = '';
                $product['image_name'] = '';
                $product['image_url'] = $this->getDefaultImageUrl($product);
                
                // Add additional cart-specific fields
                $product['quantity'] = 1; // Default quantity
                $product['total_price'] = $product['price']; // Initial total price
            }
            
            return $product;
        } catch (Exception $e) {
            error_log("Error in Product::getForCart: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if product is available for sale
     * @param int $id Product ID
     * @return bool True if available, false otherwise
     */
    public function isAvailableForSale($id) {
        try {
            $query = "SELECT tosell FROM " . $this->table . " WHERE rowid = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result && $result['tosell'] == 1;
        } catch (Exception $e) {
            error_log("Error in Product::isAvailableForSale: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Find similar products based on a given product
     * @param int $productId The product ID to find similar products for
     * @param int $limit Maximum number of similar products to return
     * @return array Array of similar products
     */
    public function findSimilarProducts($productId, $limit = 4) {
        try {
            // Get the current product to find its category or other attributes
            $product = $this->findById($productId);
            
            if (!$product) {
                return [];
            }
            
            // Find products with similar attributes (same category, similar price range, etc.)
            $query = "SELECT p.* FROM " . $this->table . " p WHERE p.rowid != :product_id";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // If the product has a category, prioritize products from the same category
            if (!empty($product['fk_product_type'])) {
                $query .= " ORDER BY (p.fk_product_type = :category) DESC, ";
            } else {
                $query .= " ORDER BY ";
            }
            
            // Order by price similarity as a secondary factor
            $query .= "ABS(p.price - :price) ASC LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            
            if (!empty($product['fk_product_type'])) {
                $stmt->bindParam(':category', $product['fk_product_type'], PDO::PARAM_INT);
            }
            
            $stmt->bindParam(':price', $product['price'], PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            
            $stmt->execute();
            $similarProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URL for each product
            foreach ($similarProducts as &$similarProduct) {
                // Set default image information
                $similarProduct['image_path'] = '';
                $similarProduct['image_name'] = '';
                $similarProduct['image_url'] = $this->getDefaultImageUrl($similarProduct);
            }
            
            return $similarProducts;
        } catch (Exception $e) {
            error_log("Error in Product::findSimilarProducts: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get featured products
     * @param int $limit Number of products to return
     * @return array Featured products
     */
    public function getFeaturedProducts($limit = 8) {
        try {
            // In a real system, featured products might be marked with a flag
            // For now, we'll simulate by getting the most expensive products
            $query = "SELECT p.* FROM " . $this->table . " p WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Order by price descending to get premium/featured products
            $query .= " ORDER BY p.price DESC LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::getFeaturedProducts: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get trending products
     * @param int $limit Number of products to return
     * @return array Trending products
     */
    public function getTrendingProducts($limit = 4) {
        try {
            // In a real system, trending products might be based on views or sales
            // For now, we'll simulate by getting the newest products
            $query = "SELECT p.* FROM " . $this->table . " p WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Order by date created descending to get newest products
            $query .= " ORDER BY p.datec DESC LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::getTrendingProducts: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get new arrivals
     * @param int $limit Number of products to return
     * @return array New arrival products
     */
    public function getNewArrivals($limit = 8) {
        try {
            // Get products created in the last 30 days
            $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
            
            $query = "SELECT p.* FROM " . $this->table . " p WHERE p.datec >= :date";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            $query .= " ORDER BY p.datec DESC LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':date', $thirtyDaysAgo);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                $product['image_url'] = $this->getDefaultImageUrl($product);
                // Mark as new
                $product['is_new'] = true;
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::getNewArrivals: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get best selling products
     * @param int $limit Number of products to return
     * @return array Best selling products
     */
    public function getBestSellers($limit = 8) {
        try {
            // In a real system, this would be based on order data
            // For now, we'll simulate by getting random products
            return $this->getRandomProducts($limit);
        } catch (Exception $e) {
            error_log("Error in Product::getBestSellers: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get products on sale/discount
     * @param int $limit Number of products to return
     * @return array Products on sale
     */
    public function getDiscountedProducts($limit = 8) {
        try {
            // In a real system, this would check for products with discounts
            // For now, we'll simulate by getting products with lower prices
            $query = "SELECT p.* FROM " . $this->table . " p WHERE 1=1";
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Get products with price below average
            $query .= " AND p.price < (SELECT AVG(price) FROM " . $this->table . ")";
            $query .= " ORDER BY p.price ASC LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URL and sale badge for each product
            foreach ($products as &$product) {
                $product['image_url'] = $this->getDefaultImageUrl($product);
                $product['on_sale'] = true;
                
                // Calculate a fake original price (20% higher)
                $product['original_price'] = round($product['price'] * 1.2, 2);
                $product['discount_percent'] = 20; // 20% off
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::getDiscountedProducts: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get related products by category
     * @param int $categoryId Category ID
     * @param int $excludeProductId Product ID to exclude
     * @param int $limit Number of products to return
     * @return array Related products
     */
    public function getRelatedByCategory($categoryId, $excludeProductId = null, $limit = 4) {
        try {
            // Check if the category-product relationship table exists
            $categoryProductTable = 'h8pd_categorie_product';
            
            // Query to check if table exists
            $checkTableQuery = "SHOW TABLES LIKE '{$categoryProductTable}'";
            $checkStmt = $this->conn->prepare($checkTableQuery);
            $checkStmt->execute();
            $tableExists = $checkStmt->rowCount() > 0;
            
            if ($tableExists) {
                // Use the relationship table
                $query = "SELECT p.* FROM {$this->table} p 
                          INNER JOIN {$categoryProductTable} cp ON p.rowid = cp.fk_product 
                          WHERE cp.fk_categorie = :category_id";
            } else {
                // Fallback to using the category field in the product table if it exists
                $query = "SELECT p.* FROM {$this->table} p 
                          WHERE p.fk_categorie = :category_id OR p.fk_product_type = :category_id";
            }
            
            // Add tosell filter if needed
            if (isset($this->tosell_filter) && $this->tosell_filter) {
                $query .= " AND p.tosell = 1";
            }
            
            // Exclude specific product if provided
            if ($excludeProductId) {
                $query .= " AND p.rowid != :exclude_id";
            }
            
            // Add ordering and limit
            $query .= " ORDER BY RAND() LIMIT :limit";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            
            if ($excludeProductId) {
                $stmt->bindParam(':exclude_id', $excludeProductId, PDO::PARAM_INT);
            }
            
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add default image URL for each product
            foreach ($products as &$product) {
                $product['image_url'] = $this->getDefaultImageUrl($product);
            }
            
            return $products;
        } catch (Exception $e) {
            error_log("Error in Product::getRelatedByCategory: " . $e->getMessage());
            
            // If the RAND() function fails (e.g., in SQLite), try with RANDOM()
            try {
                $query = str_replace("RAND()", "RANDOM()", $query ?? "");
                if (!empty($query)) {
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                    
                    if ($excludeProductId) {
                        $stmt->bindParam(':exclude_id', $excludeProductId, PDO::PARAM_INT);
                    }
                    
                    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Add default image URL for each product
                    foreach ($products as &$product) {
                        $product['image_url'] = $this->getDefaultImageUrl($product);
                    }
                    
                    return $products;
                }
            } catch (Exception $innerEx) {
                error_log("Error in Product::getRelatedByCategory (RANDOM fallback): " . $innerEx->getMessage());
            }
            
            // If all else fails, return empty array
            return [];
        }}}