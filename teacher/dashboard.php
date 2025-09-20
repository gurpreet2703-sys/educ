<?php 
require_auth('teacher');
include_header('Teacher Dashboard'); 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Dashboard
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
                    <i class="fas fa-plus-circle fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Create Class</h5>
                    <p class="card-text">Schedule new classes for your students.</p>
                    <a href="/teacher/profile" class="btn btn-success">Manage Profile</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-info mb-3"></i>
                    <h5 class="card-title">My Classes</h5>
                    <p class="card-text">View and manage your scheduled classes.</p>
                    <a href="#" class="btn btn-info">My Classes</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Test Series</h5>
                    <p class="card-text">Create and manage test series.</p>
                    <a href="#" class="btn btn-warning">Manage Tests</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">Earnings Overview</h6>
                </div>
                <div class="card-body">
                    <h4 class="text-success mb-2">$0.00</h4>
                    <p class="text-muted mb-0">Total earnings this month</p>
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
                                <small class="text-muted">Students</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="mb-1 text-success">0</h4>
                                <small class="text-muted">Classes</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h4 class="mb-1 text-warning">0.0</h4>
                            <small class="text-muted">Rating</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>