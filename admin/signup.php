<?php include_header('Admin Registration'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
                        <h3 class="fw-bold">Admin Registration</h3>
                        <p class="text-muted">Request admin access</p>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> Admin registration requires approval from existing administrators.
                    </div>
                    
                    <form class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="fullName" required>
                            <div class="invalid-feedback">Please provide your full name.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="password" required>
                            <div class="invalid-feedback">Please provide a password.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password *</label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                            <div class="invalid-feedback">Please confirm your password.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Requested Role *</label>
                            <select class="form-select" id="role" required>
                                <option value="">Select role</option>
                                <option value="admin">Platform Administrator</option>
                                <option value="moderator">Content Moderator</option>
                                <option value="support">Support Admin</option>
                            </select>
                            <div class="invalid-feedback">Please select a role.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="justification" class="form-label">Justification *</label>
                            <textarea class="form-control" id="justification" rows="3" placeholder="Please explain why you need admin access..." required></textarea>
                            <div class="invalid-feedback">Please provide justification for admin access.</div>
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
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Submit Request
                        </button>
                        
                        <div class="text-center">
                            <p class="text-muted mb-2">Already have admin access?</p>
                            <a href="/admin/login" class="text-decoration-none">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>