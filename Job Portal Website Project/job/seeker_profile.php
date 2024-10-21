<?php
session_start();
include 'db.php';

// Check if the user is logged in and is a job seeker
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seeker') {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Fetch job applications by the seeker
$applications_query = "
    SELECT DISTINCT jobs.title, jobs.location, jobs.salary, applications.cover_letter
    FROM applications
    JOIN jobs ON applications.job_id = jobs.id
    WHERE applications.seeker_id = '$user_id'
";
$applications_result = mysqli_query($conn, $applications_query);

// Determine which section to show based on the query parameter
$section = isset($_GET['section']) ? $_GET['section'] : ''; // Default is empty
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Job Seeker</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .sidebar {
            height: 100vh; /* Full height */
            background-color: #007bff; /* Blue background */
        }
        .sidebar a {
            color: white; /* White text */
        }
        .sidebar a:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .dropdown-menu {
            background-color: #007bff; /* Blue dropdown background */
        }
        .dropdown-item {
            color: white; /* White text for dropdown items */
        }
        .dropdown-item:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <header class="bg-primary text-white py-3">
        <nav class="container d-flex justify-content-between align-items-center">
            <h1 class="logo">JobPortal</h1>
            <ul class="nav">
                <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <h4 class="text-white text-center mt-3">Welcome, <?php echo $user['username']; ?>!</h4>
                    <ul class="nav flex-column mt-4">
                        <li class="nav-item">
                            <a class="nav-link" href="seeker_profile.php?section=profile">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="seeker_profile.php?section=applications">
                                <i class="fas fa-file-alt"></i> Applied Jobs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-question-circle"></i> Need Help?
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <section class="profile-content">
                    <?php if ($section == 'profile'): ?>
                        <h3>Profile Details</h3>
                        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>Joined on:</strong> <?php echo $user['created_at']; ?></p>
                        <a href="edit_profile.php" class="btn btn-warning">Edit Profile</a>
                    <?php elseif ($section == 'applications'): ?>
                        <h3>Your Job Applications</h3>
                        <ul class="list-group">
                            <?php while ($application = mysqli_fetch_assoc($applications_result)): ?>
                                <li class="list-group-item">
                                    <h4><?php echo $application['title']; ?> - <?php echo $application['location']; ?></h4>
                                    <p><strong>Salary:</strong> $<?php echo $application['salary']; ?></p>
                                    <p><strong>Cover Letter:</strong></p>
                                    <p><?php echo $application['cover_letter'] ?: 'No cover letter provided.'; ?></p>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        
                    <?php endif; ?>
                </section>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



















