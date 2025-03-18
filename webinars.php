<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group 8 | Webinars</title>

    <link rel="stylesheet" href="css/styles.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
            <!-- More navbar content here -->
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="container my-3">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="breadcrumb-link text-secondary link-underline link-underline-opacity-0" href="main_menu.php">Home</a></li>
                <li class="breadcrumb-item breadcrumb-active" aria-current="page">Webinars</li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="container mb-5">
            <h1 class="slide-left">Upcoming Webinars</h1>
            
            <!-- Search and Filter -->
            <div class="container mt-3 py-3 px-4 card bg-white fw-medium slide-left">
                <form id="webinarsFilterForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control py-2" placeholder="Search webinars by title, organizer, or location" name="search" aria-label="Search" value="<?php echo (isset($_GET['search'])) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button class="btn btn-primary px-3 py-2" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Webinars Listing -->
            <div class="row row-cols-1 mt-4 px-0 mx-0 slide-left">
                <?php 
                    // Build the search query for webinars
                    $searchQuery = "";
                    if (isset($_GET['search']) && $_GET['search'] != "") {
                        $search = $conn->real_escape_string($_GET['search']);
                        $searchQuery = "WHERE 
                            event_name LIKE '%$search%' OR 
                            organizer LIKE '%$search%' OR 
                            location LIKE '%$search%'";
                    }

                    // Retrieve webinars from database
                    $query = "SELECT * FROM webinars $searchQuery ORDER BY created_at DESC";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($webinar = $result->fetch_assoc()) {
                ?>
                    <!-- Webinar Card -->
                    <div class="col mb-4 px-0 mx-0">
                        <div class="card job-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h3 class="card-title mb-2"><?php echo htmlspecialchars($webinar['event_name']); ?></h3>
                                        <h5 class="text-primary mb-2"><?php echo htmlspecialchars($webinar['organizer']); ?></h5>
                                    </div>
                                    <div>
                                        <a href="<?php echo htmlspecialchars($webinar['registration_link']); ?>" target="_blank" class="btn btn-primary">
                                            Register Now <i class="bi bi-pencil-square ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-clock"></i> Date: <?php 
                                        $date = new DateTime($webinar['event_date']);
                                        echo $date->format('F j, Y');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                        }
                    } else {
                        // No webinars found
                        echo '<div class="text-center">';
                        echo '<div class="alert alert-info" role="alert">';
                        echo '<i class="bi bi-info-circle me-2"></i> No webinars found. Please try a different search term.';
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
</body>
</html>
