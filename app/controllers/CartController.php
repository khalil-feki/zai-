<?php
require_once 'app/models/Cart.php';
require_once 'app/models/Product.php';

class CartController {
    private $cartModel;
    private $productModel;
    
    public function __construct() {
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }
    
    /**
     * Index method for cart route
     */
    public function index() {
        $this->viewCart();
    }
    
    /**
     * View cart
     */
    public function viewCart() {
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Please login to view cart');
            } else {
                header('Location: /auth/login');
                exit;
            }
        }
        
        $cartItems = $this->cartModel->getCartItems($userId);
        
        // Process cart items and calculate total
        $cartTotal = 0;
        foreach ($cartItems as &$item) {
            // Generate image URL using only image_name
            if (!empty($item['image_name'])) {
                $item['image_url'] = '/public/uploads/products/' . $item['image_name'];
            } else {
                $item['image_url'] = '/public/img/products/default.jpg';
            }
            
            // Calculate cart total
            $cartTotal += $item['total_price'];
        }
        
        if ($this->isAjaxRequest()) {
            $this->sendJsonResponse(true, 'Cart data retrieved successfully', [
                'items' => $cartItems,
                'total' => $cartTotal
            ]);
        } else {
            require_once 'app/views/cart/index.php';
        }
    }
    
    /**
     * Add product to cart
     */
    public function addToCart() {
        error_log('=== ADD TO CART START ===');
        error_log('POST data: ' . print_r($_POST, true));
        error_log('Session data: ' . print_r($_SESSION, true));

        if (!isset($_SESSION['user_id'])) {
            error_log('Error: User not logged in');
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Please login to add items to cart');
            } else {
                $_SESSION['error'] = 'Please login to add items to cart';
                redirect('auth/login');
            }
            return;
        }
        
        if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Product ID is required');
            } else {
                $_SESSION['error'] = 'Product ID is required';
                redirect('');
            }
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $productId = (int)$_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        
        if ($quantity <= 0) {
            $quantity = 1;
        }
        
        // Verify product exists
        $product = $this->productModel->findById($productId);
        if (!$product) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Product not found');
            } else {
                $_SESSION['error'] = 'Product not found';
                redirect('cart');
            }
            return;
        }
        
        // Add to cart
        error_log(sprintf('Attempting to add product: ID=%d, Quantity=%d for User=%d', $productId, $quantity, $userId));
        $result = $this->cartModel->addToCart($userId, $productId, $quantity);
        
        if ($result) {
            error_log('Product added successfully');
            $cartCount = $this->cartModel->getCartCount($userId);
            error_log('New cart count: ' . $cartCount);
            
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(true, 'Product added to cart successfully', [
                    'cart_count' => $cartCount,
                    'redirect_url' => BASE_URL . 'cart'
                ]);
            } else {
                $_SESSION['success'] = 'Product added to cart successfully';
                // Get the referring page to redirect back
                $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL;
                header('Location: ' . $referer);
                exit;
            }
        } else {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Failed to add product to cart');
            } else {
                $_SESSION['error'] = 'Failed to add product to cart';
                redirect('cart');
            }
        }
    }
    
    /**
     * Update cart item quantity
     */
    public function updateCart() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to update your cart';
            redirect('auth/login');
            return;
        }
        
        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            $_SESSION['error'] = 'Invalid request';
            redirect('cart');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $productId = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        
        $result = $this->cartModel->updateQuantity($userId, $productId, $quantity);
        
        if ($result) {
            $_SESSION['success'] = 'Cart updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update cart';
        }
        
        redirect('cart');
    }
    
    /**
     * Remove item from cart
     */
    public function removeFromCart() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to modify your cart';
            redirect('auth/login');
            return;
        }
        
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($productId <= 0) {
            $_SESSION['error'] = 'Invalid product ID';
            redirect('cart');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $result = $this->cartModel->removeFromCart($userId, $productId);
        
        if ($result) {
            $_SESSION['success'] = 'Item removed from cart';
        } else {
            $_SESSION['error'] = 'Failed to remove item from cart';
        }
        
        redirect('cart');
    }
    
    /**
     * Clear entire cart
     */
    public function clearCart() {
        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Please login to clear your cart');
            } else {
                $_SESSION['error'] = 'Please login to clear your cart';
                redirect('auth/login');
            }
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $result = $this->cartModel->clearCart($userId);
        
        if ($result) {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(true, 'Cart cleared successfully');
            } else {
                $_SESSION['success'] = 'Cart cleared successfully';
                redirect('');
            }
        } else {
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Failed to clear cart');
            } else {
                $_SESSION['error'] = 'Failed to clear cart';
                redirect('');
            }
        }
    }
    
    /**
     * Check if request is AJAX
     */
    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Send JSON response
     */
    private function sendJsonResponse($success, $message, $data = []) {
        // Clear any previous output
        if (ob_get_length()) ob_clean();
        
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        $response = array_merge([
            'success' => $success,
            'message' => $message
        ], $data);
        
        echo json_encode($response);
        exit;
    }
}
?>