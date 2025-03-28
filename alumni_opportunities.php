<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group 8| Main Menu</title>

    <link rel="stylesheet" href="css/styles.css">

    <!-- Bootstrap CSS --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons --><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        .card {
            width: 23rem;
            border: none;
            box-shadow: 0 4px 4px rgba(0,0,0,.2);
        }

        .card-btn {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body>
    <?php
        session_start();

        include 'logged_user.php';
    ?>

    <!-- Top nav bar -->
    <nav class="navbar sticky-top navbar-expand-lg mb-5">
        <div class="container">
            <a class="navbar-brand mx-0 mb-0 h1" href="main_menu.php">Alumni Portal</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse me-5" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-1">
                        <a class="nav-link nav-main-active px-5" aria-current="page" href="main_menu.php"><i class="bi bi-house-door-fill nav-bi"></i></a>
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

    <div class="container slide-left">
        <div class="row justify-content-center">
        
        <div class="container slide-left">
        <div class="row justify-content-center">

            <!-- Hackathons -->
            <div class="col-auto mb-5 mx-auto">
                <div class="card text-center">
                    <img src="images/industrial_news.png" class="card-img-top" alt="Social Image">
                    <div class="card-body">
                        <h5 class="card-title">Hackathons</h5>
                        <p class="card-text">Stay on top of the World</p>
                    </div>
                    <div class="d-grid gap-2"> <a role="button" class="btn card-btn btn-primary fw-medium py-2" href="hackathons.php">Hackathons</a> </div>
                </div>
            </div>

            <!-- Webinars -->
            <div class="col-auto mb-5 mx-auto">
                <div class="card text-center">
                    <img src="images/social_event.png" class="card-img-top" alt="Social Event">
                    <div class="card-body">
                        <h5 class="card-title">Webinars</h5>
                        <p class="card-text">Keep an eye out below for our evolving list of events</p>
                    </div>
                    <div class="d-grid gap-2"> <a role="button" class="btn card-btn btn-primary fw-medium py-2" href="webinars.php">View Webinars</a> </div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="col-auto mb-5 mx-auto">
                <div class="card text-center">
                    <img src="images/advertisement_photo.png" class="card-img-top" alt="Advertisement Photo">
                    <div class="card-body">
                        <h5 class="card-title">Certifications</h5>
                        <p class="card-text">Access exclusive Competition, Courses to nurture your professional growth</p>
                    </div>
                    <div class="d-grid gap-2"> <a role="button" class="btn card-btn btn-primary fw-medium py-2" href="certifications.php">View Certifications</a> </div>
                </div>
            </div>
            
            <!-- Placeholder cards -->
            <div class="col-auto mb-5 mx-auto">
                <div class="card text-center"></div>
            </div>
            <div class="col-auto mb-5 mx-auto">
                <div class="card text-center"></div>
            </div>

        </div>
    </div>
    
    <!-- Boostrap JS --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>