<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once '../Db/db.php';

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $stmt = $pdo->prepare("INSERT INTO Evac_Projects (project_name, description, customer_id, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['project_name'], $_POST['description'], $_POST['customer_id'], $_POST['start_date'] ?: null, $_POST['end_date'] ?: null]);
        $pdo->query("UPDATE Project_Summary SET total_projects = (SELECT COUNT(*) FROM Evac_Projects)");
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Project added'];
        header("Location: projects.php");
        exit;
    }
    
    if (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE Evac_Projects SET project_name=?, description=?, customer_id=?, start_date=?, end_date=? WHERE project_id=?");
        $stmt->execute([$_POST['project_name'], $_POST['description'], $_POST['customer_id'], $_POST['start_date'] ?: null, $_POST['end_date'] ?: null, $_POST['id']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Project updated'];
        header("Location: projects.php");
        exit;
    }
    
    if (isset($_POST['delete'])) {
        $pdo->prepare("DELETE FROM Evac_Projects WHERE project_id=?")->execute([$_POST['id']]);
        $pdo->query("UPDATE Project_Summary SET total_projects = (SELECT COUNT(*) FROM Evac_Projects)");
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Project deleted'];
        header("Location: projects.php");
        exit;
    }
}

// Get all projects with customer info
$projects = $pdo->query("
    SELECT p.*, c.customer_name
    FROM Evac_Projects p
    LEFT JOIN Customers c ON p.customer_id = c.customer_id
    ORDER BY p.created_at DESC
")->fetchAll();

$customers = $pdo->query("SELECT customer_id, customer_name FROM Customers ORDER BY customer_name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Evan Vista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'Left-meu.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Projects</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <i class="fas fa-plus"></i> Add Project
                    </button>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message']['text'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project Name</th>
                                <th>Customer</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $p): 
                                $today = date('Y-m-d');
                                $status = '';
                                $status_class = '';
                                
                                if ($p['end_date'] && $p['end_date'] < $today) {
                                    $status = 'Completed';
                                    $status_class = 'bg-success';
                                } elseif ($p['start_date'] && $p['start_date'] <= $today && (!$p['end_date'] || $p['end_date'] >= $today)) {
                                    $status = 'Active';
                                    $status_class = 'bg-primary';
                                } else {
                                    $status = 'Upcoming';
                                    $status_class = 'bg-warning';
                                }
                            ?>
                                <tr>
                                    <td><?= $p['project_id'] ?></td>
                                    <td><?= htmlspecialchars($p['project_name']) ?></td>
                                    <td><?= htmlspecialchars($p['customer_name'] ?: 'N/A') ?></td>
                                    <td><?= $p['start_date'] ? date('M d, Y', strtotime($p['start_date'])) : '-' ?></td>
                                    <td><?= $p['end_date'] ? date('M d, Y', strtotime($p['end_date'])) : '-' ?></td>
                                    <td><span class="badge <?= $status_class ?>"><?= $status ?></span></td>
                                    <td>
                                        <a href="project-details.php?id=<?= $p['project_id'] ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="editProject(<?= htmlspecialchars(json_encode($p)) ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $p['project_id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Project Name *</label>
                            <input type="text" class="form-control" name="project_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer *</label>
                            <select class="form-select" name="customer_id" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $c): ?>
                                    <option value="<?= $c['customer_id'] ?>"><?= htmlspecialchars($c['customer_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="create" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal (will be filled by JavaScript) -->
    <div class="modal fade" id="editProjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="update" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Will be filled by JavaScript -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="delete_id">
                    <input type="hidden" name="delete" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this project? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    function editProject(project) {
        // Fill the edit form with project data
        $('#edit_id').val(project.project_id);
        
        // Clone the add form body
        const formBody = $('#addProjectModal .modal-body').clone();
        
        // Fill the form fields
        formBody.find('[name="project_name"]').val(project.project_name);
        formBody.find('[name="description"]').val(project.description || '');
        formBody.find('[name="customer_id"]').val(project.customer_id || '');
        formBody.find('[name="start_date"]').val(project.start_date || '');
        formBody.find('[name="end_date"]').val(project.end_date || '');
        
        // Replace the edit modal body with the filled form
        $('#editProjectModal .modal-body').html(formBody.html());
        
        // Show the edit modal
        new bootstrap.Modal(document.getElementById('editProjectModal')).show();
    }
    
    function confirmDelete(id) {
        $('#delete_id').val(id);
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
    </script>
</body>
</html>
