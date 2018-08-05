<?php
    /* NEWLINE constant */
    define("NEWLINE", "<br />\n");

    /* Start print statement */
    echo "BEGIN PHP", NEWLINE;

    session_start();
    print_r($_SESSION);
    $_SESSION['username'] = "blspence@svsu.edu";




    /* Start print statement */
    echo NEWLINE, "END PHP", NEWLINE;
?>