<?php
session_start();
include 'db.php';

// Check if the job_id is set in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $query = "SELECT * FROM jobs WHERE id = '$job_id'";
    $result = mysqli_query($conn, $query);
    $job = mysqli_fetch_assoc($result);
} else {
    header('Location: jobs.php');
    exit();
}

// Check if the user is logged in and a job seeker
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seeker') {
    echo "<script>alert('You need to be logged in as a job seeker to apply.');</script>";
    header('Location: login.php');
    exit();
}

// Retrieve the user ID from the session
$seeker_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);

    // Insert application details into the database without resume
    $query = "INSERT INTO applications (job_id, seeker_id, name, email, phone, address, experience, education, skills) 
              VALUES ('$job_id', '$seeker_id', '$name', '$email', '$phone', '$address', '$experience', '$education', '$skills')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = 'Application submitted successfully!';
    } else {
        $_SESSION['error'] = 'Error submitting application: ' . mysqli_error($conn);
    }

    // Redirect to the homepage and show the alert
    echo "<script>
            alert('" . ($_SESSION['message'] ?? $_SESSION['error']) . "' );
            window.location.href = 'index.php'; // Redirect to home page
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($job['title']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        footer {
            text-align: center;
            padding: 15px 0;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>JobPortal</h1>
        <nav>
            <a class="text-white mr-3" href="index.php">Home</a>
            <a class="text-white mr-3" href="jobs.php">Find Jobs</a>
            <a class="text-white" href="logout.php">Logout</a>
        </nav>
    </header>

    <section class="container mt-5 apply-job">
        <h2 class="text-center">Apply for <?php echo htmlspecialchars($job['title']); ?></h2>
        <div class="card mt-4">
            <div class="card-body">
                <form method="POST" class="apply-form">
                    <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

<!--                    <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>-->

                    <div class="form-group">
                        <label for="phone">Your Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Your Address:</label>
                        <textarea id="address" name="address" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="experience">Your Experience:</label>
                        <textarea id="experience" name="experience" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="education">Your Education:</label>
                        <textarea id="education" name="education" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="skills">Your Skills:</label>
                        <textarea id="skills" name="skills" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Submit Application</button>
                </form>
            </div>
        </div>
    </section>

<!--    <footer>
        <p>&copy; 2024 JobPortal. All rights reserved.</p>
    </footer>-->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
















