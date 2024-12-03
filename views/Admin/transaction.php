<?php
require_once '/xampp/htdocs/lms_system/config/database.php';
require_once '/xampp/htdocs/lms_system/controllers/libraryController.php';



$transactionController = new TransactionController($connect);

$response = $transactionController->findAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
include("/xampp/htdocs/lms_system/templates/Admin.php");
?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Library Transactions</h1>
        <?php if (isset($response['error'])): ?>
            <div class="alert alert-danger text-center">
                <?= $response['error']; ?>
            </div>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Book ID</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($response['transaction'] as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['id']); ?></td>
                            <td><?= htmlspecialchars($transaction['student_name']); ?></td>
                            <td><?= htmlspecialchars($transaction['book_id']); ?></td>
                            <td><?= htmlspecialchars($transaction['book_title']); ?></td>
                            <td><?= htmlspecialchars($transaction['borrow_date']); ?></td>
                            <td><?= htmlspecialchars($transaction['return_date']); ?></td>
                            <td><?= htmlspecialchars($transaction['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
<?php
include("/xampp/htdocs/lms_system/templates/footer.php");
?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
