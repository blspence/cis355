<!DOCTYPE html>

<!--************************************************************************
    * AUTHOR     : Brionna Spencer
    * ASSIGNMENT : cis355 Prog02 CRUD with Login Screen
    * URL        : https://csis.svsu.edu/~blspence/cis355/prog02/
    * OVERVIEW   : PHP CRUD Tables with Login
    ************************************************************************ -->

<html lang="en">

<head>
    <!-- TAB-TITLE/FAVICON ************************************************* -->
    <title>Prog02</title>
    <link rel="icon" href="../img/cardinal_logo.png" type="image/png" />

    <!-- METADATA ********************************************************** -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Brionna Spencer" />
    <meta name="copyright" content="Brionna Spencer" />
    <meta name="keywords" content="web, development, server side, back end" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- LOCAL CSS CONFIG ************************************************** -->
    <link rel="stylesheet" type="text/css" href="css/cis355.css">

    <!-- BOOTSTRAP CONFIG ************************************************** -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <!-- HTML Body Container *********************************************** -->
    <div class="container">

        <!-- GitHub Button ************************************************* -->
        <div class="btn-group buttonClass" role="group">
            <a href="https://github.com/blspence/cis355/tree/master/prog02"
               target="_blank"
               class="btn btn-primary active"
               role="button"
               aria-pressed="false">
                   Go to GitHub
            </a>
        </div>

        <!-- Webpage Title ************************************************* -->
        <div class="row">
            <div class=".col-md-12">
                <h1><strong>PHP CRUD Tables</strong></h1>
            </div>
        </div>

        <!-- Table Options ************************************************* -->
        <div class="row">
            <p><a href="crud/create.php" class="btn btn-success">Create</a></p>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require '../database/database.php';
                        $pdo = Database::connect();
                        $sql = 'SELECT * FROM customers ORDER BY id DESC';
                        foreach($pdo->query($sql) as $row)
                        {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['mobile'] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn" href="crud/read.php?id='.$row['id'].'">Read</a>';
                            echo '&nbsp;';
                            echo '<a class="btn btn-success" href="crud/update.php?id='.$row['id'].'">Update</a>';
                            echo '&nbsp;';
                            echo '<a class="btn btn-danger" href="crud/delete.php?id='.$row['id'].'">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>