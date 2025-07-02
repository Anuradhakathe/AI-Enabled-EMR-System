<?php
session_start();
include('../admin/assets/inc/config.php');
include('../user/assets/inc/checklogin.php');
check_login();

// Assuming user ID is stored in session after login
$user_id = $_SESSION['user_id'];
$ret = $mysqli->prepare("SELECT * FROM his_users WHERE id = ?");
$ret->bind_param('i', $user_id);
$ret->execute();
$res = $ret->get_result();
$user = $res->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - AI Powered EMR</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../backend/admin/assets/images/favicon.ico">
    <style>
    html, body {
        height: 100%;
        margin: 0;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: transform 0.2s ease-in-out;
        flex: 1;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 230px;
    }

    .service-icon {
        font-size: 40px;
        color: #007bff;
        margin-bottom: 15px;
    }

    footer {
        background: #f8f9fa;
    }
</style>



</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Welcome, <?php echo htmlspecialchars($user->name); ?></h1>
        <p>Manage your health with AI-powered assistance</p>
    </header>

    <!-- Main Content -->
    <main class="flex-fill container my-5">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <div class="card w-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <i class="fa fa-calendar-check-o service-icon"></i>
                        <h5>Book Appointment</h5>
                        <p>Schedule an appointment with your preferred doctor.</p>
                        <a href="book_appointment.php" class="btn btn-primary mt-3">Book Now</a>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <div class="card w-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <i class="fa fa-user service-icon"></i>
                        <h5>My Profile</h5>
                        <p>View and manage your personal details.</p>
                        <a href="view_profile.php" class="btn btn-primary mt-3">View Profile</a>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <div class="card w-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <i class="fa fa-heartbeat service-icon"></i>
                        <h5>Health Assessment</h5>
                        <p>Take an AI-powered symptom assessment test.</p>
                        <a href="symptom_checker.php" class="btn btn-primary mt-3">Start Assessment</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-auto">
        <p class="mb-0">&copy; 2025 AI Powered EMR System. All rights reserved.</p>
    </footer>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
