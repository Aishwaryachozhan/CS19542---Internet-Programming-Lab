<?php
session_start();
include 'db.php';

// Handle the search query
$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM jobs WHERE company LIKE '%$search%' OR title LIKE '%$search%' OR location LIKE '%$search%'";
} else {
    $query = "SELECT * FROM jobs ORDER BY created_at DESC";
}

$jobs_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Jobs</title>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
                        <?php if ($_SESSION['role'] == 'employer'): ?>
                            <li class="nav-item"><a href="employer_dashboard.php" class="nav-link text-white">Dashboard</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a href="seeker_profile.php" class="nav-link text-white">Profile</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item"><a href="login.php" class="nav-link text-white">Login</a></li>
                        <li class="nav-item"><a href="register.php" class="nav-link text-white">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <section class="job-search py-4">
        <div class="container text-center">
            <h2>Search for Jobs</h2>
            <form method="POST" action="jobs.php" class="mt-3">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by company, job title, or location" value="<?php echo htmlspecialchars($search); ?>" required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="job-listing py-4">
        <div class="container">
            <h2 class="text-center">Job Results</h2>
            <div class="row">
                <?php if (mysqli_num_rows($jobs_result) > 0): ?>
                    <?php while ($job = mysqli_fetch_assoc($jobs_result)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $job['title']; ?></h5>
                                    <p class="card-text"><strong>Company:</strong> <?php echo $job['company']; ?></p>
                                    <p class="card-text"><?php echo substr($job['description'], 0, 100) . '...'; ?></p>
                                    <p class="card-text"><strong>Location:</strong> <?php echo $job['location']; ?></p>
                                    <p class="card-text"><strong>Salary:</strong> $<?php echo $job['salary']; ?></p>
                                    <a href="job_details.php?job_id=<?php echo $job['id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">No jobs found matching your search criteria.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<!--    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 JobPortal. All rights reserved.</p>
    </footer>-->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>








