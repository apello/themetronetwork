<?php


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    //if the last activity was 30 minutes ago
    //header to logout   
    session_unset();
    session_destroy();

    header("Location: http://localhost:8888/themetronetwork/index.php?alert=timed-out");
    exit();
} 


