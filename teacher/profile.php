<?php 
require_auth('teacher');

// Get teacher profile
$teacher_profile = get_teacher_profile($_SESSION['user_id']);
if (!$teacher_profile) {
    $_SESSION['message'] = 'Teacher profile not found. Please contact support.';
    $_SESSION['message_type'] = 'error';
    redirect('/teacher/dashboard');
}

// Process profile update
$update_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $update_result = ['success' => false, 'message' => 'Security token validation failed.'];
    } else {
        $update_result = update_teacher_profile($_SESSION['user_id'], $_POST);
    }
}

include_header('Teacher Profile');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>Teacher Profile
                </h2>
                <a href="/teacher/dashboard" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <?php if ($update_result): ?>
        <div class="alert alert-<?php echo $update_result['success'] ? 'success' : 'danger'; ?> alert-dismissible fade show">
            <i class="fas fa-<?php echo $update_result['success'] ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
            <?php echo htmlspecialchars($update_result['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Profile Status Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">
                                <i class="fas fa-info-circle me-2"></i>Profile Status
                            </h5>
                            <p class="mb-0 text-muted">
                                Your teacher application is currently 
                                <span class="badge bg-<?php echo get_teacher_status_color($teacher_profile['approval_status']); ?> ms-1">
                                    <?php echo ucfirst($teacher_profile['approval_status']); ?>
                                </span>
                            </p>
                            <?php if ($teacher_profile['approval_status'] === 'rejected' && $teacher_profile['rejected_reason']): ?>
                                <div class="mt-2">
                                    <small class="text-danger">
                                        <strong>Rejection Reason:</strong> <?php echo htmlspecialchars($teacher_profile['rejected_reason']); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <?php if ($teacher_profile['is_verified']): ?>
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>Verified Teacher
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Profile Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="<?php echo htmlspecialchars($_POST['first_name'] ?? $teacher_profile['first_name']); ?>" required>
                                <div class="invalid-feedback">Please provide your first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="<?php echo htmlspecialchars($_POST['last_name'] ?? $teacher_profile['last_name']); ?>" required>
                                <div class="invalid-feedback">Please provide your last name.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($teacher_profile['email']); ?>" disabled>
                            <small class="text-muted">Email cannot be changed. Contact support if needed.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" 
                                      placeholder="Tell students about your teaching philosophy and experience..."><?php echo htmlspecialchars($_POST['bio'] ?? $teacher_profile['bio']); ?></textarea>
                            <small class="text-muted">This will be visible to students searching for teachers.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="qualifications" class="form-label">Qualifications *</label>
                            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" 
                                      placeholder="Describe your educational background and teaching qualifications..." required><?php echo htmlspecialchars($_POST['qualifications'] ?? $teacher_profile['qualifications']); ?></textarea>
                            <div class="invalid-feedback">Please provide your qualifications.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="experience_years" class="form-label">Years of Teaching Experience *</label>
                            <select class="form-select" id="experience_years" name="experience_years" required>
                                <option value="">Select experience level</option>
                                <?php for ($i = 0; $i <= 30; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo (($_POST['experience_years'] ?? $teacher_profile['experience_years']) == $i) ? 'selected' : ''; ?>>
                                        <?php echo $i; ?> year<?php echo $i != 1 ? 's' : ''; ?>
                                    </option>
                                <?php endfor; ?>
                                <option value="30+" <?php echo (($_POST['experience_years'] ?? $teacher_profile['experience_years']) == '30+') ? 'selected' : ''; ?>>30+ years</option>
                            </select>
                            <div class="invalid-feedback">Please select your experience level.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Subject Expertise</label>
                            <div class="border rounded p-3">
                                <?php 
                                $subjects = get_subjects();
                                $teacher_subjects = get_teacher_subjects($teacher_profile['teacher_id']);
                                $selected_subjects = array_column($teacher_subjects, 'subject_id');
                                ?>
                                <div class="row">
                                    <?php foreach ($subjects as $subject): ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       id="subject_<?php echo $subject['id']; ?>" 
                                                       name="subjects[]" value="<?php echo $subject['id']; ?>"
                                                       <?php echo in_array($subject['id'], $selected_subjects) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="subject_<?php echo $subject['id']; ?>">
                                                    <?php echo htmlspecialchars($subject['name']); ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <small class="text-muted">Select all subjects you can teach effectively.</small>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Teaching Stats
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Classes</span>
                        <span class="fw-bold">0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Active Students</span>
                        <span class="fw-bold">0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">This Month Earnings</span>
                        <span class="fw-bold text-success">$0.00</span>
                    </div>
                </div>
            </div>
            
            <!-- Profile Completion -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">
                        <i class="fas fa-tasks me-2"></i>Profile Completion
                    </h6>
                </div>
                <div class="card-body">
                    <?php 
                    $completion_items = [
                        'Bio written' => !empty($teacher_profile['bio']),
                        'Qualifications added' => !empty($teacher_profile['qualifications']),
                        'Experience set' => !empty($teacher_profile['experience_years']),
                        'Subjects selected' => !empty($teacher_subjects)
                    ];
                    $completed = array_filter($completion_items);
                    $completion_percentage = count($completed) / count($completion_items) * 100;
                    ?>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Completion</small>
                            <small class="text-muted"><?php echo round($completion_percentage); ?>%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: <?php echo $completion_percentage; ?>%"></div>
                        </div>
                    </div>
                    
                    <?php foreach ($completion_items as $item => $completed): ?>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-<?php echo $completed ? 'check-circle text-success' : 'circle text-muted'; ?> me-2"></i>
                            <span class="<?php echo $completed ? 'text-success' : 'text-muted'; ?>"><?php echo $item; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>