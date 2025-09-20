<?php 
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $subject = sanitize_input($_POST['subject'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        // TODO: Implement email sending logic
        $success_message = "Thank you for your message! We'll get back to you soon.";
    } else {
        $error_message = "Please fill in all required fields.";
    }
}

include_header('Contact Us'); 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="display-4 fw-bold text-center mb-5">Contact Us</h1>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-4">Send us a Message</h3>
                            
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <div class="invalid-feedback">Please provide your name.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <div class="invalid-feedback">Please provide a valid email.</div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-select" id="subject" name="subject">
                                        <option value="">Select a subject</option>
                                        <option value="general">General Inquiry</option>
                                        <option value="teacher">Teacher Application</option>
                                        <option value="student">Student Support</option>
                                        <option value="technical">Technical Issue</option>
                                        <option value="partnership">Partnership</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                    <div class="invalid-feedback">Please provide your message.</div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Get in Touch</h5>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-primary me-3"></i>
                                    <strong>Email</strong>
                                </div>
                                <p class="text-muted ms-4">support@educationali.com</p>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-primary me-3"></i>
                                    <strong>Support Hours</strong>
                                </div>
                                <p class="text-muted ms-4">
                                    Monday - Friday: 9:00 AM - 6:00 PM (UTC)<br>
                                    Saturday: 10:00 AM - 4:00 PM (UTC)
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-globe text-primary me-3"></i>
                                    <strong>Global Platform</strong>
                                </div>
                                <p class="text-muted ms-4">Available worldwide with multilingual support</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Quick Links</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="/teacher/signup" class="text-decoration-none">
                                        <i class="fas fa-chalkboard-teacher text-primary me-2"></i>Become a Teacher
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/student/signup" class="text-decoration-none">
                                        <i class="fas fa-user-graduate text-primary me-2"></i>Student Registration
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="/partner" class="text-decoration-none">
                                        <i class="fas fa-handshake text-primary me-2"></i>Partnership Opportunities
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>