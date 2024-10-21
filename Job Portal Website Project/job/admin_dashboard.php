<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php'; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];

    
    $query = "INSERT INTO jobs (title, description, location, salary) VALUES ('$title', '$description', '$location', '$salary')";
    if (mysqli_query($conn, $query)) {
        $success_message = "Job posted successfully!";
    } else {
        $error_message = "Error posting job: " . mysqli_error($conn);
    }
}


if (isset($_GET['delete'])) {
    $job_id = $_GET['delete'];
    $delete_query = "DELETE FROM jobs WHERE id = '$job_id'";
    mysqli_query($conn, $delete_query);
    header("Location: admin_dashboard.php"); 
    exit();
}


$jobs_query = "SELECT * FROM jobs";
$jobs_result = mysqli_query($conn, $jobs_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: #fff;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                   
                    <li class="nav-item">
                        <a class="nav-link" href="admin_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Post a New Job</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
                        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
                        
                        <form method="POST" action="admin_dashboard.php">
                            <div class="form-group">
                                <label for="title">Job Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Job Description:</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="salary">Salary:</label>
                                <input type="text" name="salary" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Job</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Current Job Listings</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Job Title</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($job = mysqli_fetch_assoc($jobs_result)): ?>
                                <tr>
                                    <td><?php echo $job['id']; ?></td>
                                    <td><?php echo $job['title']; ?></td>
                                    <td><?php echo $job['location']; ?></td>
                                    <td>$<?php echo $job['salary']; ?></td>
                                    <td>
                                        <a href="edit_job.php?id=<?php echo $job['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="?delete=<?php echo $job['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?');"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





