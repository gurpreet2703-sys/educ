<?php
// Utility functions for Educationali platform

/**
 * Include header template
 */
function include_header($title = '', $extra_css = []) {
    $page_title = !empty($title) ? $title . ' - ' . SITE_NAME : SITE_NAME;
    include BASE_PATH . '/templates/header.php';
}

/**
 * Include footer template
 */
function include_footer($extra_js = []) {
    include BASE_PATH . '/templates/footer.php';
}

/**
 * Sanitize input data
 */
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user role
 */
function get_user_role() {
    return $_SESSION['user_role'] ?? '';
}

/**
 * Redirect function
 */
function redirect($url) {
    header("Location: $url");
    exit();
}


/**
 * Get badge color for user roles
 */
function get_role_badge_color($role) {
    switch ($role) {
        case 'admin': return 'danger';
        case 'teacher': return 'success';
        case 'student': return 'primary';
        default: return 'secondary';
    }
}

/**
 * Get color for teacher status
 */
function get_teacher_status_color($status) {
    switch ($status) {
        case 'approved': return 'success';
        case 'pending': return 'warning';
        case 'rejected': return 'danger';
        default: return 'secondary';
    }
}

/**
 * Database connection function
 */
function get_db_connection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            if (!defined('DB_HOST')) {
                throw new Exception('Database configuration not found. Please configure DATABASE_URL.');
            }
            
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception('Database connection failed. Please try again later.');
        }
    }
    
    return $pdo;
}
?>