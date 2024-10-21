<?php
session_start();
include 'db.php';

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $query = "SELECT * FROM jobs WHERE id = '$job_id'";
    $result = mysqli_query($conn, $query);
    $job = mysqli_fetch_assoc($result);
} else {
    header('Location: jobs.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $job['title']; ?> - Job Details</title>
    <style>
        /* Reset some default styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
        }

        header .logo {
            text-align: center;
        }

        header ul {
            list-style-type: none;
            padding: 0;
        }

        header ul li {
            display: inline;
            margin: 0 15px;
        }

        header ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        header ul li a:hover {
            text-decoration: underline;
        }

        .job-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .job-details h2 {
            color: #333;
        }

        .job-details p {
            line-height: 1.6;
            color: #555;
        }

        .job-details p strong {
            color: #007bff;
        }

        .job-details .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .job-details .btn:hover {
            background-color: #218838;
        }

        footer {
            text-align: center;
            padding: 15px 0;
            background-color: #333;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="job-details">
        <h2><?php echo $job['title']; ?></h2>
        <p><strong>Company:</strong> <?php echo $job['company']; ?></p>
        <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
        <p><strong>Salary:</strong> $<?php echo $job['salary']; ?></p>
        <p><strong>Description:</strong> <?php echo $job['description']; ?></p>
        <p><strong>Requirements:</strong> <?php echo $job['requirements']; ?></p>
        
        <?php if (isset($_SESSION['user_id'])): // Check if the user is logged in ?>
            <a href="apply.php?job_id=<?php echo $job['id']; ?>" class="btn">Apply Now</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login to Apply</a> <!-- Redirect to login if not logged in -->
        <?php endif; ?>
    </section>

<!--    <footer>
        <p>&copy; 2024 JobPortal. All rights reserved.</p>
    </footer>-->
</body>
</html>












