<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['ad_id'];

if (isset($_GET['delete']) && isset($_GET['role'])) {
    $id = intval($_GET['delete']);
    $role = $_GET['role'];

    if ($role == 'doctor') {
        $query = "DELETE FROM his_docs WHERE doc_id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $id);
    } elseif ($role == 'pharmacist') {
        $query = "DELETE FROM his_pharmacist_accounts WHERE id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $id);
    } elseif ($role == 'frontdesk' || $role == 'labreporter') {
        $query = "DELETE FROM his_admin WHERE ad_id=? AND role=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('is', $id, $role);
    }

    if ($stmt && $stmt->execute()) {
        $success = ucfirst($role) . " removed successfully!";
    } else {
        $err = "Failed to delete. Try again.";
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
                <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                                            <li class="breadcrumb-item active">Manage Employees</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Manage Employees Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
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
                                                <th data-toggle="true">Name</th>
                                                <th data-hide="phone">Number</th>
                                                <th data-hide="phone">Department</th>
                                                <th data-hide="phone">Email</th>
                                                <th data-hide="phone">Action</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            $ret = "
                                            SELECT 
                                                doc_id AS id,
                                                CONCAT(doc_fname, ' ', doc_lname) AS name,
                                                doc_number AS number,
                                                doc_dept AS department,
                                                doc_email AS email,
                                                'doctor' AS role
                                            FROM his_docs
                                            UNION ALL
                                            SELECT 
                                                id AS id,
                                                full_name AS name,
                                                username AS number,
                                                '' AS department,
                                                email AS email,
                                                'pharmacist' AS role
                                            FROM his_pharmacist_accounts
                                            UNION ALL
                                            SELECT 
                                                ad_id AS id,
                                                CONCAT(ad_fname, ' ', ad_lname) AS name,
                                                fd_number AS number, -- 🔄 updated from ad_number
                                                '' AS department,
                                                ad_email AS email,
                                                role AS role
                                            FROM his_admin
                                            ";
                                            
                                        

                                        $res = $mysqli->query($ret);
                                        if (!$res) {
                                            die("Query failed: " . $mysqli->error);
                                        }
                                            $cnt = 1;

                                            while ($row = $res->fetch_object()) {
                                            ?>
                                            <tbody>
                                            <tr>
                                                <td><?php echo $cnt++; ?></td>
                                                <td><?php echo htmlspecialchars($row->name); ?> <span class="badge badge-info"><?php echo ucfirst($row->role); ?></span></td>
                                                <td><?php echo $row->number; ?></td>
                                                <td><?php echo !empty($row->department) ? $row->department : 'N/A'; ?></td>
                                                <td><?php echo $row->email; ?></td>
                                                <td>
                                                    <a href="his_admin_manage_employee.php?delete=<?php echo $row->id; ?>&role=<?php echo $row->role; ?>" class="badge badge-danger">
                                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                                    </a>
                                                    <a href="his_admin_view_single_employee.php?doc_id=<?php echo $row->id; ?>&doc_number=<?php echo $row->number; ?>" class="badge badge-success">
                                                        <i class="mdi mdi-eye"></i> View
                                                    </a>
                                                    <a href="his_admin_update_single_employee.php?doc_number=<?php echo $row->number; ?>" class="badge badge-primary">
                                                        <i class="mdi mdi-check-box-outline"></i> Update
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <?php } ?>

                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                 <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>