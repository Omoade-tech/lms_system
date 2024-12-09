<?php
require_once '/xampp/htdocs/lms_system/config/database.php';
require_once '/xampp/htdocs/lms_system/controllers/BookController.php';

$bookController = new BookController($connect);
$id = $_GET['id'];
$book = $bookController->getBook($id);

if (!$book) {
    echo "Book not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $return_date = $_POST['return_date']; // Capture the return date

    // Call the borrowBook method with the return date
    // $result = $bookController->borrowBook($id, $return_date);

    // if ($result) {
    //     header('Location: /lms_system/views/student/students.php?message=Book Borrowed Successfully');
    //     exit;
    // } else {
    //     header('Location: /lms_system/views/student/book.php?error=Failed to Borrow Book');
    //     exit;
    // }
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
<div class="container mt-5">
    <h1>Book Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
            <p><strong>Available Copies:</strong> <?= htmlspecialchars($book['available_copies']) ?></p>

            <?php if ($book['available_copies'] > 0) : ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
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