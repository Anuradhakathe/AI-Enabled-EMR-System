<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Handle delete action if triggered
if (isset($_GET['delete_id'])) {
    $appointment_id = intval($_GET['delete_id']);
    $stmt = $mysqli->prepare("DELETE FROM his_appointments WHERE appointment_id = ?");
    $stmt->bind_param('i', $appointment_id);
    if ($stmt->execute()) {
        $success = "Appointment deleted successfully.";
    } else {
        $err = "Failed to delete appointment.";
    }
}
?>

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
                            <h4 class="header-title">Manage Appointments</h4>

                            <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                            <?php if (isset($err)) echo "<div class='alert alert-danger'>$err</div>"; ?>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Mode</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
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
                                        ORDER BY a.appointment_date DESC, a.appointment_time ASC
                                    ";

                                    if ($stmt = $mysqli->prepare($query)) {
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($row = $result->fetch_object()) {
                                            echo "<tr>
                                                <td>{$row->appointment_id}</td>
                                                <td>" . htmlspecialchars($row->patient_name) . "</td>
                                                <td>" . ucfirst($row->patient_mode) . "</td>
                                                <td>Dr. {$row->doc_fname} {$row->doc_lname}</td>
                                                <td>{$row->appointment_date}</td>
                                                <td>" . date("g:i A", strtotime($row->appointment_time)) . "</td>
                                                <td>{$row->created_at}</td>
                                                <td>
                                                    <a href='?delete_id={$row->appointment_id}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this appointment?');\">Delete</a>
                                                </td>
                                              </tr>";
                                        }
                                        $stmt->close();
                                    } else {
                                        echo "<tr><td colspan='8' class='text-danger'>Error loading appointments: {$mysqli->error}</td></tr>";
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
