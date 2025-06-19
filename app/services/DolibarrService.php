<?php
class DolibarrService {
    private $apiUrl;
    private $apiKey;
    private $username;
    private $password;
    private $token;
    private $cacheDir;
    private $cacheExpiry = 3600; // 1 hour

    public function __construct($apiUrl = null, $apiKey = null, $username = null, $password = null) {
        // Use provided parameters or fall back to environment variables
        $this->apiUrl = $apiUrl ?: (getenv('DOLIBARR_API_URL') ?: ($_ENV['DOLIBARR_API_URL'] ?? 'https://ecommerce.cieloo.io'));
        $this->apiKey = $apiKey ?: (getenv('DOLIBARR_API_KEY') ?: ($_ENV['DOLIBARR_API_KEY'] ?? 'admin123456789'));
        $this->username = $username ?: (getenv('DOLIBARR_USERNAME') ?: ($_ENV['DOLIBARR_USERNAME'] ?? 'khalil'));
        $this->password = $password ?: (getenv('DOLIBARR_PASSWORD') ?: ($_ENV['DOLIBARR_PASSWORD'] ?? 'khalil123'));
        $this->token = null;
        
        // Validate that we have a proper API URL
        if (empty($this->apiUrl) || !filter_var($this->apiUrl, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid or missing DOLIBARR_API_URL: ' . $this->apiUrl);
        }
        
        // Set up cache directory
        $this->cacheDir = dirname(dirname(dirname(__FILE__))) . '/cache/dolibarr';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function isConnected() {
        // Check if we already have a token
        if ($this->token) {
            return true;
        }
        
        // Try to authenticate
        try {
            return $this->authenticate();
        } catch (Exception $e) {
            return false;
        }
    }

    public function authenticate() {
        // For Dolibarr API, we use DOLAPIKEY header authentication
        // No need to call login endpoint, just test with a simple API call
        $url = $this->apiUrl . '/api/index.php/status';
        
        $response = $this->makeRequest('GET', $url);
        
        // If we get a valid response without error, authentication is working
        if (!isset($response['error'])) {
            return true;
        }
        
        // If we get here, authentication failed
        return false;
    }

    public function getProducts($limit = 10, $offset = 0) {
        $cacheKey = "products_" . $limit . "_" . $offset;
        $cachedData = $this->getCache($cacheKey);
        
        if ($cachedData !== false) {
            return $cachedData;
        }
        
        $url = $this->apiUrl . '/api/index.php/products?limit=' . $limit . '&page=' . $offset;
        $response = $this->makeRequest('GET', $url);
        
        if (!isset($response['error'])) {
            $this->setCache($cacheKey, $response);
        }
        
        return $response;
    }

    public function getProduct($id) {
        $cacheKey = "product_" . $id;
        $cachedData = $this->getCache($cacheKey);
        
        if ($cachedData !== false) {
            return $cachedData;
        }
        
        $url = $this->apiUrl . '/api/index.php/products/' . $id;
        $response = $this->makeRequest('GET', $url);
        
        if (!isset($response['error'])) {
            $this->setCache($cacheKey, $response);
        }
        
        return $response;
    }
    
    public function getOrders($limit = 10, $offset = 0) {
        $cacheKey = "orders_" . $limit . "_" . $offset;
        $cachedData = $this->getCache($cacheKey);
        
        if ($cachedData !== false) {
            return $cachedData;
        }
        
        $url = $this->apiUrl . '/api/index.php/orders?limit=' . $limit . '&page=' . $offset;
        $response = $this->makeRequest('GET', $url);
        
        if (!isset($response['error'])) {
            $this->setCache($cacheKey, $response);
        }
        
        return $response;
    }
    
    public function createDraftOrder($orderData) {
        $url = $this->apiUrl . '/api/index.php/orders';
        
        // Prepare order data for Dolibarr API
        $dolibarrOrderData = [
            'socid' => isset($orderData['socid']) ? $orderData['socid'] : (isset($orderData['customer_id']) ? $orderData['customer_id'] : 1),
            'date' => isset($orderData['date']) ? $orderData['date'] : date('Y-m-d'),
            'ref_client' => $orderData['ref_client'] ?? '',
            'note_public' => $orderData['note_public'] ?? '',
            'note_private' => $orderData['note_private'] ?? '',
            'lines' => []
        ];
        
        // Add order lines
        if (isset($orderData['lines']) && is_array($orderData['lines'])) {
            foreach ($orderData['lines'] as $line) {
                $dolibarrOrderData['lines'][] = [
                    'fk_product' => isset($line['fk_product']) ? $line['fk_product'] : (isset($line['product_id']) ? $line['product_id'] : 1),
                    'qty' => isset($line['qty']) ? $line['qty'] : (isset($line['quantity']) ? $line['quantity'] : 1),
                    'subprice' => isset($line['subprice']) ? $line['subprice'] : (isset($line['price']) ? $line['price'] : 0),
                    'desc' => isset($line['desc']) ? $line['desc'] : (isset($line['description']) ? $line['description'] : '')
                ];
            }
        }
        
        $response = $this->makeRequest('POST', $url, $dolibarrOrderData);
        
        return $response;
    }
    
    public function validateOrder($orderId) {
        $url = $this->apiUrl . '/api/index.php/orders/' . $orderId . '/validate';
        $response = $this->makeRequest('POST', $url, ['notrigger' => 0]);
        
        return $response;
    }
    
    public function getCustomerByEmail($email) {
        $url = $this->apiUrl . '/api/index.php/thirdparties?sqlfilters=(t.email:=:' . urlencode($email) . ')';
        $response = $this->makeRequest('GET', $url);
        
        return $response;
    }
    
    public function createCustomer($customerData) {
        $url = $this->apiUrl . '/api/index.php/thirdparties';
        
        // Prepare customer data for Dolibarr API
        $data = [
            'name' => $customerData['name'] ?? $customerData['email'],
            'email' => $customerData['email'],
            'client' => 1, // Mark as customer
            'code_client' => -1, // Auto-generate customer code
        ];
        
        // Add optional fields if provided
        if (isset($customerData['firstname'])) {
            $data['firstname'] = $customerData['firstname'];
        }
        if (isset($customerData['lastname'])) {
            $data['lastname'] = $customerData['lastname'];
        }
        if (isset($customerData['address'])) {
            $data['address'] = $customerData['address'];
        }
        if (isset($customerData['phone'])) {
            $data['phone'] = $customerData['phone'];
        }
        
        $response = $this->makeRequest('POST', $url, $data);
        
        return $response;
    }

    private function makeRequest($method, $url, $data = null) {
        // Validate URL before making request
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return ['error' => 'Invalid URL: ' . $url];
        }
        
        $curl = curl_init();

        $headers = [
            'DOLAPIKEY: ' . $this->apiKey,
            'Content-Type: application/json'
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false, // Only for development
        ]);

        if ($data && ($method === 'POST' || $method === 'PUT')) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            return ['error' => $err];
        } else {
            $decodedResponse = json_decode($response, true);
            
            // Handle error responses
            if ($httpCode >= 400) {
                return [
                    'error' => 'HTTP Error ' . $httpCode,
                    'message' => is_array($decodedResponse) ? json_encode($decodedResponse) : $response
                ];
            }
            
            return $decodedResponse;
        }
    }
    
    // Cache methods
    private function getCache($key) {
        $cacheFile = $this->cacheDir . '/' . md5($key) . '.cache';
        
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $this->cacheExpiry)) {
            return json_decode(file_get_contents($cacheFile), true);
        }
        
        return false;
    }
    
    private function setCache($key, $data) {
        $cacheFile = $this->cacheDir . '/' . md5($key) . '.cache';
        file_put_contents($cacheFile, json_encode($data));
    }
}