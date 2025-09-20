<?php
// Authentication processing for Educationali platform


/**
 * Process login form submission
 */
function process_login() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }
    
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        return ['success' => false, 'message' => 'Security token validation failed. Please try again.'];
    }
    
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate input
    if (empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'Please fill in all required fields.'];
    }
    
    // Authenticate user
    $auth_result = authenticate_user($email, $password);
    
    if (!$auth_result['success']) {
        return ['success' => false, 'message' => $auth_result['error']];
    }
    
    $user = $auth_result['user'];
    
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);
    
    // Create session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    
    // TODO: Implement secure remember me functionality
    // Current implementation disabled due to security vulnerabilities
    if ($remember) {
        // Placeholder for future secure implementation
        error_log("Remember me functionality temporarily disabled for security");
    }
    
    // Log successful login
    error_log("User logged in: {$user['email']} (Role: {$user['role']})");
    
    return ['success' => true, 'message' => 'Login successful!', 'user' => $user];
}

/**
 * Process signup form submission
 */
function process_signup() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }
    
    // Validate CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        return ['success' => false, 'message' => 'Security token validation failed. Please try again.'];
    }
    
    $first_name = sanitize_input($_POST['first_name'] ?? '');
    $last_name = sanitize_input($_POST['last_name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = sanitize_input($_POST['role'] ?? '');
    
    // Validate input
    $validation_errors = [];
    
    if (empty($first_name)) $validation_errors[] = 'First name is required.';
    if (empty($last_name)) $validation_errors[] = 'Last name is required.';
    if (empty($email)) $validation_errors[] = 'Email is required.';
    if (empty($password)) $validation_errors[] = 'Password is required.';
    if (empty($role)) $validation_errors[] = 'Role is required.';
    if ($password !== $confirm_password) $validation_errors[] = 'Passwords do not match.';
    if (strlen($password) < 8) $validation_errors[] = 'Password must be at least 8 characters long.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $validation_errors[] = 'Please enter a valid email address.';
    if (!in_array($role, ['admin', 'teacher', 'student'])) $validation_errors[] = 'Invalid role selected.';
    
    if (!empty($validation_errors)) {
        return ['success' => false, 'message' => implode(' ', $validation_errors)];
    }
    
    // Create user account
    $create_result = create_user($email, $password, $role, $first_name, $last_name);
    
    if (!$create_result['success']) {
        return ['success' => false, 'message' => $create_result['error']];
    }
    
    $user_id = $create_result['user_id'];
    
    // Create role-specific profile
    $profile_result = create_role_profile($user_id, $role, $_POST);
    
    if (!$profile_result['success']) {
        error_log("Failed to create profile for user $user_id: " . $profile_result['error']);
        // Continue anyway since user was created
    }
    
    // Log successful registration
    error_log("New user registered: $email (Role: $role)");
    
    return ['success' => true, 'message' => 'Account created successfully! Please log in.', 'user_id' => $user_id];
}

/**
 * Create role-specific profile after user registration
 */
function create_role_profile($user_id, $role, $form_data) {
    try {
        $pdo = get_db_connection();
        
        switch ($role) {
            case 'teacher':
                $bio = sanitize_input($form_data['bio'] ?? '');
                $qualifications = sanitize_input($form_data['qualifications'] ?? '');
                $experience_years = intval($form_data['experience_years'] ?? 0);
                $subjects = $form_data['subjects'] ?? [];
                
                // Create teacher profile
                $stmt = $pdo->prepare("
                    INSERT INTO teachers (user_id, bio, qualifications, experience_years) 
                    VALUES (?, ?, ?, ?) RETURNING id
                ");
                $stmt->execute([$user_id, $bio, $qualifications, $experience_years]);
                $teacher = $stmt->fetch();
                $teacher_id = $teacher['id'];
                
                // Add subjects if provided
                if (!empty($subjects) && is_array($subjects)) {
                    foreach ($subjects as $subject_id) {
                        $subject_id = intval($subject_id);
                        if ($subject_id > 0) {
                            $stmt = $pdo->prepare("
                                INSERT INTO teacher_subjects (teacher_id, subject_id) 
                                VALUES (?, ?) ON CONFLICT DO NOTHING
                            ");
                            $stmt->execute([$teacher_id, $subject_id]);
                        }
                    }
                }
                break;
                
            case 'student':
                $education_level = sanitize_input($form_data['education_level'] ?? '');
                $preferred_language_id = intval($form_data['preferred_language_id'] ?? 1);
                $newsletter = isset($form_data['newsletter']);
                $interests = $form_data['interests'] ?? [];
                
                // Create student profile
                $stmt = $pdo->prepare("
                    INSERT INTO students (user_id, education_level, preferred_language_id, newsletter_subscribed) 
                    VALUES (?, ?, ?, ?) RETURNING id
                ");
                $stmt->execute([$user_id, $education_level, $preferred_language_id, $newsletter]);
                $student = $stmt->fetch();
                $student_id = $student['id'];
                
                // Add interests if provided
                if (!empty($interests) && is_array($interests)) {
                    foreach ($interests as $subject_id) {
                        $subject_id = intval($subject_id);
                        if ($subject_id > 0) {
                            $stmt = $pdo->prepare("
                                INSERT INTO student_interests (student_id, subject_id) 
                                VALUES (?, ?) ON CONFLICT DO NOTHING
                            ");
                            $stmt->execute([$student_id, $subject_id]);
                        }
                    }
                }
                break;
                
            case 'admin':
                // No additional profile needed for admin
                break;
        }
        
        return ['success' => true];
    } catch (Exception $e) {
        error_log("Error creating profile for user $user_id: " . $e->getMessage());
        return ['success' => false, 'error' => 'Failed to create user profile'];
    }
}

/**
 * Process logout
 */
function process_logout() {
    // Log logout
    if (isset($_SESSION['user_email'])) {
        error_log("User logged out: " . $_SESSION['user_email']);
    }
    
    // Clear session
    session_unset();
    session_destroy();
    
    // Clear remember me cookie
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }
    
    return ['success' => true, 'message' => 'Successfully logged out.'];
}

/**
 * Get redirect URL based on user role
 */
function get_role_redirect_url($role) {
    switch ($role) {
        case 'admin':
            return '/admin/dashboard';
        case 'teacher':
            return '/teacher/dashboard';
        case 'student':
            return '/student/dashboard';
        default:
            return '/';
    }
}

/**
 * Require authentication (redirect if not logged in)
 */
function require_auth($required_role = null) {
    if (!is_logged_in()) {
        redirect('/student/login');
    }
    
    if ($required_role && get_user_role() !== $required_role) {
        redirect('/403'); // Forbidden
    }
}

/**
 * Check remember me cookie and auto-login (DISABLED FOR SECURITY)
 * TODO: Implement secure remember me with server-side tokens
 */
function check_remember_me() {
    // Function disabled due to security vulnerabilities
    // Future implementation should use:
    // - Random selector + validator pairs
    // - Server-side token storage with expiry
    // - Secure cookie flags (HttpOnly, SameSite, Secure)
    // - Token rotation on use
    return;
}
?>