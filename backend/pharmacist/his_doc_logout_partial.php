<?php
    session_start();
    unset($_SESSION['pharm_id']);
    unset($_SESSION['doc_number']);
    session_destroy();

    header("Location: his_doc_logout.php");
    exit;
?>