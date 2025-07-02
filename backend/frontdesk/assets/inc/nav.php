<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['fd_id'])) {
    echo "<p class='text-danger text-center'>Unable to load user session. Please log in again.</p>";
    return;
}

include('config.php');
$fd_id = $_SESSION['fd_id'];
$ret = "SELECT * FROM his_admin WHERE ad_id=? AND role='frontdesk'";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $fd_id);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_object()) {
?>

<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit"><i class="fe-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="assets/images/users/<?php echo $row->ad_dpic ?? 'default.png'; ?>" alt="dpic" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $row->ad_fname . " " . $row->ad_lname; ?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <a href="his_admin_logout_partial.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i> <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>

    <div class="logo-box">
        <a href="dashboard.php" class="logo text-center">
            <span class="logo-lg"><img src="assets/images/logo-light.png" alt="" height="18"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm-white.png" alt="" height="24"></span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
    </ul>
</div>

<?php
    }
else {
    echo "<div class='alert alert-danger text-center'>Unable to load user session. Please log in again.</div>";
}
?>
