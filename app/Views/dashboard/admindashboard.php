<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ITE311-GOMEZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1rem rgba(0, 0, 0, 0.1);
            transition: transform .2s;
        }
        .card:hover {
            transform: translateY(-4px);
        }
        .card-header {
            font-weight: bold;
        }
        .stat-card {
            color: #fff;
        }
        .stat-card i {
            opacity: 0.7;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-graduation-cap"></i> ITE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"></ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?= $user['name'] ?? 'Admin' ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container mt-4">
        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
            <a href="#" class="btn btn-danger btn-sm shadow-sm"><i class="fas fa-download"></i> Generate Report</a>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-danger stat-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>Total Users</h6>
                            <h3>1,234</h3>
                        </div>
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success stat-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>Active Courses</h6>
                            <h3>42</h3>
                        </div>
                        <i class="fas fa-book-open fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning stat-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>Pending Requests</h6>
                            <h3>18</h3>
                        </div>
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info stat-card">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>System Status</h6>
                            <h5>Operational</h5>
                        </div>
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light"><i class="fas fa-chart-line"></i> User Activity Overview</div>
                    <div class="card-body"><canvas id="areaChart"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-light"><i class="fas fa-chart-pie"></i> User Distribution</div>
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                        <div class="mt-3 text-center small">
                            <span><i class="fas fa-circle text-danger"></i> Students</span> ·
                            <span><i class="fas fa-circle text-success"></i> Instructors</span> ·
                            <span><i class="fas fa-circle text-info"></i> Admins</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Actions -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-light"><i class="fas fa-history"></i> Recent Activity</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">New user registered – <small class="text-muted">5 mins ago</small></li>
                            <li class="list-group-item">Course created – <small class="text-muted">2 hrs ago</small></li>
                            <li class="list-group-item">System updated – <small class="text-muted">1 day ago</small></li>
                        </ul>
                        <a href="#" class="btn btn-danger btn-sm mt-3">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-light"><i class="fas fa-bolt"></i> Quick Actions</div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6"><a href="#" class="btn btn-danger w-100"><i class="fas fa-user-plus"></i> Add User</a></div>
                            <div class="col-md-6"><a href="#" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i> Create Course</a></div>
                            <div class="col-md-6"><a href="#" class="btn btn-info w-100"><i class="fas fa-envelope"></i> Send Message</a></div>
                            <div class="col-md-6"><a href="#" class="btn btn-warning w-100"><i class="fas fa-cog"></i> Settings</a></div>
                        </div>
                        <div class="text-center mt-3">
                            <small class="text-muted">System Status: <span class="text-success">All systems operational</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center py-3 mt-4 border-top">
            <small>&copy; ITE311-GOMEZ <?= date('Y') ?></small>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // Area Chart
        const areaCtx = document.getElementById('areaChart').getContext('2d');
        new Chart(areaCtx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
                datasets: [{
                    label: 'New Users',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Students', 'teachers', 'Admins'],
                datasets: [{
                    data: [70, 25, 5],
                    backgroundColor: ['#dc3545','#198754','#0dcaf0']
                }]
            },
            options: { responsive: true, cutout: '70%', plugins: { legend: { display: false } } }
        });
    </script>
</body>
</html>
