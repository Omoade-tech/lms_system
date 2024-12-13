<?php

// include_once("/xampp/htdocs/lms_system/config/database.php");
// $controller = new BookController($connect);
// $controller->handleRequest();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php
include("/xampp/htdocs/lms_system/templates/Admin.php");
?>
    <div class="container mt-5">
        <h1 class="text-center">Add a New Book</h1>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Book added successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Error adding book. Please try again.</div>
        <?php endif; ?>
        <form action="/lms_system/controllers/BookController.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="title" class="form-label">Book Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter book title" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" placeholder="Enter author's name" required>
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter book ISBN" required>
            </div>
            <div class="mb-3">
                <label for="available_copies" class="form-label">Available Copies</label>
                <input type="number" class="form-control" id="available_copies" name="available_copies" placeholder="Enter number of copies" required>
            </div>
            <button type="submit" name="addBook" class="btn btn-primary">Add Book</button>
        </form>
    </div>

    <?php
include("/xampp/htdocs/lms_system/templates/footer.php");
?>
</body>
</html>
