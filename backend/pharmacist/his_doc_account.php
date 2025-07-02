<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$pharm_id = isset($_SESSION['pharm_id']) ? $_SESSION['pharm_id'] : null;
$pharm_number = isset($_SESSION['pharm_number']) ? $_SESSION['pharm_number'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php"); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <?php
        $ret = "SELECT * FROM his_pharmacist_accounts WHERE id = ?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $pharm_id);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
        ?>

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">My Profile</li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->username; ?>'s Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="card-box text-center">
                                <img src="assets/images/users/<?php echo $row->pharm_dpic ?? 'default.png'; ?>" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                                <div class="text-center mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Full Name:</strong> <span class="ml-2"><?php echo $row->username; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Pharmacist Number:</strong> <span class="ml-2"><?php echo $pharm_number; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span class="ml-2"><?php echo $row->email ?? 'N/A'; ?></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Placeholder Vitals Section (if needed) -->
                        <div class="col-lg-6 col-xl-6">
                            <div class="alert alert-info">No vitals available for pharmacists.</div>
                        </div>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php'); ?>
            <!-- end Footer -->
        </div>
        <?php } ?>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div> <!-- END wrapper -->

    <!-- Scripts -->
    <div class="rightbar-overlay"></div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>
