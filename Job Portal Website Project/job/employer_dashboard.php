<?php
session_start();
include 'db.php';

// Check if the user is logged in and is an employer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

// Fetch jobs posted by the employer
$employer_id = $_SESSION['user_id'];
$query = "SELECT * FROM jobs WHERE employer_id = '$employer_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
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
                <li><a href="post_job.php">Post Job</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard">
        <h2>Your Posted Jobs</h2>
        <ul>
            <?php while($job = mysqli_fetch_assoc($result)): ?>
                <li>
                    <h4><?php echo $job['title']; ?></h4>
                    <p><?php echo $job['description']; ?></p>
                    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
                    <p><strong>Salary:</strong> $<?php echo $job['salary']; ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    </section>

    <footer>
        <p>&copy; 2024 JobPortal. All rights reserved.</p>
    </footer>
</body>
</html>

