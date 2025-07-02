<?php
function check_login() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header("Location: /EMRV2/backend/user/index.php"); // Use absolute path
        exit();
    }
}
?>
