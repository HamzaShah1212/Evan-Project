<?php
session_start();
include_once '../Db/conn.php'; // DB connection (gives $pdo)

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create operation
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        $sql = "INSERT INTO `evac-contactform` (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $subject, $message]);
        
        echo json_encode(['success' => true, 'message' => 'Record created successfully']);
        exit;
    }
    
    // Update operation
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        $sql = "UPDATE `evac-contactform` SET name=?, email=?, subject=?, message=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $subject, $message, $id]);
        
        echo json_encode(['success' => true, 'message' => 'Record updated successfully']);
        exit;
    }
    
    // Delete operation
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        
        $sql = "DELETE FROM `evac-contactform` WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
        exit;
    }
}

// Fetch single record for view/edit
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT id, name, email, subject, message, created_at FROM `evac-contactform` WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($record) {
        echo json_encode($record);
    } else {
        echo json_encode(['error' => 'Record not found']);
    }
    exit;
}

// DB query with PDO for all records
$sql = "SELECT id, name, email, subject, message, created_at FROM `evac-contactform` ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Customer Contacts";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .actions button {
            margin: 2px;
        }
        .message-text {
            white-space: pre-wrap;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include the sidebar -->
            <?php include 'Left-meu.php'; ?>
            
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Customer Contact Messages</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
                
                <div class="table-container">
                    <table id="contactsTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']); ?></td>
                                        <td><?= htmlspecialchars($row['name']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['subject']); ?></td>
                                        <td><?= strlen($row['message']) > 50 ? htmlspecialchars(substr($row['message'], 0, 50)) . '...' : htmlspecialchars($row['message']); ?></td>
                                        <td><?= date('M d, Y', strtotime($row['created_at'])); ?></td>
                                        <td class="actions">
                                            <button class="btn btn-info btn-sm btn-view" data-id="<?= $row['id']; ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $row['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id']; ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Contact Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Name:</strong></label>
                        <p id="view-name" class="form-control-static"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong></label>
                        <p id="view-email" class="form-control-static"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Subject:</strong></label>
                        <p id="view-subject" class="form-control-static"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Message:</strong></label>
                        <p id="view-message" class="form-control-static message-text"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Date:</strong></label>
                        <p id="view-date" class="form-control-static"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="create-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="create-subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="create-message" class="form-label">Message</label>
                            <textarea class="form-control" id="create-message" name="message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="edit-subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-message" class="form-label">Message</label>
                            <textarea class="form-control" id="edit-message" name="message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this contact message? This action cannot be undone.</p>
                    <input type="hidden" id="delete-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#contactsTable').DataTable({
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ]
        });
        
        // View button click
        $('.btn-view').on('click', function() {
            var id = $(this).data('id');
            
            $.get('?action=view&id=' + id, function(data) {
                var record = JSON.parse(data);
                $('#view-name').text(record.name);
                $('#view-email').text(record.email);
                $('#view-subject').text(record.subject);
                $('#view-message').text(record.message);
                $('#view-date').text(new Date(record.created_at).toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                }));
                
                $('#viewModal').modal('show');
            });
        });
        
        // Edit button click
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            
            $.get('?action=view&id=' + id, function(data) {
                var record = JSON.parse(data);
                $('#edit-id').val(record.id);
                $('#edit-name').val(record.name);
                $('#edit-email').val(record.email);
                $('#edit-subject').val(record.subject);
                $('#edit-message').val(record.message);
                
                $('#editModal').modal('show');
            });
        });
        
        // Delete button click
        $('.btn-delete').on('click', function() {
            var id = $(this).data('id');
            $('#delete-id').val(id);
            $('#deleteModal').modal('show');
        });
        
        // Create form submission
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize() + '&create=true';
            
            $.post('', formData, function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('#createModal').modal('hide');
                    alert('Record created successfully');
                    location.reload();
                } else {
                    alert('Error creating record: ' + result.message);
                }
            });
        });
        
        // Edit form submission
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize() + '&update=true';
            
            $.post('', formData, function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('#editModal').modal('hide');
                    alert('Record updated successfully');
                    location.reload();
                } else {
                    alert('Error updating record: ' + result.message);
                }
            });
        });
        
        // Confirm delete
        $('#confirm-delete').on('click', function() {
            var id = $('#delete-id').val();
            var formData = 'id=' + id + '&delete=true';
            
            $.post('', formData, function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $('#deleteModal').modal('hide');
                    alert('Record deleted successfully');
                    location.reload();
                } else {
                    alert('Error deleting record: ' + result.message);
                }
            });
        });
    });
    </script>
</body>
</html>