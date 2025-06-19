<?php
require_once 'app/models/Order.php';
require_once 'app/models/Cart.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

class OrdersController {
    private $orderModel;
    private $cartModel;
    
    public function __construct() {
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
    }
    
    /**
     * Display list of user orders
     */
    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please login to view your orders";
            redirect('auth/login');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $userEmail = $_SESSION['user_email'] ?? null;
        
        // Always filter orders by the logged-in user's email
        if ($userEmail) {
            // Get orders by email from ref_client field
            $orders = $this->orderModel->getOrdersByEmail($userEmail);
            error_log("Retrieving orders for user email: {$userEmail}");
        } else {
            // Fallback to user ID if email is not available
            $orders = $this->orderModel->getUserOrders($userId);
            error_log("Retrieving orders for user ID: {$userId} (no email available)");
        }
        
        if ($orders === false) {
            $orders = [];
            $_SESSION['error'] = "Failed to retrieve orders";
        }
        
        error_log("Found " . count($orders) . " orders for user");
        
        // Load orders view
        require_once 'app/views/orders/index.php';
    }
    
    /**
     * Search orders by email in reference field
     */
    public function searchByEmail() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please login to search orders";
            redirect('auth/login');
            return;
        }
        
        $searchEmail = $_GET['email'] ?? $_SESSION['user_email'] ?? '';
        
        if (empty($searchEmail)) {
            $_SESSION['error'] = "Please provide an email to search";
            redirect('orders');
            return;
        }
        
        // Get orders by email from reference field
        $orders = $this->orderModel->getOrdersByEmail($searchEmail);
        
        if ($orders === false) {
            $orders = [];
            $_SESSION['error'] = "Failed to retrieve orders";
        }
        
        // Set search context for the view
        $searchContext = [
            'type' => 'email',
            'value' => $searchEmail,
            'results_count' => count($orders)
        ];
        
        // Load orders view with search context
        require_once 'app/views/orders/index.php';
    }
    
    /**
     * Display order details
     * @param int $id Order ID
     */
    public function view($id = null) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please login to view order details";
            redirect('auth/login');
            return;
        }
        
        if (!$id) {
            $_SESSION['error'] = "Invalid order ID";
            redirect('orders');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get order details
        $orderStmt = $this->orderModel->getOrderDetails($id, $userId);
        
        if ($orderStmt && $orderStmt->rowCount() > 0) {
            $order = $orderStmt->fetch(PDO::FETCH_ASSOC);
            
            // Get order items
            $orderItems = $this->orderModel->getOrderItems($id);
            
            // Load order view
            require_once 'app/views/orders/view.php';
        } else {
            $_SESSION['error'] = "Order not found or you don't have permission to view it";
            redirect('orders');
        }
    }
    
    /**
     * Create a new order from cart
     */
    public function create() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please login to place an order";
            redirect('auth/login');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get cart items
        $cartItems = $this->cartModel->getCartItems($userId);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = "Your cart is empty";
            redirect('cart');
            return;
        }
        
        // Process shipping address from POST data
        $shippingAddress = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect and validate address information
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $address = isset($_POST['address']) ? trim($_POST['address']) : '';
            $city = isset($_POST['city']) ? trim($_POST['city']) : '';
            $state = isset($_POST['state']) ? trim($_POST['state']) : '';
            $zip = isset($_POST['zip']) ? trim($_POST['zip']) : '';
            $country = isset($_POST['country']) ? trim($_POST['country']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            
            // Validate required fields
            if (empty($name) || empty($address) || empty($city) || empty($zip) || empty($country)) {
                $_SESSION['error'] = "Please fill in all required address fields";
                redirect('checkout');
                return;
            }
            
            // Format shipping address
            $shippingAddress = "$name\n$address\n$city, $state $zip\n$country\nPhone: $phone";
            
            // Create order
            // Around line 123, change from:
            
            // To:
            // Create order
            $orderId = $this->orderModel->createOrder($userId, $cartItems);
            
            if ($orderId) {
                // Clear cart after successful order
                $this->cartModel->clearCart($userId);
                
                $_SESSION['success'] = "Order placed successfully!";
                redirect('orders/view/' . $orderId);
            } else {
                $_SESSION['error'] = "Failed to place order. Please try again.";
                redirect('orders');
            }
        } else {
            // If not POST request, redirect to checkout
            redirect('checkout');
        }
    }
}
?>