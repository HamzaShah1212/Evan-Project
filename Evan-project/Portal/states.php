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
        $stmt = $pdo->prepare("INSERT INTO States (state_name, state_code) VALUES (?, ?)");
        $stmt->execute([$_POST['state_name'], $_POST['state_code']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'State added successfully'];
        header("Location: states.php");
        exit;
    }
    
    if (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE States SET state_name=?, state_code=? WHERE state_id=?");
        $stmt->execute([$_POST['state_name'], $_POST['state_code'], $_POST['id']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'State updated successfully'];
        header("Location: states.php");
        exit;
    }
    
    if (isset($_POST['delete'])) {
        // Check if state has cities
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Cities WHERE state_id = ?");
        $stmt->execute([$_POST['id']]);
        $cityCount = $stmt->fetchColumn();
        
        if ($cityCount > 0) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Cannot delete state with existing cities'];
        } else {
            $stmt = $pdo->prepare("DELETE FROM States WHERE state_id=?");
            $stmt->execute([$_POST['id']]);
            $_SESSION['message'] = ['type' => 'success', 'text' => 'State deleted successfully'];
        }
        
        header("Location: states.php");
        exit;
    }
}

// Get all states
$states = $pdo->query("SELECT * FROM States ORDER BY state_name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>States - Evan Vista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'Left-meu.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">States</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStateModal">
                        <i class="fas fa-plus"></i> Add State
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
                    <table id="statesTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>State Name</th>
                                <th>State Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($states as $state): ?>
                                <tr>
                                    <td><?= $state['state_id'] ?></td>
                                    <td><?= htmlspecialchars($state['state_name']) ?></td>
                                    <td><?= htmlspecialchars($state['state_code']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btn-edit" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editStateModal"
                                                data-id="<?= $state['state_id'] ?>"
                                                data-name="<?= htmlspecialchars($state['state_name']) ?>"
                                                data-code="<?= htmlspecialchars($state['state_code']) ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteStateModal"
                                                data-id="<?= $state['state_id'] ?>"
                                                data-name="<?= htmlspecialchars($state['state_name']) ?>">
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

    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add State</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">State Name *</label>
                            <input type="text" class="form-control" name="state_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State Code *</label>
                            <input type="text" class="form-control" name="state_code" maxlength="2" required>
                            <small class="text-muted">2-letter state code (e.g., CA for California)</small>
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

    <!-- Edit State Modal -->
    <div class="modal fade" id="editStateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="edit_state_id">
                    <input type="hidden" name="update" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit State</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">State Name *</label>
                            <input type="text" class="form-control" name="state_name" id="edit_state_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State Code *</label>
                            <input type="text" class="form-control" name="state_code" id="edit_state_code" maxlength="2" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete State Modal -->
    <div class="modal fade" id="deleteStateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="delete_state_id">
                    <input type="hidden" name="delete" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the state: <strong id="delete_state_name"></strong>?</p>
                        <p class="text-danger">Note: This action cannot be undone and will fail if the state has associated cities.</p>
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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#statesTable').DataTable({
            responsive: true,
            order: [[1, 'asc']] // Sort by state name by default
        });

        // Edit button click
        $('#editStateModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#edit_state_id').val(button.data('id'));
            $('#edit_state_name').val(button.data('name'));
            $('#edit_state_code').val(button.data('code'));
        });

        // Delete button click
        $('#deleteStateModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#delete_state_id').val(button.data('id'));
            $('#delete_state_name').text(button.data('name'));
        });
    });
    </script>
</body>
</html>
