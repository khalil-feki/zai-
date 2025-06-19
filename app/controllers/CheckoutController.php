<?php

require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';
require_once 'app/models/Product.php';
require_once 'app/services/DolibarrService.php';
require_once 'app/helpers/functions.php';
class CheckoutController
{
    private $cartModel;
    private $orderModel;
    private $userModel;
    private $dolibarrService;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->userModel = new User();
        $this->dolibarrService = new DolibarrService();
    }

    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = 'Please log in to proceed with checkout.';
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Get cart items
        $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
        
        // Check if cart is empty
        if (empty($cartItems)) {
            $_SESSION['error_message'] = 'Your cart is empty. Please add items before checkout.';
            header('Location: ' . BASE_URL . 'cart');
            exit();
        }

        // Calculate total
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        // Include the checkout view
        require_once 'app/views/checkout/index.php';
    }

    public function process()
    {
        // Enhanced debug logging
        error_log('=== CHECKOUT PROCESS START ===');
        error_log('REQUEST_METHOD: ' . $_SERVER['REQUEST_METHOD']);
        error_log('POST data: ' . print_r($_POST, true));
        error_log('Session data: ' . print_r($_SESSION, true));
        error_log('User ID: ' . ($_SESSION['user_id'] ?? 'NOT SET'));
        
        // Ensure this is a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log('ERROR: Not a POST request');
            $_SESSION['error_message'] = 'Invalid request method.';
            header('Location: ' . BASE_URL . 'checkout');
            exit();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            error_log('ERROR: User not logged in');
            $_SESSION['error_message'] = 'Please log in to place an order.';
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        error_log('Processing order for user ID: ' . $userId);

        // Get cart items
        $cartItems = $this->cartModel->getCartItems($userId);
        error_log('Cart items count: ' . count($cartItems));
        
        if (empty($cartItems)) {
            error_log('ERROR: Cart is empty');
            $_SESSION['error_message'] = 'Your cart is empty.';
            header('Location: ' . BASE_URL . 'cart');
            exit();
        }

        // Validate required fields
        $shippingAddress = trim($_POST['shipping_address'] ?? '');
        $billingAddress = trim($_POST['billing_address'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? '';
        $notes = trim($_POST['notes'] ?? '');
        
        // If billing address is empty, use shipping address
        if (empty($billingAddress)) {
            $billingAddress = $shippingAddress;
        }
        
        error_log('Shipping address: ' . $shippingAddress);
        error_log('Payment method: ' . $paymentMethod);
        
        if (empty($shippingAddress)) {
            error_log('ERROR: Shipping address is empty');
            $_SESSION['error_message'] = 'Shipping address is required.';
            header('Location: ' . BASE_URL . 'checkout');
            exit();
        }
        
        if (empty($paymentMethod)) {
            error_log('ERROR: Payment method is empty');
            $_SESSION['error_message'] = 'Please select a payment method.';
            header('Location: ' . BASE_URL . 'checkout');
            exit();
        }

        try {
            error_log('Attempting to create order...');
            
            // Debug cart items structure
            error_log('Cart items before order creation:');
            foreach ($cartItems as $index => $item) {
                error_log(sprintf(
                    'Item %d: product_id=%s, label=%s, price=%s, quantity=%s',
                    $index + 1,
                    $item['product_id'] ?? 'NOT SET',
                    $item['label'] ?? 'NOT SET',
                    $item['price'] ?? 'NOT SET',
                    $item['quantity'] ?? 'NOT SET'
                ));
            }
            
            // Get user information
            $user = $this->userModel->findById($userId);
            if (!$user) {
                throw new Exception('User not found');
            }
            
            error_log('Creating order directly in database (bypassing Dolibarr API)');
            
            // Transform cart items to include proper price calculations
            $orderItems = array_map(function($item) {
                return [
                    'product_id' => $item['product_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity']
                ];
            }, $cartItems);

            // Prepare order notes
            $notePrivate = 'Order created from web application';
            $notePublic = 'Web order';
            
            // Add shipping and billing information
            $notePrivate .= '\nShipping: ' . $shippingAddress;
            if ($billingAddress !== $shippingAddress) {
                $notePrivate .= '\nBilling: ' . $billingAddress;
            }
            $notePrivate .= '\nPayment: ' . $paymentMethod;
            
            // Add customer notes if provided
            if (!empty($notes)) {
                $notePrivate .= '\nCustomer Notes: ' . $notes;
                $notePublic .= ' - ' . $notes;
            }

            // Create the local order with transformed items
            $orderData = [
                'user_id' => $userId,
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'payment_method' => $paymentMethod,
                'notes' => $notePrivate
            ];
            $orderId = $this->orderModel->createOrder($orderData, $orderItems);
            
            error_log('Order creation result: ' . ($orderId ? $orderId : 'FAILED'));

            if ($orderId) {
                error_log('Order created successfully with ID: ' . $orderId);
                
                // Cart is automatically cleared in the Order model during transaction
                
                // Set success message
                $_SESSION['success_message'] = 'Order placed successfully! Order ID: ' . $orderId;
                
                // Redirect to order success page
                error_log('Redirecting to success page...');
                header('Location: ' . BASE_URL . 'checkout/success/' . $orderId);
                exit();
            } else {
                error_log('ERROR: Order creation returned false');
                $_SESSION['error_message'] = 'Failed to place order. Please try again.';
                header('Location: ' . BASE_URL . 'checkout');
                exit();
            }
        } catch (Exception $e) {
            error_log('EXCEPTION: Order creation failed: ' . $e->getMessage());
            error_log('Exception trace: ' . $e->getTraceAsString());
            $_SESSION['error_message'] = 'An error occurred while placing your order: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'checkout');
            exit();
        }
    }

    public function success($orderId = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if (!$orderId) {
            $_SESSION['error_message'] = 'Invalid order ID.';
            header('Location: ' . BASE_URL);
            exit();
        }

        $userId = $_SESSION['user_id'];

        // Get order details
        try {
            $orderStmt = $this->orderModel->getOrderDetails($orderId, $userId);

            if ($orderStmt->rowCount() === 0) {
                $_SESSION['error_message'] = 'Order not found or access denied.';
                header('Location: ' . BASE_URL);
                exit();
            }

            $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

            // Get order items
            $orderItems = $this->orderModel->getOrderItems($orderId);

            // Include the success view
            require_once 'app/views/checkout/success.php';
        } catch (Exception $e) {
            error_log('Error loading order success page: ' . $e->getMessage());
            $_SESSION['error_message'] = 'Error loading order details.';
            header('Location: ' . BASE_URL);
            exit();
        }
    }
}