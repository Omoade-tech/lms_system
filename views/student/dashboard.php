<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            margin-top: 4%;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 150px;
            background-color: #f8f9fa;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar .nav-link {
            color: #000;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .content {
            margin-left: 250px; /* Adjust based on sidebar width */
            padding: 20px;
        }
    </style>
</head>
<body>
<?php
    include("/xampp/htdocs/lms_system/templates/header.php");
    ?>

<div class="sidebar flex-end">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="students.php">
                <i class="bi bi-person-circle"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="bi bi-book"></i> Library
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="transaction.php">
                <i class="bi bi-cash"></i> Transaction
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="returnbook.php">
                <i class="bi bi-arrow-return-left"></i> Return Book
            </a>
        </li>
    </ul>
</div>
<?php
    include("/xampp/htdocs/lms_system/views/student/books.php");


    include("/xampp/htdocs/lms_system/templates/footer.php");

    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
