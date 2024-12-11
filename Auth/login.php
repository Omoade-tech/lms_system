<?php
session_start();
include("/xampp/htdocs/lms_system/config/database.php");

$error_message = "";

if (isset($_POST['log'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username and password are entered
    if (empty($username) || empty($password)) {
        $error_message = "Both username and password are required.";
    } else {
        $role = null;
        $row = null;

        // Check in admins table
        $sql = "SELECT * FROM admins WHERE UserName = ? AND password = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = "admin";
        }

        // Check in students table if not found in admins
        if (!$row) {
            $sql = "SELECT * FROM students WHERE UserName = ? AND password = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $role = "student";
            }
        }

        // Handle successful login
        if ($row && $role) {
            // Set required session variables
            $_SESSION['student_id'] = $row['id']; // Universal ID for both roles
            $_SESSION['name'] = $row['name'];    // Assuming both admins and students have 'name' column
            $_SESSION['email'] = $row['email'];  // Assuming both admins and students have 'email' column
            $_SESSION['role'] = $role;

            if ($role === "admin") {
                header("location:/lms_system/views/Admin/admin.php");
            } elseif ($role === "student") {
                header("location: /lms_system/views/student/students.php");
            }
            exit;
        } else {
            $error_message = "Incorrect username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            background-image: url("/lms_system/Assets/image2.jpg");
            background-repeat: repeat;
            background-size: auto; 
            animation: moveBackground 4s infinite alternate ease-in-out;
        }

        @keyframes moveBackground {
            0% {
                background-position: 0% 50%; 
            }
            100% {
                background-position: 100% 50%; 
            }
        }
    </style>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" 
                       value="<?php if (isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>" 
                       class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" 
                       class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="log" class="btn btn-primary w-100">Login</button>
            <div class="mt-3">
            <p><i>You don't have an account</i> <a href="/lms_system/Auth/signup.php">Signup</a></p>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
