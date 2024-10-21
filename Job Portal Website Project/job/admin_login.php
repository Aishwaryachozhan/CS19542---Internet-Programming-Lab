<?php
session_start();
include 'db.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Admin credentials (can be moved to an environment variable or database for better security)
    $admin_username = 'admin';
    $admin_password = 'admin123'; // Ideally hashed

    // Check if the entered credentials match the admin's credentials
    if ($username === $admin_username && $password === $admin_password) {
        // Store session variable to signify admin login
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php'); // Redirect to the admin dashboard
        exit();
    } else {
        // Show error if login fails
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="bg-primary text-white py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Job Portal Admin</h2>
            <nav class="nav">
                <a class="nav-link text-white" href="index.php">Home</a>
                <a class="nav-link text-white" href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <i class="fas fa-user-circle fa-3x"></i> <!-- Profile Icon -->
                <h4 class="mt-2">Admin Login</h4>
            </div>
            <div class="card-body">
                <!-- Display error if login fails -->
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                <form method="POST" action="admin_login.php">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> Username:
                        </label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password:
                        </label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





