<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$doc_id = $_SESSION['doc_id'];
?>

<!DOCTYPE html>
<html lang="en">

<?php include('assets/inc/head.php'); ?>

<body>

    <div id="wrapper">
        <?php include("assets/inc/nav.php"); ?>
        <?php include("assets/inc/sidebar.php"); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">My Appointments</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Patient Name</th>
                                                <th>Mode</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $mysqli->prepare("SELECT * FROM his_appointments WHERE doctor_id = ? ORDER BY appointment_date DESC, appointment_time ASC");
                                            $stmt->bind_param('i', $doc_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $cnt = 1;
                                            while ($row = $result->fetch_object()) {
                                                echo "<tr>
                                                        <td>{$cnt}</td>
                                                        <td>{$row->patient_name}</td>
                                                        <td>" . ucfirst($row->patient_mode) . "</td>
                                                        <td>{$row->appointment_date}</td>
                                                        <td>{$row->appointment_time}</td>
                                                      </tr>";
                                                $cnt++;
                                            }
                                            if ($cnt === 1) {
                                                echo "<tr><td colspan='5' class='text-center text-muted'>No appointments found.</td></tr>";
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

            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>

    <div class="rightbar-overlay"></div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>
</html>
