<?php include_header('Access Forbidden'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="mb-4">
                <i class="fas fa-ban fa-5x text-danger mb-3"></i>
                <h1 class="display-4 fw-bold">403</h1>
                <h2 class="h4 text-muted">Access Forbidden</h2>
            </div>
            
            <p class="lead mb-4">
                You don't have permission to access this resource.
            </p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Go Home
                </a>
                <?php if (is_logged_in()): ?>
                    <a href="/<?php echo get_user_role(); ?>/dashboard" class="btn btn-outline-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                <?php else: ?>
                    <a href="/student/login" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>