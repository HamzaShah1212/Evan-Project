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
        $stmt = $pdo->prepare("INSERT INTO Customers (customer_name, email, phone, city_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['city_id'] ?? null]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Customer added'];
        header("Location: customers.php");
        exit;
    }
    
    if (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE Customers SET customer_name=?, email=?, phone=?, city_id=? WHERE customer_id=?");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['city_id'] ?? null, $_POST['id']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Customer updated'];
        header("Location: customers.php");
        exit;
    }
    
    if (isset($_POST['delete'])) {
        $pdo->prepare("DELETE FROM Customers WHERE customer_id=?")->execute([$_POST['id']]);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Customer deleted'];
        header("Location: customers.php");
        exit;
    }
}

// Get all customers with city and state info
$customers = $pdo->query("SELECT c.*, ci.city_name, s.state_name 
    FROM Customers c 
    LEFT JOIN Cities ci ON c.city_id = ci.city_id 
    LEFT JOIN States s ON ci.state_id = s.state_id
    ORDER BY c.customer_name")->fetchAll();

$cities = $pdo->query("SELECT * FROM Cities ORDER BY city_name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Evan Vista</title>
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
                    <h1 class="h2">Customers</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <i class="fas fa-plus"></i> Add Customer
                    </button>
                </div>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message']['text'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <div class="table-responsive">
                    <table id="customersTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $c): ?>
                                <tr>
                                    <td><?= $c['customer_id'] ?></td>
                                    <td><?= htmlspecialchars($c['customer_name']) ?></td>
                                    <td><?= htmlspecialchars($c['email']) ?: '-' ?></td>
                                    <td><?= $c['phone'] ?: '-' ?></td>
                                    <td><?= $c['city_name'] ?: '-' ?></td>
                                    <td><?= $c['state_name'] ?: '-' ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-view" data-bs-toggle="modal" data-bs-target="#viewModal" 
                                            data-name="<?= htmlspecialchars($c['customer_name']) ?>"
                                            data-email="<?= htmlspecialchars($c['email']) ?>"
                                            data-phone="<?= htmlspecialchars($c['phone']) ?>"
                                            data-city="<?= htmlspecialchars($c['city_name']) ?>"
                                            data-state="<?= htmlspecialchars($c['state_name']) ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="<?= $c['customer_id'] ?>"
                                            data-name="<?= htmlspecialchars($c['customer_name']) ?>"
                                            data-email="<?= htmlspecialchars($c['email']) ?>"
                                            data-phone="<?= htmlspecialchars($c['phone']) ?>"
                                            data-city_id="<?= $c['city_id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                            data-id="<?= $c['customer_id'] ?>">
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

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city_id">
                                <option value="">Select City</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city['city_id'] ?>"><?= htmlspecialchars($city['city_name']) ?></option>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="update" value="1">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone" id="edit_phone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city_id" id="edit_city_id">
                                <option value="">Select City</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= $city['city_id'] ?>"><?= htmlspecialchars($city['city_name']) ?></option>
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

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="view_name"></span></p>
                    <p><strong>Email:</strong> <span id="view_email"></span></p>
                    <p><strong>Phone:</strong> <span id="view_phone"></span></p>
                    <p><strong>City:</strong> <span id="view_city"></span></p>
                    <p><strong>State:</strong> <span id="view_state"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
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
                        Are you sure you want to delete this customer? This action cannot be undone.
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
        $('#customersTable').DataTable({
            responsive: true
        });

        // Edit button click
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#edit_id').val(button.data('id'));
            $('#edit_name').val(button.data('name'));
            $('#edit_email').val(button.data('email'));
            $('#edit_phone').val(button.data('phone'));
            $('#edit_city_id').val(button.data('city_id'));
        });

        // View button click
        $('#viewModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#view_name').text(button.data('name'));
            $('#view_email').text(button.data('email') || '-');
            $('#view_phone').text(button.data('phone') || '-');
            $('#view_city').text(button.data('city') || '-');
            $('#view_state').text(button.data('state') || '-');
        });

        // Delete button click
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            $('#delete_id').val(button.data('id'));
        });
    });
    </script>
</body>
</html>
