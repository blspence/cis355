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

<form class="form-horizontal" action="login.php" method="post">
    <input name="username" type="text" placeholder="me@email.com" required>
    <input name="password" type="password" required>
</form>