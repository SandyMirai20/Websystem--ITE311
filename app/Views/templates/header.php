<?php
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userRole = session()->get('role') ?? 'guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'LMS System' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .navbar-brand, .nav-link {
            color: white !important;
        }
        
        .nav-link:hover {
            opacity: 0.9;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .badge {
            font-weight: 500;
            padding: 0.4em 0.8em;
        }
        
        .welcome-text {
            color: #6c757d;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <i class="fas fa-graduation-cap me-2"></i>LMS System
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                        
                        <?php if ($userRole === 'admin'): ?>
                            <!-- Admin Menu Items -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" 
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-shield me-1"></i> Admin
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url('admin/users') ?>"><i class="fas fa-users me-2"></i>Manage Users</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/courses') ?>"><i class="fas fa-book me-2"></i>Manage Courses</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                </ul>
                            </li>
                            
                        <?php elseif ($userRole === 'teacher'): ?>
                            <!-- Teacher Menu Items -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('teacher/courses') ?>">
                                    <i class="fas fa-chalkboard-teacher me-1"></i> My Courses
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('teacher/students') ?>">
                                    <i class="fas fa-user-graduate me-1"></i> Students
                                </a>
                            </li>
                            
                        <?php elseif ($userRole === 'student'): ?>
                            <!-- Student Menu Items -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('student/courses') ?>">
                                    <i class="fas fa-book-open me-1"></i> My Learning
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('student/progress') ?>">
                                    <i class="fas fa-chart-line me-1"></i> My Progress
                                </a>
                            </li>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <!-- Guest Menu Items -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('about') ?>">
                                <i class="fas fa-info-circle me-1"></i> About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('courses') ?>">
                                <i class="fas fa-book me-1"></i> Courses
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if ($isLoggedIn): ?>
                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" 
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2"><?= esc(session()->get('name')) ?></span>
                                <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('settings') ?>"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Login/Register Buttons -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('register') ?>">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mb-5">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>LMS System</h5>
                    <p class="mb-0">A modern learning management system for educational institutions.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('about') ?>" class="text-white">About Us</a></li>
                        <li><a href="<?= base_url('contact') ?>" class="text-white">Contact</a></li>
                        <li><a href="<?= base_url('privacy') ?>" class="text-white">Privacy Policy</a></li>
                        <li><a href="<?= base_url('terms') ?>" class="text-white">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Connect With Us</h5>
                    <div class="d-flex">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-3">
            <div class="text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> LMS System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>

