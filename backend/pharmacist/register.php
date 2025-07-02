<?php
session_start();
include('assets/inc/config.php'); // DB connection

if (isset($_POST['user_register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $user_number = $_POST['user_number']; // Can be patient ID
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password match check
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    $password = sha1(md5($password)); // Double hash (keep consistent)

    $user_type = 'patient'; // Hardcoded role

    // Check if user already exists in his_users
    $stmt = $mysqli->prepare("SELECT user_number FROM his_users WHERE user_number=? OR email=?");
    if (!$stmt) {
        die("Prepare failed (SELECT): " . $mysqli->error);
    }
    $stmt->bind_param('ss', $user_number, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "User already registered with this Email or ID.";
        header("Location: register.php");
        exit();
    }

    // Insert new user into his_users
    $stmt = $mysqli->prepare("INSERT INTO his_users (user_type, name, email, phone, user_number, password) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed (INSERT): " . $mysqli->error);
    }
    $stmt->bind_param('ssssss', $user_type, $name, $email, $phone, $user_number, $password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: register.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>AI Powered EMR System - User Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AI EMR System" name="description" />
    <meta content="MartDevelopers" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Load Sweet Alert -->
    <script src="assets/js/swal.js"></script>

    <?php if (isset($_SESSION['success'])) { ?>
        <script>
            setTimeout(function () { 
                swal("Success", "<?php echo $_SESSION['success']; ?>", "success");
            }, 100);
        </script>
    <?php unset($_SESSION['success']); } ?>

    <?php if (isset($_SESSION['error'])) { ?>
        <script>
            setTimeout(function () { 
                swal("Failed", "<?php echo $_SESSION['error']; ?>", "error");
            }, 100);
        </script>
    <?php unset($_SESSION['error']); } ?>
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
                            <p class="text-muted mb-4 mt-3">Fill in the details to register for an account.</p>
                        </div>

                        <form method="POST">


                            <div class="form-group mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" required placeholder="Enter your full name">
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required placeholder="Enter your email">
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" name="phone" required placeholder="Enter your phone number">
                            </div>

                            <div class="form-group mb-3">
                                <label for="user_number">User Number (Doctor ID, Patient ID, etc.)</label>
                                <input type="text" class="form-control" name="user_number" required placeholder="Enter your ID">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm your password">
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success btn-block" name="user_register" type="submit"> Register </button>
                            </div>

                        </form>

                    </div> <!-- end card-body -->
                </div> <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p>Already have an account? <a href="index.php" class="text-white-50 ml-1">Login here</a></p>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</div> <!-- end page -->

<?php include ("assets/inc/footer1.php"); ?>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

</body>
</html>
