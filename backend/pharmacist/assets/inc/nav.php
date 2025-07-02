<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('assets/inc/config.php');

// Role + number detection
$user_number = 'Unknown';
$user_role = 'Unknown';
$user_name = 'User';
$user_dpic = 'default.png'; // fallback profile pic

// Pharmacist
if (isset($_SESSION['pharm_id']) && isset($_SESSION['pharm_number'])) {
    $user_number = $_SESSION['pharm_number'];
    $user_role = 'Pharmacist';

    $pharm_id = $_SESSION['pharm_id'];
    $stmt = $mysqli->prepare("SELECT * FROM his_pharmacist_accounts WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $pharm_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_object()) {
            $user_name = $row->username; // or use full name if available
            $user_dpic = isset($row->pharm_dpic) ? $row->pharm_dpic : 'default.png';
        }
    }

} else {
    // Optional fallback: Redirect to login if session is not set
    header("Location: ../doc/index.php");
    exit();
}
?>

<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <!-- Search bar -->
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

        <!-- User Info -->
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="assets/images/users/<?php echo $user_dpic; ?>" alt="dpic" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $user_name; ?> (<?php echo $user_role; ?>) <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome, <?php echo $user_role; ?>!</h6>
                </div>

                <a href="his_doc_update-account.php" class="dropdown-item notify-item">
                    <i class="fas fa-user-tag"></i>
                    <span>Update Account</span>
                </a>

                <div class="dropdown-divider"></div>

                <a href="his_doc_logout_partial.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>

    <!-- Logo -->
    <div class="logo-box">
        <a href="dashboard.php" class="logo text-center">
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="18">
            </span>
            <span class="logo-sm">
                <img src="assets/images/logo-sm-white.png" alt="" height="24">
            </span>
        </a>
    </div>

    <!-- Sidebar Toggle -->
    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
    </ul>
</div>
