<?php 
session_start();
include('assets/inc/config.php');

if (isset($_POST['doc_login'])) {
    $user_type = $_POST['user_type'];
    $username = $_POST['doc_number'];
    $password = sha1(md5($_POST['doc_pwd']));

    if ($user_type == "Doctor") {
        $stmt = $mysqli->prepare("SELECT doc_number, doc_pwd, doc_id FROM his_docs WHERE doc_number=? AND doc_pwd=?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->bind_result($doc_number, $doc_pwd, $doc_id);
        if ($stmt->fetch()) {
            $_SESSION['doc_id'] = $doc_id;
            $_SESSION['doc_number'] = $doc_number;
            $_SESSION['role'] = 'doctor';
            header("Location: his_doc_dashboard.php");
            exit();
        } else {
            $err = "Invalid Doctor Credentials.";
        }

    } elseif ($user_type == "Pharmacist") {
        $stmt = $mysqli->prepare("SELECT id, username FROM his_pharmacist_accounts WHERE username=? AND password=?");
        if (!$stmt) die("Prepare failed: " . $mysqli->error);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->bind_result($pharm_id, $pharm_number);
        if ($stmt->fetch()) {
            $_SESSION['pharm_id'] = $pharm_id;
            $_SESSION['pharm_number'] = $pharm_number;
            $_SESSION['role'] = 'pharmacist';
            header("Location: ../pharmacist/dashboard.php");
            exit();
        } else {
            $err = "Invalid Pharmacist Credentials.";
        }

    } elseif ($user_type == "Front Desk") {
        $stmt = $mysqli->prepare("SELECT ad_id FROM his_admin WHERE fd_number = ? AND ad_pwd = ? AND role='frontdesk'");
        
        if (!$stmt) {
            die("Prepare failed: " . $mysqli->error);
        }
    
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->bind_result($fd_id);
    
        if ($stmt->fetch()) {
            $_SESSION['fd_id'] = $fd_id;
            $_SESSION['role'] = 'frontdesk';
            header("Location: ../frontdesk/dashboard.php");
            exit();
        } else {
            $err = "Invalid Front Desk Credentials.";
        }
    }
    

    } elseif ($user_type == "Patient/Customer") {
        $stmt = $mysqli->prepare("SELECT id FROM his_users WHERE user_number=? AND password=? AND user_type='patient'");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $stmt->bind_result($user_id);
        if ($stmt->fetch()) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = 'patient';
            header("Location: ../user/dashboard.php");
            exit();
        } else {
            $err = "Invalid Patient Credentials.";
        }

    } else {
        $err = "Invalid user type selected.";
    }
?>

<!--End Login-->
<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <title>AI Powered EMR System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="MartDevelopers" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!--Load Sweet Alert Javascript-->
        
        <script src="assets/js/swal.js"></script>
        <!--Inject SWAL-->
        <?php if(isset($success)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Success","<?php echo $success;?>","success");
                            },
                                100);
                </script>

        <?php } ?>

        <?php if(isset($err)) {?>
        <!--This code for injecting an alert-->
                <script>
                            setTimeout(function () 
                            { 
                                swal("Failed","<?php echo $err;?>","error");
                            },
                                100);
                </script>

        <?php } ?>



    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <a href="index.php">
                                        <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Select your role and enter credentials to access the panel.</p>
                            </div>

                            <form method='post'>
                            <div class="form-group mb-3">
                                <label for="user_type">Login As</label>
                                <select class="form-control" name="user_type" required>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Pharmacist">Pharmacist</option>
                                    <option value="Front Desk">Front Desk</option>
                                    <option value="Patient/Customer">Patient/Customer</option>
                                </select>
                            </div>

    <div class="form-group mb-3">
        <label for="emailaddress">ID Number</label>
        <input class="form-control" name="doc_number" type="text" id="emailaddress" required placeholder="Enter your ID number">
    </div>

    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input class="form-control" name="doc_pwd" type="password" required id="password" placeholder="Enter your password">
    </div>

    <div class="form-group mb-0 text-center">
        <button class="btn btn-success btn-block" name="doc_login" type="submit"> Log In </button>
    </div>
</form>



                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p><a href="his_doc_reset_pwd.php" class="text-white-50 ml-1">Forgot your password?</a></p>
                            <p><a href="register.php" class="text-white-50 ml-1">New User? Register here</a></p>
                            <p><a href="../../index.php" class="text-white-50 ml-1">← Back to Home Page</a></p>
                            <!-- <p class="text-white-50">Don't have an account? <a href="his_admin_register.php" class="text-white ml-1"><b>Sign Up</b></a></p>-->
                        </div> <!-- end col -->
                    </div>

                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <?php include ("assets/inc/footer1.php");?>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>