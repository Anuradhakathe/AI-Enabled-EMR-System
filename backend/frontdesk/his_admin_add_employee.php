<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
		if (isset($_POST['add_doc'])) {
    $fname = $_POST['doc_fname'];
    $lname = $_POST['doc_lname'];
    $email = $_POST['doc_email'];
    $pwd = sha1(md5($_POST['doc_pwd']));
    $role = $_POST['employee_role'];

    // Auto-generate a user ID/number
    $length = 5;
    $user_number = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);

    if ($role == 'doctor') {
        $stmt = $mysqli->prepare("INSERT INTO his_docs (doc_fname, doc_lname, doc_number, doc_email, doc_pwd) VALUES (?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Prepare failed (Doctor): " . $mysqli->error);
        }
    
        $stmt->bind_param('sssss', $fname, $lname, $user_number, $email, $pwd);
    }

    elseif ($role == 'pharmacist') {
        $full_name = $fname . " " . $lname;
        $stmt = $mysqli->prepare("INSERT INTO his_pharmacist_accounts (full_name, username, email, password) VALUES (?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Prepare failed (Pharmacist): " . $mysqli->error);
        }
    
        $stmt->bind_param('ssss', $full_name, $user_number, $email, $pwd);
    }    

    elseif ($role == 'frontdesk') {
        $stmt = $mysqli->prepare("INSERT INTO his_admin (ad_fname, ad_lname, ad_email, ad_pwd, role) VALUES (?, ?, ?, ?, 'frontdesk')");
        
        if (!$stmt) {
            die("Prepare failed (Front Desk): " . $mysqli->error);
        }
    
        $stmt->bind_param('ssss', $fname, $lname, $email, $pwd);
    }
    

    else {
        $err = "Invalid role selected.";
    }

    if (isset($stmt) && $stmt->execute()) {
        $success = ucfirst($role) . " successfully added!";
    } else {
        $err = "Failed to add employee. Error: " . $stmt->error;
    }
}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include("assets/inc/nav.php");?>
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
                                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                                            <li class="breadcrumb-item active">Add Employee</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Employee Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->

                                        <form method="post">
                                            <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputRole" class="col-form-label">Role</label>
                                                <select name="employee_role" class="form-control" required>
                                                    <option value="">Select Role</option>
                                                    <option value="doctor">Doctor</option>
                                                    <option value="pharmacist">Pharmacist</option>
                                                    <option value="frontdesk">Front Desk Executive</option>
                                                </select>
                                            </div>


                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">First Name</label>
                                                    <input type="text" required="required" name="doc_fname" class="form-control" id="inputEmail4" >
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Last Name</label>
                                                    <input required="required" type="text" name="doc_lname" class="form-control"  id="inputPassword4">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2" style="display:none">
                                                    <?php 
                                                        $length = 5;    
                                                        $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                    ?>
                                                    <label for="inputZip" class="col-form-label">Doctor Number</label>
                                                    <input type="text" name="doc_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
                                                </div>

                                            <div class="form-group">
                                                <label for="inputAddress" class="col-form-label">Email</label>
                                                <input required="required" type="email" class="form-control" name="doc_email" id="inputAddress">
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Password</label>
                                                    <input required="required" type="password" name="doc_pwd" class="form-control" id="inputCity">
                                                </div>
                                                
                                            </div>

                                            <button type="submit" name="add_doc" class="ladda-button btn btn-success" data-style="expand-right">Add Employee</button>

                                        </form>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
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

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>