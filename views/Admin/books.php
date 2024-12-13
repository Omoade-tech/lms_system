<?php
include_once("/xampp/htdocs/lms_system/config/database.php");
include_once("/xampp/htdocs/lms_system/controllers/BookController.php");

$bookController = new BookController($connect);

// Handle search functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchBooks'])) {
    $searchTerm = $_POST['search'];
    $books = $bookController->searchBooks($searchTerm);
} else {
    $books = $bookController->getAllBooks();
}

// Handle success/error messages
$message = '';
if (isset($_GET['success']) && $_GET['success'] == 'update') {
    $message = 'Book updated successfully!';
} elseif (isset($_GET['success']) && $_GET['success'] == 'delete') {
    $message = 'Book deleted successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <title>Admin - Manage Books</title>
</head>

<body>
    <?php include("/xampp/htdocs/lms_system/templates/Admin.php"); ?>

    <div class="container mt-5">
        <!-- Success/Error Messages -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-success" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <form method="POST" class="mb-4">
            <div class="input-group" style="max-width: 400px; margin: auto;">
                <input type="text" name="search" class="form-control" placeholder="Search by Title, Author, or ISBN" value="<?= htmlspecialchars($_POST['search'] ?? '') ?>" required>
                <button class="btn btn-primary" type="submit" name="searchBooks">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Book List -->
        <div class="card">
            <div class="card-body">
                <h3>Book List</h3>
                <table class="table table-bordered">
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
                        <?php if (!empty($books)): ?>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?= htmlspecialchars($book['title']) ?></td>
                                    <td><?= htmlspecialchars($book['author']) ?></td>
                                    <td><?= htmlspecialchars($book['isbn']) ?></td>
                                    <td><?= htmlspecialchars($book['available_copies']) ?></td>
                                    <td>
                                        <!-- Edit and Delete Buttons -->
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewBookModal-<?= $book['id'] ?>">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBookModal-<?= $book['id'] ?>">Delete</button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="viewBookModal-<?= $book['id'] ?>" tabindex="-1" aria-labelledby="viewBookModalLabel-<?= $book['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewBookModalLabel-<?= $book['id'] ?>">Edit Book</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/lms_system/controllers/BookController.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                                    <div class="mb-3">
                                                        <label for="title-<?= $book['id'] ?>" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="title-<?= $book['id'] ?>" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="author-<?= $book['id'] ?>" class="form-label">Author</label>
                                                        <input type="text" class="form-control" id="author-<?= $book['id'] ?>" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="isbn-<?= $book['id'] ?>" class="form-label">ISBN</label>
                                                        <input type="text" class="form-control" id="isbn-<?= $book['id'] ?>" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="copies-<?= $book['id'] ?>" class="form-label">Available Copies</label>
                                                        <input type="number" class="form-control" id="copies-<?= $book['id'] ?>" name="available_copies" value="<?= htmlspecialchars($book['available_copies']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="updateBook" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteBookModal-<?= $book['id'] ?>" tabindex="-1" aria-labelledby="deleteBookModalLabel-<?= $book['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteBookModalLabel-<?= $book['id'] ?>">Delete Book</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="/lms_system/controllers/BookController.php" method="post">
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete the book "<strong><?= htmlspecialchars($book['title']) ?></strong>"?</p>
                                                    <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="deleteBook" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No books found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>