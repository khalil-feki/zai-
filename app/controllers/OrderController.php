<?php
require_once 'app/models/Order.php';
require_once 'app/middleware/AuthMiddleware.php';

class OrderController {
    private $orderModel;
    
    public function __construct() {
        // Check if user is logged in
        $authMiddleware = new AuthMiddleware();
        $authMiddleware->handle();
        
        $this->orderModel = new Order();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get user orders
        $ordersStmt = $this->orderModel->getUserOrders($userId);
        $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Load orders view
        require_once 'app/views/orders/index.php';
    }
    
    public function view($orderId) {
        $userId = $_SESSION['user_id'];
        
        // Get order details
        $orderStmt = $this->orderModel->getOrderDetails($orderId, $userId);
        
        if ($orderStmt->rowCount() === 0) {
            $_SESSION['error'] = 'Order not found';
            redirect('orders');
            return;
        }
        
        $order = $orderStmt->fetch(PDO::FETCH_ASSOC);
        
        // Get order items
        $orderItems = $this->orderModel->getOrderItems($orderId);
        
        // Process order items to add proper image URLs
        foreach ($orderItems as &$item) {
            $item['image_url'] = isset($item['image']) ? '/uploads/products/' . $item['image'] : '/img/default-product.jpg';
        }
        
        // Load order view
        require_once 'app/views/orders/view.php';
    }
}
?>