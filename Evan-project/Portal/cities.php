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
        $stmt = $pdo->prepare("INSERT INTO Cities (city_name, state_id) VALUES (?, ?)");
        $stmt->execute([$_POST['city_name'], $_POST['state_id']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'City added successfully'];
        header("Location: cities.php");
        exit;
    }
    
    if (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE Cities SET city_name=?, state_id=? WHERE city_id=?");
        $stmt->execute([$_POST['city_name'], $_POST['state_id'], $_POST['id']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'City updated successfully'];
        header("Location: cities.php");
        exit;
    }
    
    if (isset($_POST['delete'])) {
        // Check if city has customers
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Customers WHERE city_id = ?");
        $stmt->execute([$_POST['id']]);
        $customerCount = $stmt->fetchColumn();
        
        if ($customerCount > 0) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Cannot delete city with associated customers'];
        } else {
            $stmt = $pdo->prepare("DELETE FROM Cities WHERE city_id=?");
            $stmt->execute([$_POST['id']]);
            $_SESSION['message'] = ['type' => 'success', 'text' => 'City deleted successfully'];
        }
        
        header("Location: cities.php");
        exit;
    }
}

// Get all cities with state info
$cities = $pdo->query("
    SELECT c.*, s.state_name, s.state_code 
    FROM Cities c 
    JOIN States s ON c.state_id = s.state_id 
    ORDER BY s.state_name, c.city_name
")->fetchAll();

// Get all states for dropdown
$states = $pdo->query("SELECT * FROM States ORDER BY state_name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cities - Evan Vista</title>
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
                    <h1 class="h2">Cities</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCityModal">
                        <i class="fas fa-plus"></i> Add City
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
                    <table id="citiesTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>City Name</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cities as $city): ?>
                                <tr>
                                    <td><?= $city['city_id'] ?></td>
                                    <td><?= htmlspecialchars($city['city_name']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($city['state_name']) ?> 
                                        <span class="text-muted">(<?= $city['state_code'] ?>)</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btn-edit" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCityModal"
                                                data-id="<?= $city['city_id'] ?>"
                                                data-name="<?= htmlspecialchars($city['city_name']) ?>"
                                                data-state_id="<?= $city['state_id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteCityModal"
                                                data-id="<?= $city['city_id'] ?>"
                                                data-name="<?= htmlspecialchars($city['city_name']) ?>">
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

    <!-- Add City Modal -->
    <div class="modal fade" id="addCityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">City Name *</label>
                            <input type="text" class="form-control" name="city_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State *</label>
                            <select class="form-select" name="state_id" required>
                                <option value="">Select State</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?= $state['state_id'] ?>">
                                        <?= htmlspecialchars($state['state_name']) ?> (<?= $state['state_code'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
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

    <!-- Edit City Modal -->
    <div class="modal fade" id="editCityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="edit_city_id">
                    <input type="hidden" name="update" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">City Name *</label>
                            <input type="text" class="form-control" name="city_name" id="edit_city_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State *</label>
                            <select class="form-select" name="state_id" id="edit_state_id" required>
                                <option value="">Select State</option>
                                <?php foreach ($states as $state): ?>
                                    <option value="<?= $state['state_id'] ?>">
                                        <?= htmlspecialchars($state['state_name']) ?> (<?= $state['state_code'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
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

    <!-- Delete City Modal -->
    <div class="modal fade" id="deleteCityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="delete_city_id">
                    <input type="hidden" name="delete" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the city: <strong id="delete_city_name"></strong>?</p>
                        <p class="text-danger">Note: This action cannot be undone and will fail if the city has associated customers.</p>
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
        $('#citiesTable').DataTable({
            responsive: true,
            order: [[2, 'asc'], [1, 'asc']] // Sort by state, then city name
        });

        // Edit button click
        $('#editCityModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#edit_city_id').val(button.data('id'));
            $('#edit_city_name').val(button.data('name'));
            $('#edit_state_id').val(button.data('state_id'));
        });

        // Delete button click
        $('#deleteCityModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#delete_city_id').val(button.data('id'));
            $('#delete_city_name').text(button.data('name'));
        });
    });
    </script>
</body>
</html>
