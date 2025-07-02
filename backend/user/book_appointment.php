<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$user_id = $_SESSION['user_id'];
$success = $err = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $mode = $_POST['mode'];

    // Check if slot already booked
    $stmt = $mysqli->prepare("SELECT * FROM his_appointments WHERE doctor_id=? AND appointment_date=? AND appointment_time=?");
    $stmt->bind_param('iss', $doctor_id, $appointment_date, $appointment_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $err = "This slot is already booked.";
    } else {
        $user_stmt = $mysqli->prepare("SELECT name FROM his_users WHERE id=?");
        $user_stmt->bind_param('i', $user_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user_data = $user_result->fetch_object();
        $patient_name = $user_data->name;

        $insert = $mysqli->prepare("INSERT INTO his_appointments (patient_name, patient_mode, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param('ssiss', $patient_name, $mode, $doctor_id, $appointment_date, $appointment_time);

        if ($insert->execute()) {
            $success = "Appointment booked successfully.";
        } else {
            $err = "Failed to book appointment. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - AI Powered EMR</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../backend/admin/assets/images/favicon.ico">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .form-group label {
            font-weight: 500;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Book an Appointment</h2>

        <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if ($err) echo "<div class='alert alert-danger'>$err</div>"; ?>

        <div class="card">
            <form method="POST">
                <div class="form-group">
                    <label for="doctor_id">Select Doctor</label>
                    <select name="doctor_id" class="form-control" required>
                        <option value="">-- Choose Doctor --</option>
                        <?php
                        $docs = $mysqli->query("SELECT * FROM his_docs");
                        while ($row = $docs->fetch_object()) {
                            echo "<option value='{$row->doc_id}'> {$row->doc_fname} {$row->doc_lname} ({$row->doc_dept})</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointment_date">Date</label>
                    <input type="date" name="appointment_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="appointment_time">Time</label>
                    <select name="appointment_time" class="form-control" required>
                        <option value="09:00 AM">09:00 AM</option>
                        <option value="10:00 AM">10:00 AM</option>
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="12:00 PM">12:00 PM</option>
                        <option value="02:00 PM">02:00 PM</option>
                        <option value="03:00 PM">03:00 PM</option>
                        <option value="04:00 PM">04:00 PM</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mode">Mode</label>
                    <select name="mode" class="form-control" required>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Confirm Appointment</button>
            </form>
        </div>
    </div>

    <footer class="text-center">
        <p class="mb-0">&copy; 2025 AI Powered EMR System. All rights reserved.</p>
    </footer>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>