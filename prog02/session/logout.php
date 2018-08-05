<?php
    session_start();
    require '../database/database.php';

    session_destroy();
    header("Location: login.php?errorMsg=Logged out.");
    exit();
?>