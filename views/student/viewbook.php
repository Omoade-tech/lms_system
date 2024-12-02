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
    $result = $bookController->borrowBook($id);
  
    if ($result) {
        header('Location: ../lms_system/views/student/students.php?message=Book Borrowed Successfully');
    } else {
        header('Location: /views/student/book.php?error=Failed to Borrow Book');
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
<div class="container mt-5">
    <h1>Book Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
            <p><strong>Available Copies:</strong> <?= htmlspecialchars($book['available_copies']) ?></p>

            <?php if ($book['available_copies'] > 0) : ?>
                <form  method="post">
                    <input type="hidden" name="id" value="<?= $book['id'] ?>">
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
