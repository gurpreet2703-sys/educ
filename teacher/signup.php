<?php 
// Process signup form submission
$signup_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['role'] = 'teacher'; // Set role for teachers
    $signup_result = process_signup();
    
    if ($signup_result['success']) {
        $_SESSION['message'] = $signup_result['message'];
        $_SESSION['message_type'] = 'success';
        redirect('/teacher/login');
    }
}

include_header('Teacher Registration'); 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-graduation-cap fa-3x text-success mb-3"></i>
                        <h3 class="fw-bold">Become a Teacher</h3>
                        <p class="text-muted">Join our global network of expert educators</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Registration Fee:</strong> $455 (includes verification and platform access)
                    </div>
                    
                    <?php if ($signup_result && !$signup_result['success']): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo htmlspecialchars($signup_result['message']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
                                <div class="invalid-feedback">Please provide your first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                                <div class="invalid-feedback">Please provide your last name.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">Please provide a password.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                                <div class="invalid-feedback">Please confirm your password.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subjects" class="form-label">Subject Expertise *</label>
                            <select class="form-select" id="subjects" name="subjects[]" multiple required>
                                <option value="mathematics">Mathematics</option>
                                <option value="physics">Physics</option>
                                <option value="chemistry">Chemistry</option>
                                <option value="biology">Biology</option>
                                <option value="english">English</option>
                                <option value="computer-science">Computer Science</option>
                                <option value="economics">Economics</option>
                                <option value="history">History</option>
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple subjects</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="qualifications" class="form-label">Qualifications *</label>
                            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" placeholder="Describe your educational background and teaching qualifications..." required><?php echo htmlspecialchars($_POST['qualifications'] ?? ''); ?></textarea>
                            <div class="invalid-feedback">Please provide your qualifications.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="experience" class="form-label">Teaching Experience</label>
                            <select class="form-select" id="experience">
                                <option value="">Select experience level</option>
                                <option value="0-1">0-1 years</option>
                                <option value="2-5">2-5 years</option>
                                <option value="6-10">6-10 years</option>
                                <option value="10+">10+ years</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="/terms" target="_blank">Terms & Conditions</a> 
                                    and <a href="/privacy" target="_blank">Privacy Policy</a> *
                                </label>
                                <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Register & Pay $455
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-2">Already have an account?</p>
                            <a href="/teacher/login" class="text-decoration-none">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>