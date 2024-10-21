<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobPortal - Find Your Dream Job</title>
    
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <header class="bg-primary py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-white">JobPortal</h1>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
                        <li class="nav-item"><a href="jobs.php" class="nav-link text-white">Find Jobs</a></li>
                        <li class="nav-item"><a href="admin_login.php" class="nav-link text-white">Admin Login</a></li> <!-- Added Admin Login Link -->

                        <!-- Conditional display for user login -->
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
                </nav>
            </div>
        </div>
    </header>

   
    <section class="hero bg-light py-5">
        <div class="container text-center">
            <h2 class="display-4">Find Your Dream Job Today</h2>
            <p class="lead">Search jobs by company, title, or location from thousands of available listings.</p>

           
            <form method="POST" action="jobs.php" class="form-inline justify-content-center">
                <input type="text" name="search" class="form-control mr-2 mb-2" placeholder="Search by company, job title, or location" required>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>

            
            <img src="picture2.webp" alt="Job Search Image" class="img-fluid mt-4 hero-image" style="max-width: 100%; height: auto;">
        </div>
    </section>

  

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>














