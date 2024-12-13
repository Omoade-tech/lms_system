<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        .navbar-nav {
            flex: 1;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
<!-- </head> -->
<!-- <body> -->

<nav class="navbar navbar-expand-lg navbar-light bg-body-secondary">
    <div class="container-fluid">
        <!-- LMS Link at the beginning -->
        <a class="navbar-brand" href="dashboard.php">
            <i class="bi bi-book"></i> LMS
        </a>

        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Center links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="books.php">
                        <i class="bi bi-collection"></i> Library
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="returnbook.php">
                        <i class="bi bi-arrow-return-left"></i> Return Book
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transaction.php">
                        <i class="bi bi-receipt"></i> Transaction
                    </a>
                </li>
            </ul>

            <!-- Right elements -->
            <div class="d-flex align-items-center ms-3">
                <!-- Avatar -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="navbarDropdownMenuAvatar" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li>
                            <a class="dropdown-item" href="/lms_system/Auth/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="students.php">
                                <i class="bi bi-person"></i> Student
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Right elements -->
        </div>
    </div>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- </body> -->
<!-- </html> -->