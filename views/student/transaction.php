<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: /login.php');
    exit;
}

require_once '/xampp/htdocs/lms_system/config/database.php';
require_once '/xampp/htdocs/lms_system/controllers/libraryController.php';

$transactionController = new TransactionController($connect);

// Fetch the logged-in student's transactions
$studentId = $_SESSION['student_id'];
$response = json_decode($transactionController->getStudentTransactions($studentId), true);

$transactions = $response['status'] === 'success' ? $response['transaction'] : [];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Transaction History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Transaction History</h2>
    
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $index => $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($index + 1) ?></td>
                            <td><?= htmlspecialchars($transaction['book_title'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($transaction['borrow_date'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($transaction['return_date'] ?? 'Not Returned') ?></td>
                            <td><?= htmlspecialchars($transaction['status'] ?? 'Unknown') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No transactions found for your account.</p>
        <?php endif; ?>
    </div>
</body>

</html>