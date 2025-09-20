<?php
// Router for PHP built-in server to handle extensionless URLs
// This ensures URLs like /student/login work properly

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Serve static files directly
if (preg_match('/\.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $path)) {
    $file_path = __DIR__ . $path;
    if (file_exists($file_path)) {
        return false; // Serve the file
    }
}

// Route everything else through index.php
require_once __DIR__ . '/index.php';
?>