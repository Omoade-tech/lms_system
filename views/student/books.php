<?php
include_once("/xampp/htdocs/lms_system/config/database.php");
include_once("/xampp/htdocs/lms_system/controllers/BookController.php");

$bookController = new BookController($connect);

// Check if a search has been submitted
if (isset($_POST['searchBooks'])) {
    $searchTerm = $_POST['search'];
    $books = $bookController->searchBooks($searchTerm);
} else {
    $books = $bookController->getAllBooks();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> -->
</head>

<body>
<?php
    include("/xampp/htdocs/lms_system/templates/header.php");
?>
<form method="POST" class="mb-4 mt-5">
    <div class="input-group" style="max-width: 400px; margin: auto;">
        <input type="text" name="search" class="form-control" placeholder="Search by Title, Author, or ISBN" value="<?= htmlspecialchars($_POST['search'] ?? '') ?>" required>
        <button class="btn btn-primary" type="submit" name="searchBooks">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>


<div class="container mt-5 me-5">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Available Copies</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($books)) : ?>
                        <?php foreach ($books as $index => $book) : ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= htmlspecialchars($book['isbn']) ?></td>
                                <td>
                                    <?php if ($book['available_copies'] > 0) : ?>
                                        <span class="text-success">Available</span>
                                    <?php else : ?>
                                        <span class="text-danger">Not Available</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewBookModal<?= $index ?>">
                                        View
                                    </button>
                                    <a href="/lms_system/views/student/viewbook.php?id=<?= $book['id'] ?>" 
                                       class="btn btn-info btn-sm <?= $book['available_copies'] == 0 ? 'disabled' : '' ?>">
                                        Borrow
                                    </a>
                                </td>
                            </tr>
                            <div class="modal fade" id="viewBookModal<?= $index ?>" tabindex="-1" aria-labelledby="viewBookModalLabel<?= $index ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewBookModalLabel<?= $index ?>">Book Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
                                            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                                            <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
                                            <p><strong>Available Copies:</strong> <?= htmlspecialchars($book['available_copies']) ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No books found.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->
<?php
    include("/xampp/htdocs/lms_system/templates/footer.php");
?>
</body>
</html>
