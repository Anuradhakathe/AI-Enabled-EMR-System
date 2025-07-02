<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$doc_id = $_SESSION['doc_id'];

// Cancel appointment
if (isset($_GET['cancel'])) {
    $appointment_id = intval($_GET['cancel']);
    $stmt = $mysqli->prepare("DELETE FROM his_appointments WHERE appointment_id = ? AND doctor_id = ?");
    $stmt->bind_param("ii", $appointment_id, $doc_id);
    if ($stmt->execute()) {
        $success = "Appointment cancelled successfully.";
    } else {
        $err = "Failed to cancel appointment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include('assets/inc/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Manage Appointments</h4>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
                    <?php if (isset($err)) { echo "<div class='alert alert-danger'>$err</div>"; } ?>

                    <div class="card-box">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Patient Name</th>
                                        <th>Mode</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM his_appointments WHERE doctor_id = ? ORDER BY appointment_date DESC, appointment_time DESC";
                                    $stmt = $mysqli->prepare($query);
                                    $stmt->bind_param("i", $doc_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $count = 1;
                                    while ($row = $result->fetch_object()) {
                                        echo "<tr>
                                            <td>{$count}</td>
                                            <td>{$row->patient_name}</td>
                                            <td>" . ucfirst($row->patient_mode) . "</td>
                                            <td>{$row->appointment_date}</td>
                                            <td>" . date('g:i A', strtotime($row->appointment_time)) . "</td>
                                            <td>
                                                <a href='?cancel={$row->appointment_id}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to cancel this appointment?');\">Cancel</a>
                                            </td>
                                        </tr>";
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
