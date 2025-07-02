<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$pharm_id = $_SESSION['pharm_id'];
$pay_pharm_number = $_SESSION['pharm_number']; // ✅ Replaces doc_number
?>

<!DOCTYPE html>
<html lang="en">

<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('assets/inc/nav.php'); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">My Payrolls</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">My Payrolls</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12 text-sm-center form-inline">
                                            <div class="form-group mr-2" style="display:none">
                                                <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                    <option value="">Show all</option>
                                                    <option value="Discharged">Discharged</option>
                                                    <option value="OutPatients">OutPatients</option>
                                                    <option value="InPatients">InPatients</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>My Name</th>
                                                <th>My Number</th>
                                                <th>Payroll Number</th>
                                                <th>My Salary</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM his_payrolls WHERE pay_doc_number = ?";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->bind_param('s', $pay_pharm_number);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            $cnt = 1;
                                            while ($row = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $cnt++; ?></td>
                                                    <td><?php echo $row->pay_doc_name; ?></td>
                                                    <td><?php echo $row->pay_doc_number; ?></td>
                                                    <td><?php echo $row->pay_number; ?></td>
                                                    <td>$ <?php echo $row->pay_emp_salary; ?></td>
                                                    <td>
                                                        <a href="his_doc_view_single_payroll.php?pay_number=<?php echo $row->pay_number; ?>" class="badge badge-success">
                                                            <i class="fas fa-eye"></i> View | Print Payroll
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="active">
                                                <td colspan="6">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!-- .table-responsive -->
                            </div> <!-- .card-box -->
                        </div> <!-- .col -->
                    </div> <!-- .row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include('assets/inc/footer.php'); ?>

        </div> <!-- content-page -->
    </div> <!-- wrapper -->

    <!-- Scripts -->
    <div class="rightbar-overlay"></div>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/libs/footable/footable.all.min.js"></script>
    <script src="assets/js/pages/foo-tables.init.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>
