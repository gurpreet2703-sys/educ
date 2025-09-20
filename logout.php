<?php
require_once 'config/config.php';

// Process logout
$result = process_logout();

// Redirect to home with success message
$_SESSION['message'] = $result['message'];
$_SESSION['message_type'] = 'success';

redirect('/');
?>