<?php
/**
 * Simple .env file loader
 * Loads environment variables from .env file in project root
 */
function loadEnvFile() {
    $envFile = dirname(dirname(dirname(__FILE__))) . '/.env';
    
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Only process valid lines with equals sign
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                
                // Set environment variable
                putenv("$name=$value");
                // Also set in $_ENV superglobal for better compatibility
                $_ENV[$name] = $value;
            }
        }
    } else {
        // Debug: file not found
        error_log("ENV file not found at: " . $envFile);
    }
}

// Load environment variables
loadEnvFile();

/**
 * Get environment variable with fallback
 */
function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    return $value;
}
?>
