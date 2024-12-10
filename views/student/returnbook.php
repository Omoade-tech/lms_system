<?php
// Start session
// session_start();

if (!isset($_SESSION['student_id'])) {
    header('Location: /login.php');
    exit;
}

require_once '/xampp/htdocs/lms_system/config/database.php';
require_once '/xampp/htdocs/lms_system/controllers/libraryController.php';
require_once '/xampp/htdocs/lms_system/models/Book.php';

$transactionController = new TransactionController($connect);
$bookModel = new Book($connect);

// Fetch the logged-in student's borrowed books
$studentId = $_SESSION['student_id'];
$response = json_decode($transactionController->getStudentTransactions($studentId), true);

// Ensure $transactions is always an array
$transactions = $response['status'] === 'success' ? $response['transaction'] : [];

// Filter only currently borrowed books
$borrowedBooks = array_filter($transactions, function($transaction) {
    return $transaction['status'] === 'borrowed';
});

// Handle book return request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transactionId = $_POST['transaction_id'];
    $response = json_decode($transactionController->returnBook($transactionId), true);

    if ($response['status'] === 'success') {
        $_SESSION['success_message'] = "Book returned successfully!";
    } else {
        $_SESSION['error_message'] = $response['message'] ?? "Failed to return the book.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Borrowed Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Return Borrowed Books</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?php if (empty($borrowedBooks)): ?>
            <div class="alert alert-info">
                You have no books currently borrowed to return.
            </div>
        <?php else: ?>
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>S/N</th>
                        <th>Book Title</th>
                        <th>ISBN</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Expected Return</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowedBooks as $index => $transaction): 
                        $book = $bookModel->getBookById($transaction['book_id']);
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($index) ?></td>
                            <td><?= htmlspecialchars($book['title'] ?? 'Unknown Title') ?></td>
                            <td><?= htmlspecialchars($book['isbn'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($book['author'] ?? 'Unknown') ?></td>
                            <td><?= htmlspecialchars($transaction['borrow_date']) ?></td>
                            <td><?= htmlspecialchars($transaction['return_date'] ?? 'Not Specified') ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($transaction['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to return this book?')">
                                        Return Book
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
