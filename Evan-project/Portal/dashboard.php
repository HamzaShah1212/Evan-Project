<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../Db/db.php';

// Get statistics
$stats = [
    'total_customers' => $pdo->query("SELECT COUNT(*) as count FROM Customers")->fetch()['count'],
    'total_projects' => $pdo->query("SELECT COUNT(*) as count FROM Evac_Projects")->fetch()['count'],
    'active_projects' => $pdo->query("SELECT COUNT(*) as count FROM Evac_Projects WHERE start_date <= CURDATE() AND (end_date >= CURDATE() OR end_date IS NULL)")->fetch()['count'],
    'completed_projects' => $pdo->query("SELECT COUNT(*) as count FROM Evac_Projects WHERE end_date < CURDATE()")->fetch()['count']
];

// Get latest 5 projects
$latest_projects = $pdo->query("SELECT p.*, c.customer_name 
    FROM Evac_Projects p 
    JOIN Customers c ON p.customer_id = c.customer_id 
    ORDER BY p.created_at DESC LIMIT 5")->fetchAll();

// Get projects by customer
$projects_by_customer = $pdo->query("SELECT c.customer_name, COUNT(p.project_id) as project_count 
    FROM Customers c 
    LEFT JOIN Evac_Projects p ON c.customer_id = p.customer_id 
    GROUP BY c.customer_id 
    ORDER BY project_count DESC")->fetchAll();

// Get projects by state
$projects_by_state = $pdo->query("SELECT s.state_name, COUNT(p.project_id) as project_count 
    FROM States s 
    LEFT JOIN Cities c ON s.state_id = c.state_id 
    LEFT JOIN Customers cu ON c.city_id = cu.city_id 
    LEFT JOIN Evac_Projects p ON cu.customer_id = p.customer_id 
    GROUP BY s.state_id 
    ORDER BY project_count DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Evan Vista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4A90E2;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #e74c3c;
            --light: #f8f9fa;
            --dark: #343a40;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --text-light: #ecf0f1;
            --text-muted: #bdc3c7;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stat-card {
            border-left: 4px solid;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
            height: 100%;
        }

        .stat-card .card-body {
            position: relative;
            padding: 1.5rem;
        }

        .stat-card .stat-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #7f8c8d;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            margin: 10px 0;
        }
        
        .stat-card .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.35rem;
        }
        
        .card-title {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            font-weight: 700;
            color: var(--dark);
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.35em 0.5em;
        }
        
        .navbar {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            background-color: white;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(90deg, var(--primary) 0%, #2a3b9d 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(90deg, var(--success) 0%, #13855c 100%);
        }
        
        .bg-gradient-info {
            background: linear-gradient(90deg, var(--info) 0%, #238a9b 100%);
        }
        
        .bg-gradient-warning {
            background: linear-gradient(90deg, var(--warning) 0%, #dda20a 100%);
        }
        
        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }
        
        /* Custom scrollbar */
        .recent-activity::-webkit-scrollbar {
            width: 5px;
        }
        
        .recent-activity::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .recent-activity::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .recent-activity::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Toggle button */
        #menu-toggle {
            cursor: pointer;
        }
        
        /* Chart containers */
        .chart-container {
            position: relative;
            height: 250px;
        }
    </style>
</head>
<body>
    <?php include 'Left-meu.php'; ?>
    
    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Dashboard Overview</h1>
                <div class="d-flex">
                    <button class="btn btn-primary btn-sm me-2">
                        <i class="fas fa-download me-1"></i> Generate Report
                    </button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-calendar me-1"></i> This Month
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card primary">
                        <div class="card-body">
                            <div class="stat-title">Total Customers</div>
                            <div class="stat-value"><?php echo number_format($stats['total_customers']); ?></div>
                            <div class="stat-label"><i class="fas fa-arrow-up text-success me-1"></i> 12% from last month</div>
                            <i class="fas fa-users stat-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card success">
                        <div class="card-body">
                            <div class="stat-title">Total Projects</div>
                            <div class="stat-value"><?php echo number_format($stats['total_projects']); ?></div>
                            <div class="stat-label"><i class="fas fa-arrow-up text-success me-1"></i> 8% from last month</div>
                            <i class="fas fa-project-diagram stat-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card warning">
                        <div class="card-body">
                            <div class="stat-title">Active Projects</div>
                            <div class="stat-value"><?php echo number_format($stats['active_projects']); ?></div>
                            <div class="stat-label"><i class="fas fa-arrow-up text-success me-1"></i> 5% from last month</div>
                            <i class="fas fa-tasks stat-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card danger">
                        <div class="card-body">
                            <div class="stat-title">Completed Projects</div>
                            <div class="stat-value"><?php echo number_format($stats['completed_projects']); ?></div>
                            <div class="stat-label"><i class="fas fa-arrow-up text-success me-1"></i> 15% from last month</div>
                            <i class="fas fa-check-circle stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <!-- Projects by Customer Chart -->
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Projects by Customer</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="customerChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects by State Chart -->
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Projects by State</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="stateChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <!-- Recent Projects -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Projects</h6>
                                <a href="projects.php" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Customer</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($latest_projects as $project): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($project['project_name']) ?></td>
                                                <td><?= htmlspecialchars($project['customer_name']) ?></td>
                                                <td><?= $project['start_date'] ? date('M d, Y', strtotime($project['start_date'])) : '-' ?></td>
                                                <td><?= $project['end_date'] ? date('M d, Y', strtotime($project['end_date'])) : '-' ?></td>
                                                <td>
                                                    <?php 
                                                    if ($project['end_date'] && strtotime($project['end_date']) < time()) {
                                                        echo '<span class="badge bg-success">Completed</span>';
                                                    } else {
                                                        echo '<span class="badge bg-info">Active</span>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom scripts -->
    <script>
        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts if elements exist
            const customerCtx = document.getElementById('customerChart');
            const stateCtx = document.getElementById('stateChart');
            
            // Customer Chart
            if (customerCtx) {
                new Chart(customerCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: <?= json_encode(array_map(function($customer) {
                            return htmlspecialchars($customer['customer_name'], ENT_QUOTES);
                        }, $projects_by_customer)) ?>,
                        datasets: [{
                            data: <?= json_encode(array_column($projects_by_customer, 'project_count')) ?>,
                            backgroundColor: [
                                '#4A90E2', '#28a745', '#17a2b8', '#ffc107', '#e74c3c',
                                '#2c3e50', '#7f8c8d', '#6f42c1', '#fd7e14', '#20c9a6'
                            ],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#2c3e50',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#2c3e50',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} projects (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // State Chart
            if (stateCtx) {
                new Chart(stateCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode(array_map(function($state) {
                            return htmlspecialchars($state['state_name'], ENT_QUOTES);
                        }, $projects_by_state)) ?>,
                        datasets: [{
                            label: 'Projects',
                            data: <?= json_encode(array_column($projects_by_state, 'project_count')) ?>,
                            backgroundColor: 'rgba(74, 144, 226, 0.9)',
                            borderColor: 'rgba(74, 144, 226, 1)',
                            borderWidth: 0,
                            borderRadius: 4,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.03)'
                                },
                                ticks: {
                                    stepSize: 1,
                                    padding: 10,
                                    font: { size: 12 }
                                }
                            },
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { font: { size: 11 } }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#2c3e50',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#2c3e50',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: context => `Projects: ${context.raw}`
                                }
                            }
                        }
                    }
                });
            }

            // Toggle sidebar
            const menuToggle = document.getElementById('menu-toggle');
            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.body.classList.toggle('sidebar-toggled');
                });
            }

            // Initialize DataTables if jQuery is available
            if (typeof $ !== 'undefined') {
                $('.table').DataTable({
                    responsive: true,
                    pageLength: 5,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    info: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search projects..."
                    }
                });
            }
        });
    </script>
</body>
</html>