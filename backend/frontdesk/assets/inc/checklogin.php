<?php
function check_login() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['fd_id']) || strlen($_SESSION['fd_id']) == 0) {
        header("Location: http://localhost/EMRV2/backend/doc/index.php");
        exit();
    }
}
?>
