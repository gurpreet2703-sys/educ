<?php
// Configuration settings for Educationali platform

// Session configuration (must be set before session_start)
if (!session_id()) {
    ini_set('session.cookie_httponly', 1);
    // Only set secure flag if we're using HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Basic site configuration
define('SITE_NAME', 'Educationali');
define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST']);
define('BASE_PATH', dirname(__DIR__));

// Database configuration (Supabase)
$database_url = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');

if ($database_url) {
    $parsed = parse_url($database_url);
    define('DB_HOST', $parsed['host']);
    define('DB_PORT', $parsed['port'] ?? 5432);
    define('DB_NAME', ltrim($parsed['path'], '/'));
    define('DB_USER', $parsed['user']);
    define('DB_PASS', $parsed['pass']);
} else {
    throw new Exception('DATABASE_URL environment variable not found');
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('UTC');

// Include required files
require_once BASE_PATH . '/includes/functions.php';
require_once BASE_PATH . '/includes/database.php';
require_once BASE_PATH . '/includes/auth.php';

// Check remember me cookie for auto-login (disabled for security)
// check_remember_me();
?>