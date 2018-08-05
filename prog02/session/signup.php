<?php
    session_start();
    require '../../database/database.php';

    /* if not first time through */
    if(!empty($_POST))
    {
        /* initialize user input validation variables */
        $fnameError = null;
        $lnameError = null;
        $emailError = null;
        $mobileError = null;
        $passwordError = null;

        /* initialize $_POST variables */
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $passwordhash = MD5($password);

        /* validate user input */
        $valid = true;
        if(empty($fname))
        {
            $fnameError = 'Please enter First Name';
            $valid = false;
        }
        if(empty($lname))
        {
            $lnameError = 'Please enter Last Name';
            $valid = false;
        }

        /* prevent duplicate email addresses */
        if(empty($email))
        {
            $emailError = 'Please enter valid Email Address (REQUIRED)';
            $valid = false;
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
        $pdo = Database::connect();
        $sql = "SELECT * FROM users";
        foreach($pdo->query($sql) as $row)
        {
            if($email == $row['email'])
            {
                $emailError = 'Email has already been registered.';
                $valid = false;
            }
        }
        Database::disconnect();

        if(empty($mobile))
        {
            $mobileError = 'Please enter Mobile Number (or "none")';
            $valid = false;
        }

        /* restrict mobile number format */
        if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $mobile))
        {
            $mobileError = 'Please write Mobile Number in form 000-000-0000';
            $valid = false;
        }

        if(empty($password))
        {
            $passwordError = 'Please enter valid Password';
            $valid = false;
        }

        /* insert data */
        if($valid)
        {
            $pdo = Database::connect();

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (fname,lname,email,mobile,password) values(?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($fname, $lname, $email, $mobile, $passwordhash));

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
            $q = $pdo->prepare($sql);
            $q->execute(array($email, $passwordhash));
            $data = $q->fetch(PDO::FETCH_ASSOC);

            Database::disconnect();
            header("Location: login.php");
        }
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
            <div class="span10 offset1">

                <div class="row"><h3>Signup</h3></div>

                <form class="form-horizontal" action="signup.php" method="post">

                    <div class="control-group <?php echo !empty($fnameError)?'error':'';?>">
                        <label class="control-label">First Name</label>
                        <div class="controls">
                            <input name="fname" type="text"  placeholder="First Name" value="<?php echo !empty($fname)?$fname:'';?>">
                            <?php if(!empty($fnameError)): ?>
                                <span class="help-inline"><?php echo $fnameError;?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($lnameError)?'error':'';?>">
                        <label class="control-label">Last Name</label>
                        <div class="controls">
                            <input name="lname" type="text"  placeholder="Last Name" value="<?php echo !empty($lname)?$lname:'';?>">
                            <?php if(!empty($lnameError)): ?>
                                <span class="help-inline"><?php echo $lnameError;?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if(!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                        <label class="control-label">Mobile Number</label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Mobile Phone Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                        <label class="control-label">Password</label>
                        <div class="controls">
                            <input id="password" name="password" type="password"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
                            <?php if(!empty($passwordError)): ?>
                                <span class="help-inline"><?php echo $passwordError;?></span>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <a class="btn" href="login.php">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>