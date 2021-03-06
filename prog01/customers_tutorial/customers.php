<!DOCTYPE html>
<html lang="en">
<head>
    <title>Prog01 - Customers</title>
    <link rel="icon" href="../../img/cardinal_logo.png" type="image/png" />
    <meta charset="utf-8">
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <script src="../../js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <h3>Customers</h3>
        </div>
        <div class="row">
            <p><a href="../index.php" class="btn">HOME</a></p>
            <p><a href="create.php" class="btn btn-success">Create</a></p>

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
                    require '../../database/database.php';
                    $pdo = Database::connect();
                    $sql = 'SELECT * FROM customers ORDER BY id DESC';
                    foreach($pdo->query($sql) as $row)
                    {
                        echo '<tr>';
                        echo '<td>'. $row['name'] . '</td>';
                        echo '<td>'. $row['email'] . '</td>';
                        echo '<td>'. $row['mobile'] . '</td>';
                        echo '<td width=250>';
                        echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
                        echo '&nbsp;';
                        echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                        echo '&nbsp;';
                        echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
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