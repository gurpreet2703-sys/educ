<?php
// Basic router for the Educationali platform
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove any query parameters and leading slash
$path = trim($path, '/');

// Include configuration (this will start session and include all needed files)
require_once 'config/config.php';

// Basic routing
switch ($path) {
    case '':
    case 'home':
        require 'pages/home.php';
        break;
    case 'about':
        require 'pages/about.php';
        break;
    case 'contact':
        require 'pages/contact.php';
        break;
    case 'privacy':
        require 'pages/privacy.php';
        break;
    case 'terms':
        require 'pages/terms.php';
        break;
    case 'refund':
        require 'pages/refund.php';
        break;
    case 'partner':
        require 'pages/partner.php';
        break;
    case 'admin/login':
        require 'admin/login.php';
        break;
    case 'admin/signup':
        require 'admin/signup.php';
        break;
    case 'teacher/login':
        require 'teacher/login.php';
        break;
    case 'teacher/signup':
        require 'teacher/signup.php';
        break;
    case 'student/login':
        require 'student/login.php';
        break;
    case 'student/signup':
        require 'student/signup.php';
        break;
    case 'logout':
        require 'logout.php';
        break;
    case 'admin/dashboard':
        require 'admin/dashboard.php';
        break;
    case 'admin/users':
        require 'admin/users.php';
        break;
    case 'admin/teachers':
        require 'admin/teachers.php';
        break;
    case 'teacher/dashboard':
        require 'teacher/dashboard.php';
        break;
    case 'teacher/profile':
        require 'teacher/profile.php';
        break;
    case 'student/dashboard':
        require 'student/dashboard.php';
        break;
    case 'teachers':
        require 'pages/teachers.php';
        break;
    case '403':
        http_response_code(403);
        require 'pages/403.php';
        break;
    default:
        http_response_code(404);
        require 'pages/404.php';
        break;
}
?>