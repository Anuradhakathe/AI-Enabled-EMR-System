<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('assets/inc/config.php');

$doc_id = $_SESSION['doc_id'] ?? 0;
$doc_number = $_SESSION['doc_number'] ?? '';

$stmt = $mysqli->prepare("SELECT * FROM his_docs WHERE doc_id = ? AND doc_number = ?");
$stmt->bind_param('is', $doc_id, $doc_number);
$stmt->execute();
$res = $stmt->get_result();

// If result found, use real data. Else, fallback values.
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_object();
    $doc_fname = $row->doc_fname;
    $doc_lname = $row->doc_lname;
    $doc_dpic = $row->doc_dpic;
} else {
    $doc_fname = 'Doctor';
    $doc_lname = '';
    $doc_dpic = 'default.png'; // You can replace with a real fallback image
}
?>

<!-- Navbar HTML starts here -->
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
                <img src="assets/images/users/<?php echo $doc_dpic; ?>" alt="dpic" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $doc_fname . ' ' . $doc_lname; ?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome, Doctor!</h6>
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

    <!-- Logo and left menu -->
    <div class="logo-box">
        <a href="his_doc_dashboard.php" class="logo text-center">
            <span class="logo-lg"><img src="assets/images/logo-light.png" alt="" height="18"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm-white.png" alt="" height="24"></span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light"><i class="fe-menu"></i></button>
        </li>
        <li class="dropdown d-none d-lg-block">
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button">
                Create New <i class="mdi mdi-chevron-down"></i>
            </a>
            <div class="dropdown-menu">
                <a href="his_doc_register_patient.php" class="dropdown-item"><i class="fe-activity mr-1"></i>Patient</a>
                <a href="his_doc_lab_report.php" class="dropdown-item"><i class="fe-hard-drive mr-1"></i>Laboratory Report</a>
            </div>
        </li>
    </ul>
</div>
