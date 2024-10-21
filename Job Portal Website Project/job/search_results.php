<?php
session_start();
include 'db.php';

// Handle the search query
$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    
    // Split the search terms by comma and trim whitespace
    $search_terms = array_map('trim', explode(',', $search));

    // Prepare the SQL query
    $query_parts = [];
    foreach ($search_terms as $term) {
        // Search in both title and company columns
        $query_parts[] = "(title LIKE '%$term%' OR company LIKE '%$term%')";
    }
    
    // Combine the query parts with OR
    $query = "SELECT * FROM jobs WHERE " . implode(' OR ', $query_parts);
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
    <title>Search Job Results</title>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                    <?php if ($_SESSION['role'] == 'employer'): ?>
                        <li><a href="employer_dashboard.php">Dashboard</a></li>
                    <?php else: ?>
                        <li><a href="seeker_profile.php">Profile</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="job-listing">
        <h2>Job Results</h2>
        <div class="job-list">
            <?php if (mysqli_num_rows($jobs_result) > 0): ?>
                <?php while ($job = mysqli_fetch_assoc($jobs_result)): ?>
                    <div class="job-item">
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']); ?></p>
                        <p><?php echo htmlspecialchars(substr($job['description'], 0, 100)) . '...'; ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                        <p><strong>Salary:</strong> $<?php echo number_format($job['salary'], 2); ?></p>
                        <a href="job_details.php?job_id=<?php echo $job['id']; ?>" class="btn">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No jobs found matching your search criteria.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 JobPortal. All rights reserved.</p>
    </footer>
</body>
</html>


