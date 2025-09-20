<?php include_header('Global Educational Platform'); ?>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Learn from Expert Teachers
                        <span class="text-warning">Worldwide</span>
                    </h1>
                    <p class="lead mb-4">
                        Join our global educational platform featuring live interactive classes, 
                        comprehensive test series, and multilingual support. Connect with certified 
                        teachers for personalized learning experiences.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/student/signup" class="btn btn-warning btn-lg">
                            <i class="fas fa-user-graduate me-2"></i>Start Learning
                        </a>
                        <a href="/teacher/signup" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Become a Teacher
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image">
                        <i class="fas fa-graduation-cap display-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold mb-3">Why Choose Educationali?</h2>
                    <p class="lead text-muted">Experience the future of education with our innovative platform</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-globe"></i>
                            </div>
                            <h5 class="fw-bold">Global Platform</h5>
                            <p class="text-muted">Connect with expert teachers from around the world, bringing diverse perspectives and expertise to your learning journey.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-video"></i>
                            </div>
                            <h5 class="fw-bold">Live Interactive Classes</h5>
                            <p class="text-muted">Attend live classes with 1:1, 1:10, or 1:Many formats. Interactive sessions with real-time doubt clearing and engagement.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h5 class="fw-bold">Comprehensive Test Series</h5>
                            <p class="text-muted">Practice with extensive test series, mock tests, and previous year papers with detailed analytics and All India Rankings.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-language"></i>
                            </div>
                            <h5 class="fw-bold">Multilingual Support</h5>
                            <p class="text-muted">Learn in your preferred language with our multilingual platform supporting diverse educational needs globally.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="fw-bold">Expert Teachers</h5>
                            <p class="text-muted">Learn from verified and certified teachers with proven expertise in their subjects and excellent student ratings.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="fw-bold">Performance Analytics</h5>
                            <p class="text-muted">Track your progress with detailed analytics, performance insights, and personalized recommendations for improvement.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h2 class="fw-bold mb-3">Ready to Start Your Learning Journey?</h2>
                    <p class="lead text-muted mb-4">Join thousands of students and teachers already using our platform</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="/teachers" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Browse Teachers
                        </a>
                        <a href="/partner" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-handshake me-2"></i>Partner With Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_footer(); ?>