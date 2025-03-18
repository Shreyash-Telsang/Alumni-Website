<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group 8 | LinkedIn Jobs</title>

    <link rel="stylesheet" href="css/styles.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .card {
            width: 100%;
            border: none;
            box-shadow: 0 2px 2px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
        }
        .job-card {
            transition: transform 0.2s ease;
        }
        .job-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <?php
        include 'db_controller.php';
        $conn->select_db("Alumni_EDI");

        session_start();
        include 'logged_user.php';
    ?>

    <!-- Top nav bar -->
    <nav class="navbar sticky-top navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand mx-0 mb-0 h1" href="main_menu.php">Alumni Portal</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse me-5" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-1">
                        <a class="nav-link px-5" href="main_menu.php"><i class="bi bi-house-door nav-bi"></i></a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-5" href="view_alumni.php"><i class="bi bi-people nav-bi"></i></a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-5" href="view_events.php"><i class="bi bi-calendar-event nav-bi"></i></a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-5" href="view_advertisements.php"><i class="bi bi-megaphone nav-bi"></i></a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link px-5" href="linked_in_jobs_page.php"><i class="bi bi-linkedin nav-bi"></i></a>
                    </li>
                </ul>
            </div>
            <?php include 'nav_user.php' ?>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="container my-3">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="breadcrumb-link text-secondary link-underline link-underline-opacity-0" href="main_menu.php">Home</a></li>
                <li class="breadcrumb-item breadcrumb-active" aria-current="page">LinkedIn Jobs</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="container mb-5">
            <h1 class="slide-left">LinkedIn Jobs</h1>
            
            <!-- Search and Filter -->
            <div class="container mt-3 py-3 px-4 card bg-white fw-medium slide-left">
                <form id="jobsFilterForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                    <!-- Search box -->
                    <div class="input-group">
                        <input type="text" class="form-control py-2" placeholder="Search jobs by title, company, or location" name="search" aria-label="Search" aria-describedby="button-addon2" value="<?php echo (isset($_GET['search'])) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button class="btn btn-primary px-3 py-2" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Jobs Listing -->
            <div class="row row-cols-1 mt-4 px-0 mx-0 slide-left">
                <?php 
                    // Build the search query
                    $searchQuery = "";
                    if (isset($_GET['search']) && $_GET['search'] != "") {
                        $search = $conn->real_escape_string($_GET['search']);
                        $searchQuery = "WHERE 
                            title LIKE '%$search%' OR 
                            company LIKE '%$search%' OR 
                            location LIKE '%$search%'";
                    }

                    // Retrieve from database
                    $query = "SELECT * FROM linkedinjob $searchQuery ORDER BY created_at DESC";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($job = $result->fetch_assoc()) {
                ?>
                    <!-- Job Card -->
                    <div class="col mb-4 px-0 mx-0">
                        <div class="card job-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h3 class="card-title mb-2"><?php echo htmlspecialchars($job['title']); ?></h3>
                                        <h5 class="text-primary mb-2"><?php echo htmlspecialchars($job['company']); ?></h5>
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($job['location']); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <a href="<?php echo htmlspecialchars($job['apply_link']); ?>" target="_blank" class="btn btn-primary">
                                            Apply on LinkedIn <i class="bi bi-linkedin ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-clock"></i> Posted: <?php 
                                        $date = new DateTime($job['created_at']);
                                        echo $date->format('F j, Y');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                        }
                    } else {
                        // No jobs found
                        echo '<div class="text-center">';
                        echo '<div class="alert alert-info" role="alert">';
                        echo '<i class="bi bi-info-circle me-2"></i> No jobs found. Please try a different search term.';
                        echo '</div>';
                        echo '</div>';
                    }
                    $conn->close();
                ?>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>