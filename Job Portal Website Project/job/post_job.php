<?php
// Check if the user is logged in and is an employer
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $employer_id = $_SESSION['user_id'];

    $query = "INSERT INTO jobs (title, description, location, salary, employer_id) VALUES ('$title', '$description', '$location', '$salary', '$employer_id')";
    mysqli_query($conn, $query);

    header("Location: jobs.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>JobPortal</h1>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="jobs.php">Find Jobs</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <section class="post-job">
        <h2>Post a New Job</h2>
        <form method="POST" action="post_job.php">
            <label for="title">Job Title:</label>
            <input type="text" name="title" required>

            <label for="description">Job Description:</label>
            <textarea name="description" required></textarea>

            <label for="location">Location:</label>
            <input type="text" name="location" required>

            <label for="salary">Salary:</label>
            <input type="text" name="salary" required>

            <button type="submit" class="btn">Post Job</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 JobPortal. All rights reserved.</p>
    </footer>
</body>
</html>


