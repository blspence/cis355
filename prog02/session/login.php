<?php
    session_start();
    require '../../database/database.php';

    /* constant definition */
    define("NEWLINE", "<br />\n");

    /* set $errorMsg as appropriate */
    if($_GET)
    {
        $errorMsg = $_GET['errorMsg'];
    }
    else
    {
        $errorMsg = '';
    }

    /* handle login functionality */
    if($_POST)
    {
        /* local variables */
        $success = false;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = MD5($password);

        /* connect to database */
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /* sql query */
        $sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password' LIMIT 1";
        $q = $pdo->prepare($sql);
        $q->execute(array());
        $data = $q->fetch(PDO::FETCH_ASSOC);

        /* determine if login was successful */
        if($data)
        {
            $_SESSION['username'] = $username;
            header("Location: ../index.php");
        }
        else
        {
            header("Location: login.php?errorMsg=Invalid credentials.");
            exit();
        }
    }
    else
    {
        /* no action required */
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="../js/bootstrap.min.js"></script>
    </head>

    <body>
        <h1>Login</h1>
        <form class="form-horizontal" action="login.php" method="post">
            <input name="username" type="text" placeholder="me@email.com" required>
            <input name="password" type="password" required>
            <button type="submit" class="btn btn-success">Login</button>

            </br></br>
            <a href='logout.php'>Logout</a>

            <p style='color: red;'>
                <?php echo NEWLINE, $errorMsg; ?>
            </p>

        </form>
    </body>
</html>