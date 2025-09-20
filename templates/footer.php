    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-graduation-cap me-2"></i><?php echo SITE_NAME; ?></h5>
                    <p class="text-muted">Global educational platform connecting students with expert teachers worldwide.</p>
                </div>
                <div class="col-md-2">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="/about" class="text-muted text-decoration-none">About Us</a></li>
                        <li><a href="/teachers" class="text-muted text-decoration-none">Find Teachers</a></li>
                        <li><a href="/contact" class="text-muted text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>For Teachers</h6>
                    <ul class="list-unstyled">
                        <li><a href="/teacher/signup" class="text-muted text-decoration-none">Join as Teacher</a></li>
                        <li><a href="/teacher/login" class="text-muted text-decoration-none">Teacher Login</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>For Students</h6>
                    <ul class="list-unstyled">
                        <li><a href="/student/signup" class="text-muted text-decoration-none">Student Registration</a></li>
                        <li><a href="/student/login" class="text-muted text-decoration-none">Student Login</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="/privacy" class="text-muted text-decoration-none">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-muted text-decoration-none">Terms & Conditions</a></li>
                        <li><a href="/refund" class="text-muted text-decoration-none">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">Global Platform • Live Classes • Multilingual Support</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/js/main.js"></script>
    
    <?php if (!empty($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>