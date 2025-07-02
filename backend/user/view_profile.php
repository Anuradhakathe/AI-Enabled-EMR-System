<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

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
    <title>My Profile - AI Powered EMR</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="icon" href="../../backend/admin/assets/images/favicon.ico">
    <style>
        .profile-card {
            max-width: 700px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
            background-color: #ffffff;
        }
        .profile-info label {
            font-weight: bold;
        }
        .logout-btn {
            position: absolute;
            right: 20px;
            top: 20px;
        }
        footer {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-4 position-relative">
        <h1>My Profile</h1>
        <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
    </header>

    <div class="container">
        <div class="profile-card">
            <h3 class="text-center">Welcome, <?php echo htmlspecialchars($user->name); ?></h3>
            <div class="profile-info">
                <p><label>User ID:</label> <?php echo htmlspecialchars($user->user_number); ?></p>
                <p><label>Email:</label> <?php echo htmlspecialchars($user->email); ?></p>
                <p><label>Gender:</label> <?php echo htmlspecialchars($user->gender); ?></p>
                <p><label>Age:</label> <?php echo htmlspecialchars($user->age); ?></p>
                <!-- <p><label>Contact:</label> <?php echo htmlspecialchars($user->contact); ?></p>
                <p><label>Address:</label> <?php echo htmlspecialchars($user->address); ?></p> -->
            </div>

            <div class="appointments-section mt-4">
                <h5>My Appointments</h5>
                <table class="table table-bordered mt-3">
                    <thead class="thead-light">
                        <tr>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Mode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $appt_sql = "SELECT a.*, d.doc_fname, d.doc_lname FROM his_appointments a JOIN his_docs d ON a.doctor_id = d.doc_id WHERE a.patient_name = ? ORDER BY a.appointment_date DESC";
                        if ($appt_query = $mysqli->prepare($appt_sql)) {
                            $appt_query->bind_param('s', $user->name);
                            $appt_query->execute();
                            $appt_result = $appt_query->get_result();

                            if ($appt_result->num_rows > 0) {
                                while ($appt = $appt_result->fetch_object()) {
                                    echo "<tr>
                                            <td>{$appt->doc_fname} {$appt->doc_lname}</td>
                                            <td>{$appt->appointment_date}</td>
                                            <td>{$appt->appointment_time}</td>
                                            <td>{$appt->patient_mode}</td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No appointments found.</td></tr>";
                            }
                            $appt_query->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="prescription-section mt-5">
                <h5>My Prescriptions</h5>
                <table class="table table-bordered mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Prescription</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 bg-light mt-auto">
        <p class="mb-0">&copy; 2025 AI Powered EMR System. All rights reserved.</p>
    </footer>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
