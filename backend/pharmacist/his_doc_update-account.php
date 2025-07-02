<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$pharm_id = $_SESSION['pharm_id'];

// === Update Profile ===
if (isset($_POST['update_profile'])) {
    $pharm_name = $_POST['pharm_name'];
    $pharm_email = $_POST['pharm_email'];
    $pharm_dpic = $_FILES["pharm_dpic"]["name"];

    if (!empty($pharm_dpic)) {
        move_uploaded_file($_FILES["pharm_dpic"]["tmp_name"], "assets/images/users/" . $pharm_dpic);
    } else {
        // Get current picture if no new image is uploaded
        $res = $mysqli->query("SELECT pharm_dpic FROM his_pharmacist_accounts WHERE id = $pharm_id");
        $existing = $res->fetch_assoc();
        $pharm_dpic = $existing['pharm_dpic'];
    }

    $query = "UPDATE his_pharmacist_accounts SET username = ?, email = ?, pharm_dpic = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssi', $pharm_name, $pharm_email, $pharm_dpic, $pharm_id);
    $stmt->execute();

    $success = $stmt ? "Profile Updated" : "Please Try Again Later";
}

// === Update Password ===
if (isset($_POST['update_pwd'])) {
    $pharm_number = $_SESSION['pharm_number'];
    $pharm_pwd = sha1(md5($_POST['doc_pwd']));

    $query = "UPDATE his_pharmacist_accounts SET password = ? WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ss', $pharm_pwd, $pharm_number);
    $stmt->execute();

    $success = $stmt ? "Password Updated" : "Please Try Again Later";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php'); ?>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php'); ?>
        <?php include('assets/inc/sidebar.php'); ?>

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

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title"><?php echo $row->username; ?>'s Profile</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Profile Image & Info -->
                        <div class="col-lg-4">
                            <div class="card-box text-center">
                                <img src="assets/images/users/<?php echo $row->pharm_dpic ?? 'default.png'; ?>" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                <div class="mt-3">
                                    <p class="text-muted"><strong>Username:</strong> <?php echo $row->username; ?></p>
                                    <p class="text-muted"><strong>Email:</strong> <?php echo $row->email; ?></p>
                                    <p class="text-muted"><strong>ID:</strong> <?php echo $_SESSION['pharm_number']; ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Update Form -->
                        <div class="col-lg-8">
                            <div class="card-box">
                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#update-profile" data-toggle="tab" class="nav-link active">Update Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#update-password" data-toggle="tab" class="nav-link">Change Password</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="update-profile">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="pharm_name" class="form-control" value="<?php echo $row->username; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="pharm_email" class="form-control" value="<?php echo $row->email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Profile Picture</label>
                                                <input type="file" name="pharm_dpic" class="form-control">
                                            </div>
                                            <button type="submit" name="update_profile" class="btn btn-success">Save Changes</button>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="update-password">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="doc_pwd" class="form-control" required>
                                            </div>
                                            <button type="submit" name="update_pwd" class="btn btn-success">Update Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->

                </div>
            </div>
            <?php include("assets/inc/footer.php"); ?>
        </div>
        <?php } ?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
