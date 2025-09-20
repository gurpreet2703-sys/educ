<?php include_header('Find Teachers'); ?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center mb-3">Find Expert Teachers</h1>
            <p class="lead text-center text-muted mb-5">
                Browse our global network of verified teachers and find the perfect match for your learning needs
            </p>
        </div>
    </div>
    
    <!-- Search and Filter Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label for="subjectFilter" class="form-label">Subject</label>
                            <select class="form-select" id="subjectFilter">
                                <option value="">All Subjects</option>
                                <option value="mathematics">Mathematics</option>
                                <option value="physics">Physics</option>
                                <option value="chemistry">Chemistry</option>
                                <option value="biology">Biology</option>
                                <option value="english">English</option>
                                <option value="computer-science">Computer Science</option>
                                <option value="economics">Economics</option>
                                <option value="history">History</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="languageFilter" class="form-label">Language</label>
                            <select class="form-select" id="languageFilter">
                                <option value="">All Languages</option>
                                <option value="english">English</option>
                                <option value="spanish">Spanish</option>
                                <option value="french">French</option>
                                <option value="german">German</option>
                                <option value="mandarin">Mandarin</option>
                                <option value="hindi">Hindi</option>
                                <option value="arabic">Arabic</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control search-input" id="searchInput" placeholder="Search teachers..." data-target=".teacher-card">
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-primary w-100" onclick="filterTeachers()">
                                <i class="fas fa-search me-2"></i>Search Teachers
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Teachers Grid -->
    <div class="row g-4" id="teachersGrid">
        <!-- Sample Teacher Cards - In real implementation, these would be populated from database -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 teacher-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Dr. Sarah Johnson</h5>
                            <div class="text-warning small">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-muted ms-1">(4.9) • 150+ students</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-success me-1">Mathematics</span>
                        <span class="badge bg-info me-1">Physics</span>
                        <span class="badge bg-warning">English</span>
                    </div>
                    
                    <p class="text-muted small mb-3">
                        PhD in Mathematics with 10+ years of teaching experience. Specializes in calculus, algebra, and exam preparation.
                    </p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <small class="text-muted d-block">Experience</small>
                            <strong>10+ Years</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Classes</small>
                            <strong>500+</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Language</small>
                            <strong>English</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-play me-1"></i>Watch Demo
                        </button>
                        <button class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-calendar me-1"></i>Book Class
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 teacher-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Prof. Michael Chen</h5>
                            <div class="text-warning small">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="text-muted ms-1">(4.7) • 200+ students</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-danger me-1">Chemistry</span>
                        <span class="badge bg-warning me-1">Biology</span>
                        <span class="badge bg-secondary">Science</span>
                    </div>
                    
                    <p class="text-muted small mb-3">
                        Master's in Chemistry with expertise in organic chemistry and biochemistry. Passionate about interactive learning.
                    </p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <small class="text-muted d-block">Experience</small>
                            <strong>8+ Years</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Classes</small>
                            <strong>350+</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Language</small>
                            <strong>English</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-play me-1"></i>Watch Demo
                        </button>
                        <button class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-calendar me-1"></i>Book Class
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100 teacher-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Ms. Emily Rodriguez</h5>
                            <div class="text-warning small">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-muted ms-1">(5.0) • 120+ students</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary me-1">Computer Science</span>
                        <span class="badge bg-info me-1">Programming</span>
                        <span class="badge bg-dark">Python</span>
                    </div>
                    
                    <p class="text-muted small mb-3">
                        Software engineer turned educator. Specializes in programming languages, algorithms, and data structures.
                    </p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <small class="text-muted d-block">Experience</small>
                            <strong>6+ Years</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Classes</small>
                            <strong>280+</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Language</small>
                            <strong>English</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-play me-1"></i>Watch Demo
                        </button>
                        <button class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-calendar me-1"></i>Book Class
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action for Students -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body text-center p-5">
                    <h3 class="fw-bold mb-3">Ready to Start Learning?</h3>
                    <p class="lead mb-4">Join thousands of students already learning with our expert teachers</p>
                    <a href="/student/signup" class="btn btn-warning btn-lg">
                        <i class="fas fa-user-graduate me-2"></i>Register as Student
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action for Teachers -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body text-center p-4">
                    <h5 class="fw-bold mb-2">Are you an expert teacher?</h5>
                    <p class="text-muted mb-3">Join our platform and start teaching students from around the world</p>
                    <a href="/teacher/signup" class="btn btn-outline-primary">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Become a Teacher
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterTeachers() {
    // This would be implemented with actual filtering logic
    showAlert('Filter functionality will be implemented with database integration', 'info');
}
</script>

<?php include_footer(); ?>