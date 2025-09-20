<?php include_header('Page Not Found'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="py-5">
                <h1 class="display-1 fw-bold text-primary">404</h1>
                <h2 class="fw-bold mb-3">Page Not Found</h2>
                <p class="lead text-muted mb-4">
                    Sorry, the page you're looking for doesn't exist or has been moved.
                </p>
                
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="/" class="btn btn-primary btn-lg">
                        <i class="fas fa-home me-2"></i>Go Home
                    </a>
                    <a href="/teachers" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Browse Teachers
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>