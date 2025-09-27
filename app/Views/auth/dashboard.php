<?= $this->extend('templates/header') ?>

<?= $this->section('content'); ?>
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <?php if ($user['role'] === 'admin') : ?>
                        <h1 class="h3 mb-1 text-danger">
                            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                        </h1>
                        <p class="text-muted mb-0">Manage the entire learning platform</p>
                    <?php elseif ($user['role'] === 'teacher') : ?>
                        <h1 class="h3 mb-1 text-danger">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Teacher Dashboard
                        </h1>
                        <p class="text-muted mb-0">Manage your classes and students</p>
                    <?php else : ?>
                        <h1 class="h3 mb-1 text-danger">
                            <i class="fas fa-user-graduate me-2"></i>Student Dashboard
                        </h1>
                        <p class="text-muted mb-0">Access your courses and materials</p>
                    <?php endif; ?>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3 text-end d-none d-md-block">
                        <div class="fw-medium"><?= esc($user['name']) ?></div>
                        <span class="badge bg-danger">
                            <i class="fas fa-<?= $user['role'] === 'admin' ? 'shield-alt' : ($user['role'] === 'teacher' ? 'chalkboard-teacher' : 'user-graduate') ?> me-1"></i>
                            <?= ucfirst($user['role']) ?>
                        </span>
                    </div>
                    <div class="avatar bg-danger text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border-radius: 50%; font-weight: 600;">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                </div>
            </div>
            <hr class="border-danger opacity-25">
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($user['role'] === 'admin') : ?>
        <!-- Admin Dashboard -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-users-cog text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="mb-0">User Management</h5>
                        </div>
                        <p class="text-muted mb-3">Manage all user accounts and permissions across the platform.</p>
                        <a href="/admin/users" class="btn btn-outline-danger w-100">
                            <i class="fas fa-users me-1"></i> Manage Users
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-book text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="mb-0">Course Management</h5>
                        </div>
                        <p class="text-muted mb-3">Create, edit, and manage all courses and their content.</p>
                        <a href="/admin/courses" class="btn btn-outline-danger w-100">
                            <i class="fas fa-cog me-1"></i> Manage Courses
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-chart-line text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="mb-0">System Analytics</h5>
                        </div>
                        <p class="text-muted mb-3">View system-wide analytics and generate reports.</p>
                        <a href="/admin/analytics" class="btn btn-outline-danger w-100">
                            <i class="fas fa-chart-bar me-1"></i> View Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'teacher') : ?>
        <!-- Teacher Dashboard -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-chalkboard text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="mb-0">My Classes</h5>
                        </div>
                        <p class="text-muted mb-3">Access and manage all your classes and teaching materials.</p>
                        <a href="/teacher/classes" class="btn btn-outline-danger w-100">
                            <i class="fas fa-eye me-1"></i> View Classes
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-tasks text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="mb-0">Gradebook</h5>
                        </div>
                        <p class="text-muted mb-3">Manage student grades and assignments in one place.</p>
                        <a href="/teacher/gradebook" class="btn btn-outline-danger w-100">
                            <i class="fas fa-graduation-cap me-1"></i> View Gradebook
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php else : ?>
        <!-- Student Dashboard -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title text-danger">
                                    <i class="fas fa-book-open me-2"></i>My Courses
                                </h5>
                                <p class="text-muted mb-3 mb-md-0">Access your enrolled courses and learning materials. Continue your learning journey now.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="/student/courses" class="btn btn-danger">
                                    <i class="fas fa-graduation-cap me-1"></i> View My Courses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .btn-outline-danger {
        border-color: #e74c3c;
        color: #e74c3c;
    }
    
    .btn-outline-danger:hover {
        background-color: #e74c3c;
        color: white;
    }
    
    .avatar {
        transition: transform 0.3s ease;
    }
    
    .avatar:hover {
        transform: scale(1.1);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
        font-size: 0.85em;
    }
    
    @media (max-width: 767.98px) {
        .card {
            margin-bottom: 1rem;
        }
    }
</style>

<?= $this->endSection(); ?>
