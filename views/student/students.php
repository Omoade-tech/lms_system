<?php

session_start();

include_once("/xampp/htdocs/lms_system/config/database.php"); 
include_once("/xampp/htdocs/lms_system/controllers/studentController.php"); 

// Initialize database connection
$studentController = new StudentController($connect);

// Ensure the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /lms_system/Auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$studentResponse = $studentController->findStudentById($student_id); 


if (isset($studentResponse['error'])) {
    echo $studentResponse['error'];  
    exit();
}

// Retrieve the student data
$student = $studentResponse['student'];

// Handle profile update (after form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Update the student profile
    $updateResponse = $studentController->updateProfile($_POST);

    // Check for any update errors
    if (isset($updateResponse['error'])) {
        echo $updateResponse['error'];  
    } else {
        echo $updateResponse['message'];  
        $studentResponse = $studentController->findStudentById($student_id); 
        $student = $studentResponse['student'];  
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
</head>
<style>
    .nav-link{
        color:blue;
    }
</style>
<body>
<?php
include("/xampp/htdocs/lms_system/templates/header.php");
?>
    <div class="container mt-5">
        <!-- Student Profile Display -->
        <h1>Student Profile</h1>
        <div class="card">
            <div class="card-body">
                <!-- Display student data with checks -->
                <h5 class="card-title">Name: <?= isset($student['name']) ? htmlspecialchars($student['name']) : 'No Name Available'; ?></h5>
                <p class="card-text"><strong>Email:</strong> <?= isset($student['email']) ? htmlspecialchars($student['email']) : 'No Email Available'; ?></p>
                <p class="card-text"><strong>Phone:</strong> <?= isset($student['phone']) ? htmlspecialchars($student['phone']) : 'No Phone Available'; ?></p>
                <p class="card-text"><strong>Sex:</strong> <?= isset($student['sex']) ? htmlspecialchars($student['sex']) : 'No Sex Available'; ?></p>
                <p class="card-text"><strong>Age:</strong> <?= isset($student['age']) ? htmlspecialchars($student['age']) : 'No Age Available'; ?></p>
                <p class="card-text"><strong>Total Book Borrowed:</strong> <?= isset($student['total_books_borrowed']) ? htmlspecialchars($student['total_books_borrowed']) : 'error'; ?></p>
                
                <!-- Button to trigger the update modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Edit Profile</button>
            </div>
        </div>
    </div>

    <!-- Update Profile Modal -->
    <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Update Form -->
                    <form  method="POST"> 
                        <input type="hidden" name="id" value="<?= isset($student['id']) ? htmlspecialchars($student['id']) : ''; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= isset($student['name']) ? htmlspecialchars($student['name']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= isset($student['email']) ? htmlspecialchars($student['email']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= isset($student['phone']) ? htmlspecialchars($student['phone']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="sex" class="form-label">Sex</label>
                            <input type="text" class="form-control" id="sex" name="sex" value="<?= isset($student['sex']) ? htmlspecialchars($student['sex']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?= isset($student['age']) ? htmlspecialchars($student['age']) : ''; ?>">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("/xampp/htdocs/lms_system/views/student/books.php");
    include("/xampp/htdocs/lms_system/views/Admin/books.php");

include("/xampp/htdocs/lms_system/templates/footer.php");

?>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
