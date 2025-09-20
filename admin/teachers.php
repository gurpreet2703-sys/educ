<?php 
require_auth('admin');

// Process teacher approval actions
$action_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $action_result = ['success' => false, 'message' => 'Security token validation failed.'];
    } else {
        $action = $_POST['action'] ?? '';
        $teacher_id = intval($_POST['teacher_id'] ?? 0);
        
        if ($action === 'approve' && $teacher_id > 0) {
            $action_result = admin_approve_teacher($teacher_id);
        } elseif ($action === 'reject' && $teacher_id > 0) {
            $rejection_reason = $_POST['rejection_reason'] ?? '';
            $action_result = admin_reject_teacher($teacher_id, $rejection_reason);
        } elseif ($action === 'toggle_verification' && $teacher_id > 0) {
            $action_result = admin_toggle_teacher_verification($teacher_id);
        }
    }
}

// Get filters
$status_filter = $_GET['status'] ?? 'pending';
$search = $_GET['search'] ?? '';

// Get teachers with filters
$teachers = admin_get_teachers($status_filter, $search);

include_header('Teacher Management');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Management
                </h2>
                <a href="/admin/dashboard" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <?php if ($action_result): ?>
        <div class="alert alert-<?php echo $action_result['success'] ? 'success' : 'danger'; ?> alert-dismissible fade show">
            <i class="fas fa-<?php echo $action_result['success'] ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
            <?php echo htmlspecialchars($action_result['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending Approval</option>
                        <option value="approved" <?php echo $status_filter === 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo $status_filter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All Teachers</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label">Search Teachers</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Name, email, or qualifications..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Teachers Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Teachers (<?php echo count($teachers); ?> found)
            </h5>
        </div>
        <div class="card-body p-0">
            <?php if (empty($teachers)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No teachers found</h5>
                    <p class="text-muted">Try adjusting your search criteria.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Teacher</th>
                                <th>Experience</th>
                                <th>Status</th>
                                <th>Applied</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-user-tie fa-2x text-<?php echo get_teacher_status_color($teacher['approval_status']); ?>"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?php echo htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']); ?></div>
                                                <div class="text-muted small"><?php echo htmlspecialchars($teacher['email']); ?></div>
                                                <?php if ($teacher['is_verified']): ?>
                                                    <span class="badge bg-success small mt-1">
                                                        <i class="fas fa-check-circle me-1"></i>Verified
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div class="fw-bold"><?php echo $teacher['experience_years']; ?> years</div>
                                            <div class="text-muted"><?php echo htmlspecialchars(substr($teacher['qualifications'], 0, 50)); ?><?php echo strlen($teacher['qualifications']) > 50 ? '...' : ''; ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo get_teacher_status_color($teacher['approval_status']); ?> text-capitalize">
                                            <?php echo htmlspecialchars($teacher['approval_status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        <?php echo date('M j, Y', strtotime($teacher['created_at'])); ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    onclick="viewTeacher(<?php echo $teacher['teacher_id']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <?php if ($teacher['approval_status'] === 'pending'): ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                                                    <input type="hidden" name="action" value="approve">
                                                    <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-success"
                                                            onclick="return confirm('Are you sure you want to approve this teacher?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="rejectTeacher(<?php echo $teacher['teacher_id']; ?>)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if ($teacher['approval_status'] === 'approved'): ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                                                    <input type="hidden" name="action" value="toggle_verification">
                                                    <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-<?php echo $teacher['is_verified'] ? 'warning' : 'success'; ?>"
                                                            onclick="return confirm('Are you sure you want to <?php echo $teacher['is_verified'] ? 'remove verification from' : 'verify'; ?> this teacher?')">
                                                        <i class="fas fa-<?php echo $teacher['is_verified'] ? 'shield-alt' : 'certificate'; ?>"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Teacher Details Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teacher Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="teacherModalBody">
                <div class="text-center py-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Teacher Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                    <input type="hidden" name="action" value="reject">
                    <input type="hidden" id="reject_teacher_id" name="teacher_id" value="">
                    
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection *</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                                  rows="4" placeholder="Please provide a clear reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Teacher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function viewTeacher(teacherId) {
    const modal = new bootstrap.Modal(document.getElementById('teacherModal'));
    modal.show();
    
    // Load teacher details via AJAX (placeholder for now)
    document.getElementById('teacherModalBody').innerHTML = `
        <div class="text-center py-3">
            <i class="fas fa-chalkboard-teacher fa-3x text-success mb-3"></i>
            <h5>Teacher Details</h5>
            <p class="text-muted">Teacher ID: ${teacherId}</p>
            <p class="text-muted">Detailed teacher information including bio, qualifications, demo videos, and documents will be implemented in the next phase.</p>
        </div>
    `;
}

function rejectTeacher(teacherId) {
    document.getElementById('reject_teacher_id').value = teacherId;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}
</script>

<?php include_footer(); ?>