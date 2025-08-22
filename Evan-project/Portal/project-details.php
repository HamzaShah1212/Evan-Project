<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Set error handler
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Error [$errno] $errstr in $errfile on line $errline");
    if (ini_get('display_errors')) {
        echo "<div class='alert alert-danger'><strong>Error:</strong> $errstr in $errfile on line $errline</div>";
    }
});

// Include database connection
$db_path = __DIR__ . '/../Db/db.php';
if (!file_exists($db_path)) {
    die("Database connection file not found at: " . $db_path);
}
include_once $db_path;

// Verify database connection
if (!isset($pdo) || !($pdo instanceof PDO)) {
    die("Database connection failed. Please check your database configuration.");
}

// Get project ID from URL
$project_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$project_id) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Invalid project ID'];
    header("Location: projects.php");
    exit;
}

error_log("Attempting to fetch project with ID: " . $project_id);

// Fetch project details with customer info
$stmt = $pdo->prepare("
    SELECT p.*, c.customer_name, c.email as customer_email, c.phone as customer_phone,
           s.state_name, ct.city_name
    FROM Evac_Projects p
    LEFT JOIN Customers c ON p.customer_id = c.customer_id
    LEFT JOIN Cities ct ON c.city_id = ct.city_id
    LEFT JOIN States s ON ct.state_id = s.state_id
    WHERE p.project_id = ?
");
try {
    $stmt->execute([$project_id]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($project === false) {
        error_log("No project found with ID: " . $project_id);
    } else {
        error_log("Successfully fetched project: " . print_r($project, true));
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Database error occurred. Please try again.'];
    header("Location: projects.php");
    exit;
}

if (!$project) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Project not found or database error'];
    error_log("Project not found with ID: " . $project_id);
    header("Location: projects.php");
    exit;
}

// Format dates and handle potential errors
try {
    $start_date = $project['start_date'] ? new DateTime($project['start_date']) : null;
    $end_date = $project['end_date'] ? new DateTime($project['end_date']) : null;
    $today = new DateTime();
} catch (Exception $e) {
    // Log error and set default values
    error_log('Date parsing error: ' . $e->getMessage());
    $start_date = null;
    $end_date = null;
    $today = new DateTime();
}

// Determine project status
if ($end_date && $end_date < $today) {
    $status = 'Completed';
    $status_class = 'bg-success';
} elseif ($start_date && $start_date <= $today && (!$end_date || $end_date >= $today)) {
    $status = 'In Progress';
    $status_class = 'bg-primary';
} else {
    $status = 'Upcoming';
    $status_class = 'bg-warning';
}

// Start output buffering to catch any unexpected output
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['project_name']) ?> - Evan Vista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Mobile Top Navigation -->
    <!-- <nav class="navbar navbar-expand-lg d-lg-none navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Evan Vista</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav> -->

    <div class="container-fluid mt-5 mt-lg-0">
        <div class="row">
            <?php include 'Left-meu.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Mobile Page Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom d-lg-none">
                    <h1 class="h4">
                        <?= htmlspecialchars($project['project_name']) ?>
                        <span class="badge <?= $status_class ?> ms-2"><?= $status ?></span>
                    </h1>
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?= htmlspecialchars($project['project_name']) ?>
                        <span class="badge <?= $status_class ?> ms-2"><?= $status ?></span>
                    </h1>
                    <div>
                        <a href="projects.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Projects
                        </a>
                        <a href="projects.php?edit=<?= $project['project_id'] ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Project
                        </a>
                    </div>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message']['text'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Project Details</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($project['description']): ?>
                                    <div class="mb-4">
                                        <h6>Description</h6>
                                        <p class="text-muted"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Timeline</h6>
                                        <p class="mb-1">
                                            <strong>Start Date:</strong> 
                                            <?= $start_date ? $start_date->format('F j, Y') : '<span class="text-muted">Not set</span>' ?>
                                        </p>
                                        <p class="mb-1">
                                            <strong>End Date:</strong> 
                                            <?= $end_date ? $end_date->format('F j, Y') : '<span class="text-muted">Not set</span>' ?>
                                        </p>
                                        <?php if ($start_date && $end_date): ?>
                                            <?php 
                                                $interval = $start_date->diff($end_date);
                                                $days_remaining = $today->diff($end_date);
                                                $total_days = $start_date->diff($end_date)->days;
                                                $days_passed = $today > $start_date ? $start_date->diff($today)->days : 0;
                                                // Prevent division by zero and ensure valid percentage
                                                $percentage = 0;
                                                if ($total_days > 0) {
                                                    $percentage = min(100, max(0, ($days_passed / $total_days) * 100));
                                                } else if ($start_date <= $today) {
                                                    $percentage = 100; // If start and end date are the same and in the past
                                                }
                                            ?>
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span>Progress</span>
                                                    <span><?= round($percentage) ?>%</span>
                                                </div>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                         style="width: <?= $percentage ?>%" 
                                                         aria-valuenow="<?= $percentage ?>" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    <?= $days_remaining->invert ? 'Project completed ' . $days_remaining->days . ' days ago' : $days_remaining->days . ' days remaining' ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Project Status</h6>
                                        <p class="mb-1">
                                            <strong>Status:</strong> 
                                            <span class="badge <?= $status_class ?>"><?= $status ?></span>
                                        </p>
                                        <p class="mb-1">
                                            <strong>Created:</strong> 
                                            <?= (new DateTime($project['created_at']))->format('F j, Y') ?>
                                        </p>
                                        <?php 
                                        // Only show if the project has been updated after creation
                                        if (isset($project['created_at'])): 
                                            $createdAt = new DateTime($project['created_at']);
                                            $updatedAt = isset($project['updated_at']) ? new DateTime($project['updated_at']) : $createdAt;
                                            
                                            if ($updatedAt > $createdAt): 
                                        ?>
                                            <p class="mb-1">
                                                <strong>Last Updated:</strong> 
                                                <?= $updatedAt->format('F j, Y') ?>
                                            </p>
                                        <?php 
                                            endif;
                                        endif; 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add more sections here for tasks, files, notes, etc. -->
                        
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <?= htmlspecialchars($project['customer_name']) ?>
                                </h6>
                                
                                <ul class="list-unstyled">
                                    <?php if ($project['customer_email']): ?>
                                        <li class="mb-2">
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            <a href="mailto:<?= htmlspecialchars($project['customer_email']) ?>">
                                                <?= htmlspecialchars($project['customer_email']) ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php if ($project['customer_phone']): ?>
                                        <li class="mb-2">
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            <a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $project['customer_phone'])) ?>">
                                                <?= htmlspecialchars($project['customer_phone']) ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php if ($project['city_name'] || $project['state_name']): ?>
                                        <li class="mb-2">
                                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                            <?= trim(htmlspecialchars(($project['city_name'] ?? '') . ', ' . ($project['state_name'] ?? '')), ', ') ?>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                
                                <div class="mt-3">
                                    <a href="customer-details.php?id=<?= $project['customer_id'] ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-user me-1"></i> View Customer Profile
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Add more widgets here like project team, recent activity, etc. -->
                        
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('[data-bs-toggle="offcanvas"]');
        const sidebar = document.querySelector('#sidebarMenu'); // Make sure your sidebar has id="sidebarMenu"

        // Bootstrap ke native offcanvas ko use karenge
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function () {
                const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
                bsOffcanvas.toggle();
            });
        }

        // Close sidebar when clicking on nav link (mobile)
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991.98) {
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(sidebar);
                    if (bsOffcanvas) bsOffcanvas.hide();
                }
            });
        });
    });
</script>

</body>
</html>
<?php
// Flush output buffer and check for errors
$output = ob_get_clean();
if (empty($output) && !headers_sent()) {
    // If we have no output but headers weren't sent, there might be an issue
    error_log('No output was generated for project ID: ' . $project_id);
    echo "<h1>An error occurred while loading this project.</h1>";
    echo "<p>Please try again or contact support if the problem persists.</p>";
} else {
    echo $output;
}
?>