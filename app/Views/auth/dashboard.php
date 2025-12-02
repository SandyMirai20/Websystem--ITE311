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
                            <i class=""></i>Home
                        </h1>
                        <p class="text-muted mb-0">Control and manage the platform</p>
                    <?php elseif ($user['role'] === 'teacher') : ?>
                        <h1 class="h3 mb-1 text-danger">
                            <i class=""></i>Home
                        </h1>
                        <p class="text-muted mb-0">Handle your classes and students here</p>
                    <?php else : ?>
                        <h1 class="h3 mb-1 text-danger">
                            <i class=""></i>Dashboard
                        </h1>
                        <p class="text-muted mb-0">Welcome!</p>
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
                            <h5 class="mb-0">Users</h5>
                        </div>
                        <p class="text-muted mb-3">Add, edit, or manage user accounts</p>
                        <a href="/admin/users" class="btn btn-outline-danger w-100">
                            <i class=""></i> Open Users
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
                            <h5 class="mb-0">Courses</h5>
                        </div>
                        <p class="text-muted mb-3">Create and manage courses</p>
                        <a href="/admin/courses" class="btn btn-outline-danger w-100">
                            <i class=""></i> Open Courses
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
                            <h5 class="mb-0">Reports</h5>
                        </div>
                        <p class="text-muted mb-3">Check reports and stats</p>
                        <a href="/admin/analytics" class="btn btn-outline-danger w-100">
                            <i class=""></i> Open Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'teacher') : ?>
        <!-- Teacher Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title text-danger">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>My Courses
                                </h5>
                                <p class="text-muted mb-3 mb-md-0">Manage your courses and upload materials here.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="<?= base_url('teacher/courses') ?>" class="btn btn-danger">
                                    <i class="fas fa-arrow-right me-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Courses -->
        <?php if (!empty($availableCourses) && is_array($availableCourses)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-danger mb-4">
                            <i class="fas fa-chalkboard-teacher me-2"></i>My Teaching Courses
                        </h5>
                        <div class="row g-4">
                            <?php foreach ($availableCourses as $course): ?>
                                <?php if (is_array($course) && isset($course['id'])): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title fw-bold mb-0">
                                                    <i class="fas fa-graduation-cap text-primary me-1"></i>
                                                    <?= esc($course['course'] ?? 'Untitled Course') ?>
                                                </h6>
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-chalkboard-teacher me-1"></i> Teaching
                                                </span>
                                            </div>
                                            <p class="card-text text-muted small mb-3">
                                                <?= !empty($course['description']) ? esc($course['description']) : 'No description available.' ?>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-light text-dark">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    <?= date('M d, Y', strtotime($course['created_at'])) ?>
                                                </span>
                                                <?php if (isset($course['materials_count'])): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-file-alt me-1"></i>
                                                        <?= $course['materials_count'] ?> Materials
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mt-3 d-flex gap-2">
                                                <a href="<?= base_url('teacher/courses/' . $course['id']) ?>" class="btn btn-sm btn-outline-primary flex-grow-1">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                                <a href="<?= base_url('teacher/course/' . $course['id'] . '/upload') ?>" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-upload me-1"></i> Upload
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-chalkboard text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                            <h5 class="mb-0">Classes</h5>
                        </div>
                        <p class="text-muted mb-3">View and manage your classes</p>
                        <a href="<?= base_url('teacher/courses') ?>" class="btn btn-outline-danger w-100">
                            <i class=""></i> Open Classes
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
                            <h5 class="mb-0">Materials</h5>
                        </div>
                        <p class="text-muted mb-3">Upload and manage course materials</p>
                        <a href="<?= base_url('teacher/courses') ?>" class="btn btn-outline-danger w-100">
                            <i class=""></i> Manage Materials
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php else : ?>
        <!-- Student Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title text-danger">
                                    <i class="fas fa-book me-2"></i>My Courses
                                </h5>
                                <p class="text-muted mb-3 mb-md-0">View your enrolled subjects and lessons here.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                            <a href="/student/enrollcourses" class="btn btn-danger">
                            <i class="fas fa-arrow-right me-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses -->
        <?php if (!empty($enrolledCourses) && is_array($enrolledCourses)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-danger mb-4">
                            <i class="fas fa-book me-2"></i>My Enrolled Courses
                        </h5>
                        <div class="row g-4">
                            <?php foreach ($enrolledCourses as $course): ?>
                                <?php if (is_array($course) && isset($course['id'])): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title fw-bold mb-0"><?= esc($course['course'] ?? 'Untitled Course') ?></h6>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Enrolled
                                                </span>
                                            </div>
                                            <p class="card-text text-muted small mb-3">
                                                <?= !empty($course['description']) ? esc($course['description']) : 'No description available.' ?>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-chalkboard-teacher me-1"></i>
                                                    <?= esc($course['teacher_name'] ?? 'No Teacher') ?>
                                                </span>
                                                <?php
                                                // Get materials count for this course
                                                $materialModel = new \App\Models\MaterialModel();
                                                $materialsCount = $materialModel->where('course_id', $course['id'])->countAllResults();
                                                ?>
                                                <?php if ($materialsCount > 0): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-file-alt me-1"></i>
                                                        <?= $materialsCount ?> Materials
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-muted">
                                                        <i class="fas fa-file-alt me-1"></i>
                                                        No Materials
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mt-2">
                                                <a href="<?= base_url('student/courses/' . $course['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-1"></i> View Materials
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Available Courses -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-danger mb-4">
                            <i class="fas fa-plus-circle me-2"></i>Available Courses
                        </h5>
                        
                        <?php if (!empty($availableCourses)): ?>
                            <div class="row g-4">
                                <?php foreach ($availableCourses as $course): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold"><?= esc($course['course']) ?></h6>
                                                <p class="card-text text-muted small mb-3">
                                                    <?= !empty($course['description']) ? esc($course['description']) : 'No description available.' ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-light text-dark">
                                                        <i class="fas fa-chalkboard-teacher me-1"></i>
                                                        <?= esc($course['teacher_name'] ?? 'No Teacher') ?>
                                                    </span>
                                                    <button class="btn btn-sm btn-outline-danger enroll-btn" data-course-id="<?= $course['id'] ?>">
                                                        <i class="fas fa-plus-circle me-1"></i> Enroll
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-book-open fa-3x text-muted"></i>
                                </div>
                                <h6 class="text-muted">No available courses at the moment</h6>
                                <p class="small text-muted">Please check back later for new courses</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

            </div>
        </div>

        <!-- Enroll Button Script -->
        <script>
        // Function to show alert messages
        function showAlert(message, type = 'info') {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Remove any existing alerts
            $('.alert-dismissible').alert('close');
            
            // Add new alert at the top of the container
            $('.container.py-4').prepend(alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                $('.alert-dismissible').alert('close');
            }, 5000);
        }
        
        // Function to get CSRF token
        function getCsrfToken() {
            return {
                name: '<?= csrf_token() ?>',
                hash: '<?= csrf_hash() ?>'
            };
        }
        
        // Function to update CSRF token in form
        function updateCsrfToken() {
            const csrf = getCsrfToken();
            $('input[name="' + csrf.name + '"]').val(csrf.hash);
            $('meta[name="csrf-token"]').attr('content', csrf.hash);
            return csrf;
        }

        $(document).ready(function() {
            // Handle enroll button click
            $(document).on('click', '.enroll-btn', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const courseId = $button.data('course-id');
                const $card = $button.closest('.card');
                const originalHtml = $button.html();
                
                if (!courseId) {
                    showAlert('Error: Invalid course information', 'danger');
                    return;
                }
                
                // Show loading state
                $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Enrolling...');
                
                // Get and update CSRF token
                const csrf = updateCsrfToken();
                
                // Prepare form data
                const formData = new FormData();
                formData.append('course_id', courseId);
                formData.append(csrf.name, csrf.hash);
                
                // Send AJAX request
                $.ajax({
                    url: '<?= site_url('student/enroll') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf.hash,
                        'X-CSRF-NAME': csrf.name
                    },
                    success: function(response) {
                        console.log('Response:', response);
                        
                        if (response && response.success) {
                            // Update UI on success
                            $button.html('<i class="fas fa-check-circle me-1"></i> Enrolled')
                                   .removeClass('btn-outline-danger')
                                   .addClass('btn-success')
                                   .prop('disabled', true);
                            
                            // Show success message
                            showAlert(response.message || 'Successfully enrolled in the course!', 'success');
                            
                            // Update CSRF token from response
                            if (response.csrf && response.csrf.hash) {
                                updateCsrfToken();
                            }
                            
                            // Reload the page after 1.5 seconds to reflect changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            // Show error message
                            const errorMsg = (response && response.message) || 'Failed to enroll. Please try again.';
                            showAlert(errorMsg, 'danger');
                            $button.prop('disabled', false).html(originalHtml);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        let errorMsg = 'An error occurred while processing your request.';
                        
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg = response.message || errorMsg;
                        } catch (e) {
                            errorMsg = 'Network error. Please check your connection and try again.';
                        }
                        
                        showAlert(errorMsg, 'danger');
                        $button.prop('disabled', false).html(originalHtml);
                    }
                });
            });
        });
        </script>
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
