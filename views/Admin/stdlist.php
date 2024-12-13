<?php
session_start();

include_once("/xampp/htdocs/lms_system/config/database.php");
include_once("/xampp/htdocs/lms_system/controllers/StudentController.php");

// Initialize database connection
$studentController = new StudentController($connect);

// Ensure the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /lms_system/Auth/login.php");
    exit();
}

// Fetch all students
$studentsResponse = $studentController->findAll();
$students = isset($studentsResponse['success']) ? $studentsResponse['students'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<?php include("/xampp/htdocs/lms_system/templates/Admin.php"); ?> 


<div class="container mt-5">
    <h1 class="mb-4">All Students</h1>
    <?php if (!empty($students)): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars($student['phone']) ?></td>
                    <td>
                        <!-- Button to trigger modal -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentModal<?= $student['id'] ?>">View</button>
                    </td>
                </tr>

                <!-- Modal for each student -->
                <div class="modal fade" id="studentModal<?= $student['id'] ?>" tabindex="-1" aria-labelledby="studentModalLabel<?= $student['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="studentModalLabel<?= $student['id'] ?>">Student Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                                <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?></p>
                                <p><strong>Sex:</strong> <?= htmlspecialchars($student['sex']) ?></p>
                                <p><strong>Age:</strong> <?= htmlspecialchars($student['age']) ?></p>
                                <p><strong>Total Books Borrowed:</strong> <?= htmlspecialchars($student['total_books_borrowed']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No students found.</div>
    <?php endif; ?>
</div>

<?php include("/xampp/htdocs/lms_system/templates/footer.php"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
