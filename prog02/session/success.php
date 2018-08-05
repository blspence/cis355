<?php
    session_start();
    require '../database/database.php';

    /* prevent unauthorized access */
    if(!$_SESSION)
    {
        header("Location: login.php");
    }
    else
    {
        echo "Login successful.";

        echo "";
        echo "</br></br>";
        echo "<a href='logout.php'>Logout</a>";
    }
?>