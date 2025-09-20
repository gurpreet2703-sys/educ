<?php
// Database connection and utility functions for Educationali platform

/**
 * Test database connection
 */
function test_database_connection() {
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->query("SELECT COUNT(*) as table_count FROM information_schema.tables WHERE table_schema = 'public'");
        $result = $stmt->fetch();
        return [
            'success' => true,
            'table_count' => $result['table_count'],
            'message' => 'Database connection successful'
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'message' => 'Database connection failed'
        ];
    }
}

/**
 * Get all subjects
 */
function get_subjects() {
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->query("SELECT * FROM subjects ORDER BY name");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Get all languages
 */
function get_languages() {
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->query("SELECT * FROM languages ORDER BY name");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Get platform setting by key
 */
function get_platform_setting($key, $default = null) {
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT setting_value FROM platform_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

/**
 * Create a new user account
 */
function create_user($email, $password, $role, $first_name, $last_name) {
    try {
        $pdo = get_db_connection();
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'Email already exists'];
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user using RETURNING for PostgreSQL
        $stmt = $pdo->prepare("
            INSERT INTO users (email, password_hash, role, first_name, last_name) 
            VALUES (?, ?, ?, ?, ?) 
            RETURNING id
        ");
        $stmt->execute([$email, $password_hash, $role, $first_name, $last_name]);
        
        $result = $stmt->fetch();
        $user_id = $result['id'];
        
        return ['success' => true, 'user_id' => $user_id];
    } catch (Exception $e) {
        error_log("Database error in create_user: " . $e->getMessage());
        return ['success' => false, 'error' => 'Failed to create user account'];
    }
}

/**
 * Authenticate user login
 */
function authenticate_user($email, $password) {
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT id, password_hash, role, first_name, last_name, is_active FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        if (!$user['is_active']) {
            return ['success' => false, 'error' => 'Account is deactivated'];
        }
        
        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        // Remove password hash from returned data
        unset($user['password_hash']);
        
        return ['success' => true, 'user' => $user];
    } catch (Exception $e) {
        error_log("Database error in authenticate_user: " . $e->getMessage());
        return ['success' => false, 'error' => 'Authentication failed. Please try again.'];
    }
}

/**
 * Get teachers with their profiles (for teacher directory)
 */
function get_teachers_directory($subject_id = null, $language_id = null, $limit = 20, $offset = 0) {
    try {
        $pdo = get_db_connection();
        
        $where_conditions = ["t.approval_status = 'approved'"];
        $params = [];
        
        if ($subject_id) {
            $where_conditions[] = "EXISTS (SELECT 1 FROM teacher_subjects ts WHERE ts.teacher_id = t.id AND ts.subject_id = ?)";
            $params[] = $subject_id;
        }
        
        // Note: Language filtering removed temporarily - will be implemented when teacher language support is added
        // For now, language_id parameter is ignored to prevent SQL errors
        
        $where_clause = implode(' AND ', $where_conditions);
        
        $sql = "
            SELECT DISTINCT
                t.id as teacher_id,
                u.first_name, 
                u.last_name, 
                u.email,
                t.bio, 
                t.experience_years, 
                t.average_rating, 
                t.total_students, 
                t.total_classes,
                COALESCE(
                    (SELECT ARRAY_AGG(s.name) 
                     FROM teacher_subjects ts 
                     JOIN subjects s ON ts.subject_id = s.id 
                     WHERE ts.teacher_id = t.id), 
                    ARRAY[]::text[]
                ) as subjects
            FROM teachers t
            JOIN users u ON t.user_id = u.id
            WHERE $where_clause
            ORDER BY t.average_rating DESC, t.total_students DESC
            LIMIT ? OFFSET ?
        ";
        
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Database error in get_teachers_directory: " . $e->getMessage());
        return [];
    }
}

/**
 * Get platform statistics for admin dashboard
 */
function get_platform_stats() {
    try {
        $pdo = get_db_connection();
        
        $stats = [];
        
        // Total users by role
        $stmt = $pdo->query("
            SELECT role, COUNT(*) as count 
            FROM users 
            WHERE is_active = true 
            GROUP BY role
        ");
        $role_counts = $stmt->fetchAll();
        foreach ($role_counts as $role) {
            $stats['total_' . $role['role'] . 's'] = $role['count'];
        }
        
        // Total classes
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM classes");
        $stats['total_classes'] = $stmt->fetch()['count'];
        
        // Total revenue
        $stmt = $pdo->query("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = 'completed'");
        $stats['total_revenue'] = $stmt->fetch()['total'];
        
        // Pending teacher approvals
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM teachers WHERE approval_status = 'pending'");
        $stats['pending_teacher_approvals'] = $stmt->fetch()['count'];
        
        return $stats;
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Admin function to get users with filters
 */
function admin_get_users($role_filter = '', $status_filter = '', $search = '') {
    try {
        $pdo = get_db_connection();
        
        $sql = "SELECT id, first_name, last_name, email, role, is_active, created_at FROM users WHERE 1=1";
        $params = [];
        
        if (!empty($role_filter)) {
            $sql .= " AND role = ?";
            $params[] = $role_filter;
        }
        
        if (!empty($status_filter)) {
            $is_active = $status_filter === 'active' ? true : false;
            $sql .= " AND is_active = ?";
            $params[] = $is_active;
        }
        
        if (!empty($search)) {
            $sql .= " AND (LOWER(first_name || ' ' || last_name) LIKE LOWER(?) OR LOWER(email) LIKE LOWER(?))";
            $search_term = "%$search%";
            $params[] = $search_term;
            $params[] = $search_term;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Error getting users: " . $e->getMessage());
        return [];
    }
}

/**
 * Admin function to get teachers with filters
 */
function admin_get_teachers($status_filter = 'pending', $search = '') {
    try {
        $pdo = get_db_connection();
        
        $sql = "
            SELECT 
                u.id, u.first_name, u.last_name, u.email, u.created_at,
                t.id as teacher_id, t.bio, t.qualifications, t.experience_years, 
                t.approval_status, t.is_verified, t.rejected_reason
            FROM users u 
            JOIN teachers t ON u.id = t.user_id 
            WHERE u.role = 'teacher'
        ";
        $params = [];
        
        if (!empty($status_filter) && $status_filter !== 'all') {
            $sql .= " AND t.approval_status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $sql .= " AND (LOWER(u.first_name || ' ' || u.last_name) LIKE LOWER(?) OR LOWER(u.email) LIKE LOWER(?) OR LOWER(t.qualifications) LIKE LOWER(?))";
            $search_term = "%$search%";
            $params[] = $search_term;
            $params[] = $search_term;
            $params[] = $search_term;
        }
        
        $sql .= " ORDER BY t.created_at DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Error getting teachers: " . $e->getMessage());
        return [];
    }
}

/**
 * Admin function to toggle user active status
 */
function admin_toggle_user_status($user_id) {
    try {
        $pdo = get_db_connection();
        
        // Get current status
        $stmt = $pdo->prepare("SELECT is_active, email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }
        
        $new_status = !$user['is_active'];
        
        // Update status
        $stmt = $pdo->prepare("UPDATE users SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $user_id]);
        
        $action = $new_status ? 'activated' : 'deactivated';
        return ['success' => true, 'message' => "User {$user['email']} has been $action successfully."];
    } catch (Exception $e) {
        error_log("Error toggling user status: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to update user status.'];
    }
}

/**
 * Admin function to delete user
 */
function admin_delete_user($user_id) {
    try {
        $pdo = get_db_connection();
        
        // Get user email for confirmation
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }
        
        // Delete user (cascade should handle related records)
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        
        return ['success' => true, 'message' => "User {$user['email']} has been deleted successfully."];
    } catch (Exception $e) {
        error_log("Error deleting user: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to delete user.'];
    }
}

/**
 * Admin function to approve teacher
 */
function admin_approve_teacher($teacher_id) {
    try {
        $pdo = get_db_connection();
        
        // Get teacher info
        $stmt = $pdo->prepare("
            SELECT u.email, u.first_name, u.last_name 
            FROM teachers t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = ?
        ");
        $stmt->execute([$teacher_id]);
        $teacher = $stmt->fetch();
        
        if (!$teacher) {
            return ['success' => false, 'message' => 'Teacher not found.'];
        }
        
        // Update approval status
        $stmt = $pdo->prepare("UPDATE teachers SET approval_status = 'approved', approved_at = NOW() WHERE id = ?");
        $stmt->execute([$teacher_id]);
        
        return ['success' => true, 'message' => "Teacher {$teacher['first_name']} {$teacher['last_name']} has been approved successfully."];
    } catch (Exception $e) {
        error_log("Error approving teacher: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to approve teacher.'];
    }
}

/**
 * Admin function to reject teacher
 */
function admin_reject_teacher($teacher_id, $rejection_reason) {
    try {
        $pdo = get_db_connection();
        
        // Get teacher info
        $stmt = $pdo->prepare("
            SELECT u.email, u.first_name, u.last_name 
            FROM teachers t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = ?
        ");
        $stmt->execute([$teacher_id]);
        $teacher = $stmt->fetch();
        
        if (!$teacher) {
            return ['success' => false, 'message' => 'Teacher not found.'];
        }
        
        // Update approval status
        $stmt = $pdo->prepare("UPDATE teachers SET approval_status = 'rejected', rejected_reason = ?, approved_at = NOW() WHERE id = ?");
        $stmt->execute([$rejection_reason, $teacher_id]);
        
        return ['success' => true, 'message' => "Teacher {$teacher['first_name']} {$teacher['last_name']} has been rejected."];
    } catch (Exception $e) {
        error_log("Error rejecting teacher: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to reject teacher.'];
    }
}

/**
 * Admin function to toggle teacher verification
 */
function admin_toggle_teacher_verification($teacher_id) {
    try {
        $pdo = get_db_connection();
        
        // Get current verification status
        $stmt = $pdo->prepare("
            SELECT t.is_verified, u.first_name, u.last_name 
            FROM teachers t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = ?
        ");
        $stmt->execute([$teacher_id]);
        $teacher = $stmt->fetch();
        
        if (!$teacher) {
            return ['success' => false, 'message' => 'Teacher not found.'];
        }
        
        $new_status = !$teacher['is_verified'];
        
        // Update verification status
        $stmt = $pdo->prepare("UPDATE teachers SET is_verified = ? WHERE id = ?");
        $stmt->execute([$new_status, $teacher_id]);
        
        $action = $new_status ? 'verified' : 'verification removed from';
        return ['success' => true, 'message' => "Teacher {$teacher['first_name']} {$teacher['last_name']} has been $action."];
    } catch (Exception $e) {
        error_log("Error toggling teacher verification: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to update teacher verification.'];
    }
}
?>