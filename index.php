<?php
// Start output buffering at the very beginning of your script
ob_start();

// Start session
session_start();

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define environment
define('ENVIRONMENT', 'development');

// Load environment variables first
require_once 'app/config/env.php';

// Load configuration and error handler
require_once 'config/config.php';
require_once 'app/config/config.php';  // Add this line
require_once 'app/helpers/ErrorHandler.php';
require_once 'app/helpers/functions.php'; // Add this line to include helper functions

// Set error and exception handlers
set_exception_handler([ErrorHandler::class, 'handleException']);
// Create public/img/products directory if it doesn't exist
$productsImgDir = 'public/img/products';
if (!file_exists($productsImgDir)) {
    mkdir($productsImgDir, 0777, true);
    
    // Create a placeholder image if it doesn't exist
    $placeholderPath = $productsImgDir . '/placeholder.jpg';
    if (!file_exists($placeholderPath)) {
        // Create a simple placeholder image or copy from a default
        copy('public/img/placeholder.jpg', $placeholderPath);
    }
}
// Create public/uploads/products directory if it doesn't exist
$productsUploadDir = 'public/uploads/products';
if (!file_exists($productsUploadDir)) {
    mkdir($productsUploadDir, 0755, true);
    
    // Create a default image if it doesn't exist
    $defaultPath = $productsUploadDir . '/default.jpg';
    if (!file_exists($defaultPath)) {
        // Copy from a default image or create a simple one
        if (file_exists('public/img/placeholder.jpg')) {
            copy('public/img/placeholder.jpg', $defaultPath);
        }
    }
}
try {
    // Parse URL
    $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    // Get controller, method and parameters
    $controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
    $method = !empty($url[1]) ? $url[1] : 'index';
    $params = array_slice($url, 2);
    
    // Define route for use in conditional statements
    $route = strtolower(!empty($url[0]) ? $url[0] : 'home') . '/' . strtolower(!empty($url[1]) ? $url[1] : 'index');

    // Special routes handling
    if ($route === 'admin/products/upload-image') {
        // Instead of directly using ProductController, use the standard controller loading mechanism
        $controllerName = 'ProductController';
        $method = 'uploadImage';
        $params = [];
    }

    // Handle cart routes
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    if ($page === 'cart') { 
        require_once 'app/controllers/CartController.php'; 
        $cartController = new CartController(); 
        $action = isset($_GET['action']) ? $_GET['action'] : 'view'; 
        switch ($action) { 
            case 'add': 
                $cartController->addToCart(); 
                break; 
            case 'update': 
                $cartController->updateCart(); 
                break; 
            case 'remove': 
                $cartController->removeFromCart(); 
                break; 
            case 'clear': 
                $cartController->clearCart(); 
                break; 
            default: 
                $cartController->viewCart(); 
                break; 
        }
        exit; // Exit after handling cart to prevent further processing
    }

    // Handle category routes
    if ($page === 'categories' || $page === 'category') {
        require_once 'app/controllers/CategoryController.php';
        $categoryController = new CategoryController();
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        switch ($action) {
            case 'view':
                if ($id) {
                    $categoryController->view($id);
                } else {
                    $categoryController->index();
                }
                break;
            default:
                $categoryController->index();
                break;
        }
        exit; // Exit after handling categories to prevent further processing
    }

    // Handle checkout routes
    if (!empty($url[0]) && $url[0] === 'checkout') {
        require_once 'app/controllers/CheckoutController.php';
        $checkoutController = new CheckoutController();
        
        $action = !empty($url[1]) ? $url[1] : 'index';
        
        switch ($action) {
            case 'process':
                $checkoutController->process();
                break;
            case 'success':
                $orderId = !empty($url[2]) ? $url[2] : null;
                $checkoutController->success($orderId);
                break;
            default:
                $checkoutController->index();
                break;
        }
        exit; // Exit after handling checkout to prevent further processing
    }

    // User routes
    if ($page === 'user') {
        require_once 'app/controllers/UserController.php';
        $userController = new UserController();
        
        $action = isset($_GET['action']) ? $_GET['action'] : 'profile';
        
        switch ($action) {
            case 'profile':
                $userController->profile();
                break;
            case 'update':
                $userController->update();
                break;
            case 'orders':
                $userController->orders();
                break;
            case 'addresses':
                $userController->addresses();
                break;
            case 'saveAddress':
                $userController->saveAddress();
                break;
            default:
                $userController->profile();
                break;
        }
        exit; // Exit after handling user to prevent further processing
    }
    
    // Auth routes
    else if ($page === 'auth') {
        require_once 'app/controllers/AuthController.php';
        $authController = new AuthController();
        
        $action = isset($_GET['action']) ? $_GET['action'] : 'login';
        
        if ($action === 'login') {
            $authController->login();
        } else if ($action === 'register') {
            $authController->register();
        } else if ($action === 'logout') {
            $authController->logout();
        } else if ($action === 'forgot-password') {
            $authController->forgotPassword();
        } else if ($action === 'reset-password') {
            $authController->resetPassword();
        } else {
            // Default to login
            $authController->login();
        }
        exit; // Exit after handling auth to prevent further processing
    }

    // Check if controller exists
    $controllerFile = 'app/controllers/' . $controllerName . '.php';
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        // Create controller instance
        $controller = new $controllerName();
        
        // Check if method exists
        if (method_exists($controller, $method)) {
            // Call method with parameters
            call_user_func_array([$controller, $method], $params);
        } else {
            throw new Exception("Method not found: {$method}");
        }
    } else {
        // If controller doesn't exist, try to load a static page
        $staticPage = strtolower($url[0]);
        $staticFile = 'app/views/static/' . $staticPage . '.php';
        
        if (file_exists($staticFile)) {
            require_once 'app/views/containers/header.php';
            require_once $staticFile;
            require_once 'app/views/containers/footer.php';
        } else {
            // Try to load 404 page
            if (file_exists('app/views/404.php')) {
                require_once 'app/views/404.php';
            } else {
                throw new Exception("Controller not found: {$controllerName}");
            }
        }
    }
} catch (Exception $e) {
    ErrorHandler::handleException($e);
}
?>

