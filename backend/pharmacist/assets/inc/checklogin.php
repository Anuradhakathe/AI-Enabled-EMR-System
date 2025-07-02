<?php 
function check_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $valid = (
        isset($_SESSION['doc_id']) ||
        isset($_SESSION['pharm_id']) ||
        isset($_SESSION['fd_id']) ||  // ✅ Corrected from frontdesk_id to fd_id
        isset($_SESSION['user_id']) ||
        isset($_SESSION['ad_id'])
    );

    if (!$valid) {
        header("Location: http://localhost/EMRV2/backend/doc/index.php");
        exit();
    }
}
?>
