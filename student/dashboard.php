<?php 
require_auth('student');
include_header('Student Dashboard'); 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>Student Dashboard
                </h2>
                <div class="text-muted">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chalkboard-teacher fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Browse Teachers</h5>
                    <p class="card-text">Find expert teachers for your subjects of interest.</p>
                    <a href="/teachers" class="btn btn-info">Browse Teachers</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">My Classes</h5>
                    <p class="card-text">View and manage your scheduled classes.</p>
                    <a href="#" class="btn btn-success">My Classes</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Test Series</h5>
                    <p class="card-text">Practice with comprehensive test series.</p>
                    <a href="#" class="btn btn-warning">Take Tests</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">No recent activity to display.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="mb-1 text-info">0</h4>
                                <small class="text-muted">Classes</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="mb-1 text-success">0</h4>
                                <small class="text-muted">Tests</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h4 class="mb-1 text-warning">0</h4>
                            <small class="text-muted">Hours</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>