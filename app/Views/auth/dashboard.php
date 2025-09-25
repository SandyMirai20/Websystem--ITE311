<?= $this->extend('templates/header'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Welcome, <?= esc($user['name']); ?>!</h2>
                    <p class="mb-0">Role: <span class="badge bg-primary"><?= esc(ucfirst($user['role'])); ?></span></p>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($user['role'] === 'admin') : ?>
                        <!-- Admin Dashboard -->
                        <div class="admin-dashboard">
                            <h3>Admin Dashboard</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card text-white bg-primary mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Manage Users</h5>
                                            <p class="card-text">View and manage all users in the system.</p>
                                            <a href="/admin/users" class="btn btn-light">Go to Users</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white bg-success mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">System Settings</h5>
                                            <p class="card-text">Configure system settings and preferences.</p>
                                            <a href="/admin/settings" class="btn btn-light">Go to Settings</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-white bg-info mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Reports</h5>
                                            <p class="card-text">View system reports and analytics.</p>
                                            <a href="/admin/reports" class="btn btn-light">View Reports</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($user['role'] === 'teacher') : ?>
                        <!-- Teacher Dashboard -->
                        <div class="teacher-dashboard">
                            <h3>Teacher Dashboard</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-white bg-primary mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">My Courses</h5>
                                            <p class="card-text">Manage your courses and lessons.</p>
                                            <a href="/teacher/courses" class="btn btn-light">View Courses</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-white bg-success mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Student Progress</h5>
                                            <p class="card-text">Track your students' progress and grades.</p>
                                            <a href="/teacher/progress" class="btn btn-light">View Progress</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else : ?>
                        <!-- Student Dashboard -->
                        <div class="student-dashboard">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3><i class="fas fa-user-graduate me-2"></i>Student Dashboard</h3>
                                <div class="last-login text-muted">
                                    <small>Last login: <?= !empty($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'First login' ?></small>
                                </div>
                            </div>
                            
                            <?php if (session()->getFlashdata('welcome')): ?>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <?= session()->getFlashdata('welcome') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                                    <i class="fas fa-book text-primary fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Enrolled Courses</h6>
                                                    <h2 class="mb-0"><?= $enrolled_courses ?? 0 ?></h2>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-0">Continue learning from where you left off.</p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 pt-0">
                                            <a href="<?= site_url('student/courses') ?>" class="btn btn-sm btn-outline-primary">
                                                View All Courses <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                                    <i class="fas fa-tasks text-success fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Completed Lessons</h6>
                                                    <h2 class="mb-0"><?= $completed_lessons ?? 0 ?></h2>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-0">Track your learning progress and achievements.</p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 pt-0">
                                            <a href="<?= site_url('student/progress') ?>" class="btn btn-sm btn-outline-success">
                                                View Progress <i class="fas fa-chart-line ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                                                    <i class="fas fa-calendar-check text-info fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Upcoming</h6>
                                                    <h2 class="mb-0">0</h2>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-0">View your upcoming classes and deadlines.</p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 pt-0">
                                            <a href="<?= site_url('student/calendar') ?>" class="btn btn-sm btn-outline-info">
                                                View Calendar <i class="far fa-calendar-alt ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recent Activity Section -->
                            <div class="card border-0 shadow-sm mt-4">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($recent_courses)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Course</th>
                                                        <th>Last Accessed</th>
                                                        <th>Progress</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recent_courses as $course): ?>
                                                        <tr>
                                                            <td>
                                                                <h6 class="mb-1"><?= esc($course['title']) ?></h6>
                                                                <small class="text-muted"><?= esc($course['code'] ?? '') ?></small>
                                                            </td>
                                                            <td><?= date('M j, Y', strtotime($course['last_accessed'] ?? 'N/A')) ?></td>
                                                            <td>
                                                                <div class="progress" style="height: 6px;">
                                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                                         style="width: <?= $course['progress'] ?? 0 ?>%;" 
                                                                         aria-valuenow="<?= $course['progress'] ?? 0 ?>" 
                                                                         aria-valuemin="0" 
                                                                         aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <small><?= $course['progress'] ?? 0 ?>% Complete</small>
                                                            </td>
                                                            <td>
                                                                <a href="<?= site_url('student/courses/' . $course['id']) ?>" 
                                                                   class="btn btn-sm btn-outline-primary">
                                                                    Continue <i class="fas fa-arrow-right ms-1"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <div class="mb-3">
                                                <i class="fas fa-inbox fa-3x text-muted"></i>
                                            </div>
                                            <h5>No recent activity</h5>
                                            <p class="text-muted">Your recent courses and activities will appear here.</p>
                                            <a href="<?= site_url('student/courses') ?>" class="btn btn-primary">
                                                Browse Courses <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Security Tips Card -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i>Security Tips</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-0">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6>Important Security Notice</h6>
                                        <p class="mb-2">For your security, please ensure you log out after each session, especially when using shared devices. Your last login was from IP: <strong><?= $user['last_login_ip'] ?? 'Unknown' ?></strong> on <?= !empty($user['last_login']) ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>.</p>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="<?= site_url('profile/security') ?>" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-lock me-1"></i> Security Settings
                                            </a>
                                            <a href="<?= site_url('profile/activity') ?>" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-history me-1"></i> View Activity Log
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Session Timeout Warning Modal -->
    <div class="modal fade" id="sessionTimeoutModal" tabindex="-1" aria-labelledby="sessionTimeoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="sessionTimeoutModalLabel">
                        <i class="fas fa-clock me-2"></i>Session About to Expire
                    </h5>
                </div>
                <div class="modal-body">
                    <p>Your session will expire in <span id="countdown">2:00</span> due to inactivity.</p>
                    <p>Would you like to continue your session?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Log Out</button>
                    <button type="button" class="btn btn-primary" id="extendSession">
                        <i class="fas fa-sync-alt me-1"></i> Continue Session
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
