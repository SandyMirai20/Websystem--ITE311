<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard - ITE311-MACA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }
        
        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: #dc3545;
            background: linear-gradient(180deg, #dc3545 10%, #bb2d3b 100%);
            color: white;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin: 0.2rem 1rem;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, 
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 1.2rem;
            text-align: center;
        }
        
        /* Main Content */
        #content {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
            color: var(--primary-color);
            padding: 1rem 1.25rem;
        }
        
        /* Stats Cards */
        .stat-card {
            text-align: center;
            padding: 1.5rem;
            border-left: 4px solid;
        }
        
        .stat-card i {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.7;
        }
        
        .stat-card h3 {
            font-weight: 700;
            margin: 0.5rem 0;
            font-size: 1.5rem;
        }
        
        .stat-card p {
            color: var(--secondary-color);
            margin: 0;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(45deg, #dc3545, #bb2d3b) !important;
        }
        
        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a, #13855c) !important;
        }
        
        .bg-gradient-info {
            background: linear-gradient(45deg, #36b9cc, #258391) !important;
        }
        
        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a) !important;
        }
        
        /* Activity Feed */
        .activity-item {
            position: relative;
            padding-left: 2rem;
            padding-bottom: 1.5rem;
            border-left: 1px solid #e3e6f0;
        }
        
        .activity-item:last-child {
            padding-bottom: 0;
            border-left: 1px solid transparent;
        }
        
        .activity-item::before {
            content: '';
            position: absolute;
            left: -8px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--primary-color);
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                width: 250px;
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            #content {
                margin-left: 0 !important;
            }
        }
        
        .btn-outline-primary {
            color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-outline-primary:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .badge.bg-primary {
            background-color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="p-3 text-center">
                <h4 class="mb-0">Instructor Portal</h4>
                <small>Welcome back, <?= $user['name'] ?? 'Instructor' ?></small>
            </div>
            <hr class="my-0 bg-light">
            <div class="p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-journal-text"></i> My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-people"></i> Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-journal-check"></i> Assignments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-graph-up"></i> Grades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-calendar3"></i> Schedule
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-white bg-danger bg-opacity-25" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div id="content" class="w-100">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name'] ?? 'Instructor') ?>" class="rounded-circle me-2" width="32" height="32">
                                <span class="d-none d-md-inline"><?= $user['name'] ?? 'Instructor' ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid p-4">
                <!-- Welcome Card -->
                <div class="card bg-gradient-primary text-white mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="h4 mb-3">Welcome back, <?= $user['name'] ?? 'Instructor' ?>!</h2>
                                <p class="mb-0">Manage your courses, students, and assignments from one place.</p>
                            </div>
                            <div class="col-md-4 text-md-end d-none d-md-block">
                                <i class="bi bi-person-workspace display-4 opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card border-left-primary">
                            <div class="card-body">
                                <i class="bi bi-journal-text text-primary"></i>
                                <h3 class="text-primary">5</h3>
                                <p>Active Courses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card border-left-success">
                            <div class="card-body">
                                <i class="bi bi-people text-success"></i>
                                <h3 class="text-success">127</h3>
                                <p>Total Students</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card border-left-warning">
                            <div class="card-body">
                                <i class="bi bi-journal-check text-warning"></i>
                                <h3 class="text-warning">12</h3>
                                <p>Pending Grading</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card border-left-info">
                            <div class="card-body">
                                <i class="bi bi-bell text-info"></i>
                                <h3 class="text-info">3</h3>
                                <p>New Messages</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Recent Activity -->
                    <div class="col-lg-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Activity</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="activity-feed">
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between mb-1">
                                            <h6 class="mb-0">New assignment submitted</h6>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                        <p class="mb-0">John Doe submitted "Web Development Project" in ITE311</p>
                                    </div>
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between mb-1">
                                            <h6 class="mb-0">New student enrolled</h6>
                                            <small class="text-muted">5 hours ago</small>
                                        </div>
                                        <p class="mb-0">Jane Smith enrolled in your Database Systems course</p>
                                    </div>
                                    <div class="activity-item">
                                        <div class="d-flex justify-content-between mb-1">
                                            <h6 class="mb-0">Course updated</h6>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <p class="mb-0">You updated the syllabus for Web Development</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-outline-primary text-start">
                                        <i class="bi bi-plus-circle me-2"></i> Create Assignment
                                    </a>
                                    <a href="#" class="btn btn-outline-success text-start">
                                        <i class="bi bi-journal-text me-2"></i> Add Course Materials
                                    </a>
                                    <a href="#" class="btn btn-outline-info text-start">
                                        <i class="bi bi-calendar3 me-2"></i> Schedule Class
                                    </a>
                                    <a href="#" class="btn btn-outline-warning text-start">
                                        <i class="bi bi-graph-up me-2"></i> View Analytics
                                    </a>
                                </div>
                                
                                <hr class="my-4">
                                
                                <h6 class="mb-3">Upcoming Deadlines</h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Web Development</h6>
                                            <small class="text-muted">Tomorrow</small>
                                        </div>
                                        <p class="mb-1 small">Project Presentations</p>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Database Systems</h6>
                                            <small class="text-muted">In 3 days</small>
                                        </div>
                                        <p class="mb-1 small">Midterm Exam Grading Due</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Students -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Students</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Course</th>
                                                <th>Last Active</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>john@example.com</td>
                                                <td>Web Development</td>
                                                <td>2 hours ago</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>jane@example.com</td>
                                                <td>Database Systems</td>
                                                <td>5 hours ago</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mike Johnson</td>
                                                <td>mike@example.com</td>
                                                <td>Web Development</td>
                                                <td>1 day ago</td>
                                                <td><span class="badge bg-warning">Inactive</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const content = document.getElementById('content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('show');
                    content.classList.toggle('overlay');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                        content.classList.remove('overlay');
                    }
                }
            });
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
