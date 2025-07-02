<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$success = $err = "";

// Handle Appointment Submission
if (isset($_POST['create_appointment'])) {
    $patient_name = trim($_POST['patient_name'] ?? '');
    $patient_mode = $_POST['patient_mode'] ?? '';
    $doctor_id = intval($_POST['doctor_id'] ?? 0);
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time_raw = $_POST['appointment_time'] ?? '';

    // Convert to 24-hour TIME format for DB
    $appointment_time = date("H:i:s", strtotime($appointment_time_raw));

    if (!$patient_name || !$patient_mode || !$doctor_id || !$appointment_date || !$appointment_time) {
        $err = "Please fill in all required fields.";
    } else {
        // Check for existing appointment at same slot
        $check = $mysqli->prepare("SELECT appointment_id FROM his_appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?");
        if ($check) {
            $check->bind_param('iss', $doctor_id, $appointment_date, $appointment_time);
            $check->execute();
            $res = $check->get_result();

            if ($res && $res->num_rows > 0) {
                $err = "This slot is already booked.";
            } else {
                $stmt = $mysqli->prepare("INSERT INTO his_appointments (patient_name, patient_mode, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param('ssiss', $patient_name, $patient_mode, $doctor_id, $appointment_date, $appointment_time);
                    if ($stmt->execute()) {
                        $success = "Appointment created successfully.";
                    } else {
                        $err = "Insert failed: " . $stmt->error;
                    }
                } else {
                    $err = "Prepare failed: " . $mysqli->error;
                }
            }
        } else {
            $err = "Database error: " . $mysqli->error;
        }
    }
}
?>
<?php if (isset($_POST['create_appointment']) && !empty($success)) { ?>
<script>
    setTimeout(function () {
        swal("Success", "<?php echo $success; ?>", "success");
    }, 200);
</script>
<?php } ?>

<?php if (isset($_POST['create_appointment']) && !empty($err)) { ?>
<script>
    setTimeout(function () {
        swal("Failed", "<?php echo $err; ?>", "error");
    }, 200);
</script>
<?php } ?>

<!DOCTYPE html>
<html lang="en">
<?php include("assets/inc/head.php"); ?>
<body>
<div id="wrapper">
    <?php include("assets/inc/nav.php"); ?>
    <?php include("assets/inc/sidebar.php"); ?>

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Create Appointment</h4>

                            <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
                            <?php if ($err) echo "<div class='alert alert-danger'>$err</div>"; ?>

                            <form method="post">
                                <div class="form-group">
                                    <label>Patient Name</label>
                                    <input type="text" name="patient_name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Patient Mode</label>
                                    <select name="patient_mode" class="form-control" required>
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Select Doctor</label>
                                    <select name="doctor_id" class="form-control" required>
                                        <option value="">-- Select Doctor --</option>
                                        <?php
                                        $result = $mysqli->query("SELECT doc_id, doc_fname, doc_lname, doc_dept FROM his_docs");
                                        while ($doc = $result->fetch_object()) {
                                            echo "<option value='{$doc->doc_id}'>Dr. {$doc->doc_fname} {$doc->doc_lname} ({$doc->doc_dept})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Appointment Date</label>
                                    <input type="date" name="appointment_date" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Appointment Time</label>
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

                                <button type="submit" name="create_appointment" class="btn btn-success">Create Appointment</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-box">
                            <h4 class="header-title">Today's Appointments</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Mode</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
$today = date('Y-m-d');

// Fetch today's appointments with doctor info
$query = "
    SELECT 
        a.*, 
        d.doc_fname, 
        d.doc_lname 
    FROM 
        his_appointments a 
    JOIN 
        his_docs d 
    ON 
        a.doctor_id = d.doc_id 
    WHERE 
        a.appointment_date = ? 
    ORDER BY 
        a.appointment_time
";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param('s', $today);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row->patient_name) . "</td>
                    <td>" . ucfirst($row->patient_mode) . "</td>
                    <td>Dr. " . htmlspecialchars($row->doc_fname) . " " . htmlspecialchars($row->doc_lname) . "</td>
                    <td>" . $row->appointment_date . "</td>
                    <td>" . date("g:i A", strtotime($row->appointment_time)) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center text-muted'>No appointments scheduled for today.</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='5' class='text-danger'>Failed to load appointments: " . $mysqli->error . "</td></tr>";
}
?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include("assets/inc/footer.php"); ?>
    </div>
</div>
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>
</body>
</html>