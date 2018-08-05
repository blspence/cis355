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
        <!-- TAB-TITLE/FAVICON ********************************************* -->
        <title>Login</title>
        <link rel="icon" href="../../img/cardinal_logo.png" type="image/png" />

        <!-- METADATA ****************************************************** -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="Brionna Spencer" />
        <meta name="copyright" content="Brionna Spencer" />
        <meta name="keywords" content="web, development, server side, back end" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- LOCAL CSS CONFIG ********************************************** -->
        <link rel="stylesheet" type="text/css" href="../../css/cis355.css">

        <!-- BOOTSTRAP CONFIG ********************************************** -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <script src="../../js/bootstrap.min.js"></script>
    </head>

    <body>
        <!-- HTML Body Container ******************************************* -->
        <div class="container">

            <!-- GitHub Button ********************************************* -->
            <div class="btn-group buttonClass" role="group">
                <a href="https://github.com/blspence/cis355/tree/master/prog02"
                   target="_blank"
                   class="btn btn-primary active"
                   role="button"
                   aria-pressed="false">
                       Go to GitHub
                </a>
            </div>

            <!-- Webpage Title ********************************************* -->
            <div class="row">
                <div class=".col-md-12">
                    <h1><strong>Login for PHP CRUD Tables</strong></h1>
                </div>
            </div>

            </br></br>

            <!-- Login Form ************************************************ -->
            <form class="form-horizontal" action="login.php" method="post">
                <input name="username" type="text" placeholder="username@domain.com" required>
                <input name="password" type="password" required>
                <button type="submit" class="btn btn-success">Login</button>

                <button type="submit" class="btn">
                    <a href='logout.php'>Logout</a>
                </button>

                </br></br>
                <p style='color: red;'><?php echo NEWLINE, $errorMsg; ?></p>
            </form>
        </div>
    </body>
</html>