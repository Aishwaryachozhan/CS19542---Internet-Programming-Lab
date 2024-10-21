<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php'; // Include your database connection

// Check if job ID is provided
if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php'); // Redirect if no job ID is provided
    exit();
}

$job_id = $_GET['id'];

// Fetch the job details from the database
$query = "SELECT * FROM jobs WHERE id = '$job_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // Job not found
    header('Location: admin_dashboard.php');
    exit();
}

$job = mysqli_fetch_assoc($result);

// Handle job update submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];

    // Update the job in the database
    $update_query = "UPDATE jobs SET title='$title', description='$description', location='$location', salary='$salary' WHERE id='$job_id'";
    if (mysqli_query($conn, $update_query)) {
        $success_message = "Job updated successfully!";
        header("Location: admin_dashboard.php"); // Redirect to dashboard after success
        exit();
    } else {
        $error_message = "Error updating job: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #007bff;">
        <a class="navbar-brand text-white" href="admin_dashboard.php">Admin Dashboard</a>
        
    </nav>

    <div class="container mt-5">
        <h2>Edit Job</h2>

        <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>

        <form method="POST" action="edit_job.php?id=<?php echo $job['id']; ?>">
            <div class="form-group">
                <label for="title">Job Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo $job['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Job Description:</label>
                <textarea name="description" class="form-control" required><?php echo $job['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" name="location" class="form-control" value="<?php echo $job['location']; ?>" required>
            </div>
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="text" name="salary" class="form-control" value="<?php echo $job['salary']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Job</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



