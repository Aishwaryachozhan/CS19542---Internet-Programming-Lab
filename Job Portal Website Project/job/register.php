<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already in use!');</script>";
    } else {
        // Insert user into the database
        $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        mysqli_query($conn, $query);

        // Set a session message for successful registration
        $_SESSION['message'] = 'Registration successful! You can now log in.';
        
        // Redirect to login page after successful registration
        header('Location: login.php');
        exit(); // Ensure no further code is executed
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <header class="bg-primary text-white py-3">
        <nav class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="logo">JobPortal</h1>
                <ul class="nav">
                    <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link text-white">Login</a></li>
                    <li class="nav-item"><a href="register.php" class="nav-link text-white">Register</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Register Container -->
    <section class="register-container container mt-5 d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <h2 class="text-center">Create an Account</h2>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="register.php">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="role">Sign Up As:</label>
                            <select name="role" class="form-control">
                                <option value="seeker">Job Seeker</option>
                                <option value="employer">Employer</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




