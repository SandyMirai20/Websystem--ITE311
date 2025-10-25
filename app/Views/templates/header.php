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
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="timezone" content="Asia/Manila">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --primary-color: #e74c3c;  /* Red theme primary color */
            --secondary-color: #c0392b;  /* Darker red for secondary elements */
            --success-color: #27ae60;
            --danger-color: #c0392b;
            --warning-color: #f39c12;
            --info-color: #3498db;
            --light-color: #f8f9fa;
            --dark-color: #e74c3c;  /* Changed to match primary red */
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        /* Sidebar Styles */
        #wrapper {
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
        }
        
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            margin-left: -250px;
            transition: margin 0.25s ease-out;
            position: relative;
            z-index: 1000;
            background-color: var(--primary-color) !important;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        #page-content-wrapper {
            width: 100%;
            min-width: 0;
            flex: 1;
        }
        
        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }
        
        .sidebar-heading {
            background-color: rgba(0, 0, 0, 0.1);
        }
        
        .list-group-item {
            border: none;
            border-radius: 0;
            padding: 0.75rem 1.5rem;
        }
        
        .list-group-item:hover, .list-group-item:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .list-group-item.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        @media (min-width: 992px) {
            #sidebar-wrapper {
                margin-left: 0;
            }
            
            #wrapper.toggled #sidebar-wrapper {
                margin-left: -250px;
            }
            
            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }
        }
        
        /* Navbar styles for mobile */
        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .btn-primary, .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .border-primary {
            border-color: var(--primary-color) !important;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
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
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-danger text-white" id="sidebar-wrapper">
            <div class="p-3 text-center">
                <a href="<?= base_url() ?>" class="text-white text-decoration-none">
                    <h4 class="m-0">ITE</h4>
                </a>
            </div>
            <div class="list-group list-group-flush">
                <?php if ($isLoggedIn): ?>
                    <a href="<?= base_url('dashboard') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--primary-color); border-color: rgba(255,255,255,0.1);">
                        <i class="fas fa-home me-2"></i> Home
                    </a>
                    
                    <?php if ($userRole === 'admin'): ?>
                        <!-- Admin Menu Items -->
                        <a class="list-group-item list-group-item-action text-white" style="background-color: var(--primary-color); border-color: rgba(255,255,255,0.1);" data-bs-toggle="collapse" href="#adminMenu" role="button" aria-expanded="false" aria-controls="adminMenu">
                            <i class="fas fa-tools me-2"></i> Admin Tools <i class="fas fa-chevron-down float-end mt-1"></i>
                        </a>
                        <div class="collapse" id="adminMenu">
                            <a href="<?= base_url('admin/users') ?>" class="list-group-item list-group-item-action text-white ps-5" style="background-color: var(--primary-color); border-color: rgba(255,255,255,0.1);">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                            <a href="<?= base_url('admin/courses') ?>" class="list-group-item list-group-item-action text-white ps-5" style="background-color: var(--primary-color); border-color: rgba(255,255,255,0.1);">
                                <i class="fas fa-book me-2"></i>Manage Courses
                            </a>
                            <a href="<?= base_url('admin/settings') ?>" class="list-group-item list-group-item-action text-white ps-5" style="background-color: var(--primary-color); border-color: rgba(255,255,255,0.1);">
                            </a>
                        </div>
                        
                    <?php elseif ($userRole === 'teacher'): ?>
                        <!-- Teacher Menu Items -->
                        <a href="<?= base_url('teacher/courses') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--danger-color); border-color: rgba(255,255,255,0.1);">
                            <i class="fas fa-chalkboard-teacher me-2"></i> Courses
                        </a>
                        <a href="<?= base_url('teacher/students') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--danger-color); border-color: rgba(255,255,255,0.1);">
                            <i class="fas fa-user-graduate me-2"></i> Students
                        </a>
                        
                    <?php elseif ($userRole === 'student'): ?>
                        <!-- Student Menu Items -->
                        <a href="<?= base_url('student/courses') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--danger-color); border-color: rgba(255,255,255,0.1);">
                            <i class="fas fa-book-open me-2"></i> Courses
                        </a>
                        <a href="<?= base_url('student/progress') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--danger-color); border-color: rgba(255,255,255,0.1);">
                            <i class="fas fa-chart-line me-2"></i> Grades
                        </a>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <!-- Guest Menu Items -->
                    <a href="<?= base_url('about') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--danger-color); border-color: rgba(255,255,255,0.1);">
                    </a>
                    <a href="<?= base_url('courses') ?>" class="list-group-item list-group-item-action text-white" style="background-color: var(--primary-color); border-color: rgba(255,255,255,0.1);">
                        <i class="fas fa-book me-2"></i> Courses
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if ($isLoggedIn): ?>
                <!-- User Profile Section -->
                <div class="position-absolute bottom-0 w-100 p-3" style="background-color: var(--primary-color);">
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="me-2 d-flex align-items-center justify-content-center rounded-circle bg-secondary" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="small">
                                <div class="fw-bold"><?= esc(session()->get('name')) ?></div>
                                <div class="text-muted"><?= ucfirst($userRole) ?></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('settings') ?>"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <!-- Login/Register Buttons -->
                <div class="position-absolute bottom-0 w-100 p-3" style="background-color: var(--primary-color);">
                    <a href="<?= base_url('login') ?>" class="btn btn-outline-light w-100 mb-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <!-- Mobile menu toggle -->
                        <button class="btn btn-link text-white me-3 d-lg-none" id="menu-toggle">
                            <i class="fas fa-bars"></i>
                        </button>

                        <a class="navbar-brand mb-0 d-lg-none" href="#">
                            <i class="fas fa-graduation-cap me-2"></i>LMS
                        </a>
                    </div>

                    <!-- Right side navigation items -->
                    <div class="navbar-nav ms-auto">
                        <?php if ($isLoggedIn): ?>
                            <!-- Notifications Dropdown -->
                            <div class="dropdown me-3">
                                <button class="btn btn-link text-white position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                    <?php if (isset($unreadNotificationCount) && $unreadNotificationCount > 0): ?>
                                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" id="notificationBadge">
                                            <?= $unreadNotificationCount ?>
                                            <span class="visually-hidden">unread notifications</span>
                                        </span>
                                    <?php endif; ?>
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                                    <div class="dropdown-header">
                                        <h6 class="mb-0">Notifications</h6>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div id="notificationsList" class="dropdown-body">
                                        <!-- Notifications will be loaded here via AJAX -->
                                        <div class="text-center text-muted py-3">
                                            <div class="spinner-border spinner-border-sm me-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            Loading notifications...
                                        </div>
                                    </div>
                                    <?php if (isset($unreadNotificationCount) && $unreadNotificationCount > 0): ?>
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-item text-center">
                                            <a href="#" class="text-decoration-none">View all notifications</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- User Profile Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-link text-white dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="me-2 d-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-20" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="d-none d-lg-block">
                                        <div class="fw-semibold small">
                                            <?php
                                            $displayName = session()->get('name') ?? 'User';
                                            echo strlen($displayName) > 15 ? substr($displayName, 0, 15) . '...' : $displayName;
                                            ?>
                                        </div>
                                        <div class="text-white-50 small">
                                            <?php
                                            $role = session()->get('role') ?? 'guest';
                                            echo ucfirst($role);
                                            ?>
                                        </div>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <!-- Login/Register Buttons for guests -->
                            <a href="<?= base_url('login') ?>" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content -->
            <div class="container-fluid p-4">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const wrapper = document.getElementById('wrapper');

            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('toggled');
                });
            }

            // Auto-close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const dropdowns = document.querySelectorAll('.dropdown-menu.show');
                dropdowns.forEach(function(dropdown) {
                    if (!dropdown.parentElement.contains(event.target)) {
                        const dropdownInstance = bootstrap.Dropdown.getInstance(dropdown.previousElementSibling);
                        if (dropdownInstance) {
                            dropdownInstance.hide();
                        }
                    }
                });
            });

            // Load notifications on page load
            loadNotifications();

            // Refresh notifications every 60 seconds
            setInterval(loadNotifications, 60000);
        });

        // Function to load notifications via AJAX
        function loadNotifications() {
            <?php if ($isLoggedIn): ?>
                $.get('<?= base_url('notifications') ?>')
                    .done(function(response) {
                        if (response.success) {
                            updateNotificationBadge(response.unread_count);
                            updateNotificationList(response.notifications);
                        }
                    })
                    .fail(function() {
                        console.error('Failed to load notifications');
                    });
            <?php endif; ?>
        }

        // Update notification badge
        function updateNotificationBadge(count) {
            const badge = document.getElementById('notificationBadge');
            const bellButton = document.querySelector('#notificationsDropdown');

            if (count > 0) {
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = 'block';
                } else {
                    // Create badge if it doesn't exist
                    const newBadge = document.createElement('span');
                    newBadge.className = 'badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill';
                    newBadge.id = 'notificationBadge';
                    newBadge.textContent = count;
                    bellButton.appendChild(newBadge);
                }
            } else {
                if (badge) {
                    badge.style.display = 'none';
                }
            }
        }

        // Update notification list in dropdown
        function updateNotificationList(notifications) {
            const listContainer = document.getElementById('notificationsList');

            if (!notifications || notifications.length === 0) {
                listContainer.innerHTML = '<div class="text-center text-muted py-3">No notifications</div>';
                return;
            }

            let html = '';
            notifications.forEach(function(notification) {
                const timeAgo = formatTimeAgo(notification.created_at);
                html += `
                    <div class="dropdown-item d-flex justify-content-between align-items-start" data-notification-id="${notification.id}">
                        <div class="flex-grow-1">
                            <div class="small text-muted">${timeAgo}</div>
                            <div>${notification.message}</div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary mark-as-read-btn" data-notification-id="${notification.id}">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                `;
            });

            listContainer.innerHTML = html;

            // Add click handlers for mark as read buttons
            document.querySelectorAll('.mark-as-read-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const notificationId = this.getAttribute('data-notification-id');
                    markNotificationAsRead(notificationId);
                });
            });
        }

        // Mark notification as read
        function markNotificationAsRead(notificationId) {
            $.post('<?= base_url('notifications/mark_read') ?>/' + notificationId)
                .done(function(response) {
                    if (response.success) {
                        // Remove notification from list
                        const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notificationElement) {
                            notificationElement.remove();
                        }

                        // Reload notifications to update badge
                        loadNotifications();
                    }
                })
                .fail(function() {
                    console.error('Failed to mark notification as read');
                });
        }

        // Format time ago
        function formatTimeAgo(dateString) {
            let date;

            try {
                // Handle different datetime formats that might come from server
                if (dateString.includes('T')) {
                    // ISO format: 2025-10-25T12:30:45 or 2025-10-25T12:30:45+08:00
                    date = new Date(dateString);
                } else if (dateString.includes(' ')) {
                    // MySQL format: 2025-10-25 12:30:45
                    date = new Date(dateString.replace(' ', 'T'));
                } else {
                    // Fallback
                    date = new Date(dateString);
                }

                // Check if date is valid
                if (isNaN(date.getTime())) {
                    console.warn('Invalid date string:', dateString);
                    return 'Just now';
                }

                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                // Handle future dates
                if (diffInSeconds < 0) {
                    return 'Just now';
                }

                // More granular time display
                if (diffInSeconds < 30) {
                    return 'Just now';
                } else if (diffInSeconds < 60) {
                    return diffInSeconds + ' seconds ago';
                } else if (diffInSeconds < 3600) {
                    const minutes = Math.floor(diffInSeconds / 60);
                    return minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
                } else if (diffInSeconds < 86400) {
                    const hours = Math.floor(diffInSeconds / 3600);
                    return hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
                } else if (diffInSeconds < 604800) {
                    const days = Math.floor(diffInSeconds / 86400);
                    return days + ' day' + (days > 1 ? 's' : '') + ' ago';
                } else {
                    // For older dates, show the actual date and time
                    return date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined,
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            } catch (error) {
                console.error('Error parsing date:', dateString, error);
                return 'Just now';
            }
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
