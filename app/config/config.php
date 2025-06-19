<?php

// Load environment variables
require_once dirname(__FILE__) . '/env.php';

// Application configuration
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/zai/');
if (!defined('APP_ROOT')) define('APP_ROOT', dirname(dirname(__FILE__)));
if (!defined('SITE_NAME')) define('SITE_NAME', 'ZAI E-Commerce');
if (!defined('PUBLIC_ROOT')) define('PUBLIC_ROOT', BASE_URL . 'public/');

// Environment detection
if (!defined('ENVIRONMENT')) define('ENVIRONMENT', getenv('APP_ENV') ?: 'development');

// Dolibarr API configuration
if (!defined('DOLIBARR_API_URL')) define('DOLIBARR_API_URL', getenv('DOLIBARR_API_URL') ?: 'https://ecommerce.cieloo.io');
if (!defined('DOLIBARR_API_KEY')) define('DOLIBARR_API_KEY', getenv('DOLIBARR_API_KEY') ?: '');
if (!defined('DOLIBARR_USERNAME')) define('DOLIBARR_USERNAME', getenv('DOLIBARR_USERNAME') ?: 'khalil');
if (!defined('DOLIBARR_PASSWORD')) define('DOLIBARR_PASSWORD', getenv('DOLIBARR_PASSWORD') ?: 'khalil123');

// Dolibarr Database configuration
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: 'c137d.myd.infomaniak.com');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'c137d_app_dolibarr_20');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'c137d_ecom');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'Ecom2024@');
if (!defined('DB_PORT')) define('DB_PORT', getenv('DB_PORT') ?: '3306');
if (!defined('DB_PREFIX')) define('DB_PREFIX', getenv('DB_PREFIX') ?: 'llx_');

// Cache configuration
if (!defined('CACHE_ENABLED')) define('CACHE_ENABLED', true);
if (!defined('CACHE_DIR')) define('CACHE_DIR', dirname(dirname(dirname(__FILE__))) . '/cache');
if (!defined('CACHE_EXPIRY')) define('CACHE_EXPIRY', 3600); // 1 hour in seconds

// Error reporting based on environment
if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Session configuration - only start if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Helper functions
// Remove this entire function block to prevent redeclaration
/*
// Remove this entire function block (lines 51-69):
// function redirect($page) {
//     // Check if the page already has query parameters
//     if (strpos($page, '?') === 0) {
//         // It's already in the query parameter format
//         header('Location: ' . BASE_URL . $page);
//     } else {
//         // Convert to query parameter format if it's a simple path
//         $parts = explode('/', $page);
//         
//         if (count($parts) >= 2) {
//             header('Location: ' . BASE_URL . '?page=' . $parts[0] . '&action=' . $parts[1]);
//         } else if (count($parts) == 1 && !empty($parts[0])) {
//             header('Location: ' . BASE_URL . '?page=' . $parts[0]);
//         } else {
//             // Empty page, redirect to home
//             header('Location: ' . BASE_URL);
//         }
//     }
//     exit;
// }
}
*/

// Remove these duplicate function definitions to prevent redeclaration errors
/*
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}
*/

/**
 * Get environment variable with fallback
 * @param string $key Environment variable name
 * @param mixed $default Default value if not found
 * @return mixed
 */
if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        return $value;
    }
}

/**
 * Create cache directories if they don't exist
 */
if (!function_exists('ensureCacheDirectories')) {
    function ensureCacheDirectories() {
        if (!is_dir(CACHE_DIR)) {
            mkdir(CACHE_DIR, 0755, true);
        }
        
        $dolibarrCacheDir = CACHE_DIR . '/dolibarr';
        if (!is_dir($dolibarrCacheDir)) {
            mkdir($dolibarrCacheDir, 0755, true);
        }
    }
}

// Ensure cache directories exist
if (CACHE_ENABLED) {
    ensureCacheDirectories();
}
// Remove or comment out this line:
// define('INFOMANIAK_IMAGE_BASE_URL', 'https://c137d.ftp.infomaniak.com/public/theme/common/');

// Add local image configuration if not already defined
if (!defined('LOCAL_IMAGE_BASE_URL')) {
    define('LOCAL_IMAGE_BASE_URL', BASE_URL . 'public/img/products/');
}
if (!defined('DEFAULT_PRODUCT_IMAGE')) {
    define('DEFAULT_PRODUCT_IMAGE', 'default-product.jpg');
}
// Dolibarr Configuration
define('DOLIBARR_URL', 'https://your-dolibarr-instance.com');
// Remove this line - it's already defined at line 11:
// define('DOLIBARR_API_KEY', 'your-api-key-here');
?>