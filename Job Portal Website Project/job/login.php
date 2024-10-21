<?php
include 'db.php';
session_start();

// Check if there is a session message to display
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect to profile or admin dashboard based on role
            if ($user['role'] == 'employer') {
                header('Location: employer_dashboard.php');
            } else {
                header('Location: seeker_profile.php');
            }
            exit(); // Ensure no further code is executed
        } else {
            echo "<script>alert('Invalid credentials!');</script>"; // Invalid password
        }
    } else {
        echo "<script>alert('User not found!');</script>"; // User does not exist
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>
    <header class="bg-primary py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-white">JobPortal</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                        <li class="nav-item"><a href="login.php" class="nav-link text-white">Login</a></li>
                        <li class="nav-item"><a href="register.php" class="nav-link text-white">Register</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Login Container -->
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="logo3.jpeg" alt="Profile Logo" class="img-fluid" style="max-height: 100px;"> <!-- Profile logo -->
                    </div>
                    <div class="card-body">
                        <h2 class="text-center">Login to Your Account</h2>
                        <form method="POST" action="login.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span> <!-- Email icon -->
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span> <!-- Password icon -->
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>













