<?php 
require_auth('admin');
include_header('Admin Dashboard'); 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Admin Dashboard
                </h2>
                <div class="text-muted">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">User Management</h5>
                    <p class="card-text">Manage all platform users.</p>
                    <a href="/admin/users" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chalkboard-teacher fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Teacher Approvals</h5>
                    <p class="card-text">Review teacher applications.</p>
                    <a href="/admin/teachers" class="btn btn-success">Review Teachers</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Analytics</h5>
                    <p class="card-text">View platform analytics.</p>
                    <a href="#" class="btn btn-info">View Analytics</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text">Platform configuration.</p>
                    <a href="#" class="btn btn-warning">Settings</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    // Get platform statistics
    $stats = get_platform_stats();
    ?>
    
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">Platform Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="border-end">
                                <h4 class="mb-1 text-primary"><?php echo $stats['total_users'] ?? 0; ?></h4>
                                <small class="text-muted">Total Users</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border-end">
                                <h4 class="mb-1 text-success"><?php echo $stats['total_teachers'] ?? 0; ?></h4>
                                <small class="text-muted">Teachers</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border-end">
                                <h4 class="mb-1 text-info"><?php echo $stats['total_students'] ?? 0; ?></h4>
                                <small class="text-muted">Students</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <h4 class="mb-1 text-warning"><?php echo $stats['pending_approvals'] ?? 0; ?></h4>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">Revenue</h6>
                </div>
                <div class="card-body">
                    <h4 class="text-success mb-2">$<?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></h4>
                    <p class="text-muted mb-0">Total platform revenue</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_footer(); ?>