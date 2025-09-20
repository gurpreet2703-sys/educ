<?php 
// Process signup form submission
$signup_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['role'] = 'student'; // Set role for students
    $signup_result = process_signup();
    
    if ($signup_result['success']) {
        $_SESSION['message'] = $signup_result['message'];
        $_SESSION['message_type'] = 'success';
        redirect('/student/login');
    }
}

include_header('Student Registration'); 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-book-open fa-3x text-info mb-3"></i>
                        <h3 class="fw-bold">Join as Student</h3>
                        <p class="text-muted">Start your learning journey with expert teachers</p>
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
                            <label for="grade" class="form-label">Education Level</label>
                            <select class="form-select" id="grade">
                                <option value="">Select your education level</option>
                                <option value="elementary">Elementary School</option>
                                <option value="middle">Middle School</option>
                                <option value="high">High School</option>
                                <option value="undergraduate">Undergraduate</option>
                                <option value="graduate">Graduate</option>
                                <option value="professional">Professional/Adult Learning</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="interests" class="form-label">Learning Interests</label>
                            <select class="form-select" id="interests" multiple>
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
                            <label for="language" class="form-label">Preferred Language</label>
                            <select class="form-select" id="language">
                                <option value="english">English</option>
                                <option value="spanish">Spanish</option>
                                <option value="french">French</option>
                                <option value="german">German</option>
                                <option value="mandarin">Mandarin</option>
                                <option value="hindi">Hindi</option>
                                <option value="arabic">Arabic</option>
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
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Subscribe to our newsletter for learning tips and updates
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-info btn-lg w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-2">Already have an account?</p>
                            <a href="/student/login" class="text-decoration-none">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>