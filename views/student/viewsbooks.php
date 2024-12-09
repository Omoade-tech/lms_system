<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $return_date = $_POST['return_date'];
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];

    $result = $bookController->borrowBook($id, $return_date, $student_id, $student_name);

    if ($result) {
        header('Location: /lms_system/views/student/students.php?message=Book Borrowed Successfully');
        exit;
    } else {
        header('Location: /lms_system/views/student/book.php?error=Failed to Borrow Book');
        exit;
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">


<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
    <div class="mb-3">
        <label for="student_id" class="form-label">Student ID</label>
        <input type="text" class="form-control" id="student_id" name="student_id" required>
    </div>
    <div class="mb-3">
        <label for="student_name" class="form-label">Student Name</label>
        <input type="text" class="form-control" id="student_name" name="student_name" required>
    </div>
    <div class="mb-3">
        <label for="return_date" class="form-label">Set Return Date</label>
        <input type="date" class="form-control" id="return_date" name="return_date" required>
    </div>
    <button type="submit" class="btn btn-primary">Confirm Borrow</button>
</form>

</div>
</div>
</div>
</body>
</html>
