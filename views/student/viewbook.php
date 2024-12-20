<?php
session_start(); 

require_once '/xampp/htdocs/lms_system/config/database.php';
require_once '/xampp/htdocs/lms_system/controllers/libraryController.php';
require_once '/xampp/htdocs/lms_system/controllers/BookController.php';

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: /lms_system/views/login.php');
    exit;
}

// Initialize controller
$transactionController = new TransactionController($connect);

// Get book details
$bookId = $_GET['id'] ?? null;
if (!$bookId) {
    echo "Book ID is missing.";
    exit;
}

$bookController = new BookController($connect);
$book = $bookController->getBook($bookId);

if (!$book) {
    echo "Book not found.";
    exit;
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['student_id'];
    $returnDate = $_POST['return_date'] ?? null;

    if (!$returnDate) {
        $message = 'Return date is required.';
    } else {
        $result = json_decode($transactionController->borrowBook($studentId, $bookId, $returnDate), true);
        $message = $result['message'];
        if ($result['status'] === 'success') {
            header('Location: /lms_system/views/student/students.php?message=' . urlencode($message));
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
    include("/xampp/htdocs/lms_system/templates/header.php");
    ?>
<div class="container mt-5">
    <h1>Book Details</h1>
    <div class="card">
        <div class="card-body">
            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?= $result['status'] === 'success' ? 'success' : 'danger' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <p><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
            <p><strong>Available Copies:</strong> <?= htmlspecialchars($book['available_copies']) ?></p>

            <?php if ($book['available_copies'] > 0) : ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="return_date" class="form-label">Set Return Date</label>
                        <input type="date" class="form-control" id="return_date" name="return_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Borrow</button>
                </form>
            <?php else : ?>
                <button class="btn btn-secondary" disabled>Not Available</button>
            <?php endif; ?>
            <a href="/lms_system/views/student/students.php" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
</body>
</html>