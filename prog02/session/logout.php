<?php
    session_start();
    require '../../database/database.php';

    /* prevent unauthorized access */
    if(!$_SESSION)
    {
        header("Location: login.php");
    }
    else
    {
        session_destroy();
        header("Location: login.php?errorMsg=Logged out.");
        exit();
    }
?>