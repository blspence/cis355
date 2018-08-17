<?php

class Customers
{
    public $id;
    public $name;
    public $email;
    public $mobile;

    private $nameError = null;
    private $emailError = null;
    private $mobileError = null;

    private $title = "Customer";

    function form_create()
    {
        echo '<html lang="en">                                              ';
        echo '<head>                                                        ';
        echo '    <meta charset="utf-8">                                    ';
        echo '    <link href="../../css/bootstrap.min.css" rel="stylesheet">';
        echo '    <link href="../../css/cis355.css" rel="stylesheet">       ';
        echo '</head>                                                       ';
        echo '                                                              ';
        echo '<body>                                                        ';
        echo '    <div class="container">                                   ';
        echo '        <div class="span10 offset1">                          ';
        echo '            <div class="row">                                 ';
        echo "                <h3>Create a $this->title</h3>                ";
        echo '            </div>                                            ';
        echo '            <form class="form-horizontal"                     ';
        echo '                  action="index.php?fnc=id_DB_MOD_CREATE"     ';
        echo '                  method="post">                              ';

        $this->control_group("name", 'Name', $this->nameError, $this->name);
        $this->control_group("email", 'Email Address', $this->emailError, $this->email);
        $this->control_group("mobile", 'Mobile Number', $this->mobileError, $this->mobile);

        echo '                <div class="form-actions">                    ';
        echo '                  <button type="submit"                       ';
        echo '                          class="btn btn-success">            ';
        echo '                              Create</button>                 ';
        echo '                    <a class="btn" href="index.php">Back</a>  ';
        echo '                </div>                                        ';
        echo '            </form>                                           ';
        echo '        </div>                                                ';
        echo '    </div>                                                    ';
        echo '</body>                                                       ';
        echo '</html>                                                       ';
    }

    function form_delete()
    {
        echo "
        <html>
            <head>
                <title>Delete a $this->title</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>

            <body>
                <div class='container'>

                    <div class='span10 offset1'>
                        <p class='row'>
                            <h3>Delete a $this->title</h3>
                        </p>
                        <form class='form-horizontal' action='index.php?fnc=id_DB_MOD_DELETE' method='post'>
                            Are you sure you want to delete?
                            <div class='form-actions'>
                                <button type='submit' class='btn btn-success'>Yes</button>
                                <a class='btn' href='index.php'>No</a>
                            </div>
                        </form>
                    </div>

                </div> <!-- /container -->
            </body>
        </html>
                    ";
    }

    function form_read()
    {
        $id = null;

        if(!empty($_GET['id']))
        {
            $id = $_REQUEST['id'];
        }

        if(null == $id)
        {
            header("Location: index.php");
        }
        else
        {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM customers where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
        };

        echo '<html lang="en">                                              ';
        echo '<head>                                                        ';
        echo '    <meta charset="utf-8">                                    ';
        echo '    <link href="../../css/bootstrap.min.css" rel="stylesheet">';
        echo '    <link href="../../css/cis355.css" rel="stylesheet">       ';
        echo '</head>                                                       ';
        echo '                                                              ';
        echo '<body>                                                        ';
        echo '    <div class="container">                                   ';
        echo '        <div class="span10 offset1">                          ';
        echo '            <div class="row">                                 ';
        echo "                <h3>Read a $this->title</h3>                  ";
        echo '            </div>                                            ';
        echo '            <div class="form-horizontal">                     ';

        $this->control_group_read("Name", $data["name"]);
        $this->control_group_read("Email Address", $data["mobile"]);
        $this->control_group_read("Mobile Number", $data["email"]);

        echo '                <div class="form-actions">                    ';
        echo '                    <a class="btn" href="index.php">Back</a>  ';
        echo '                </div>                                        ';
        echo '            </div>                                            ';
        echo '        </div>                                                ';
        echo '    </div>                                                    ';
        echo '</body>                                                       ';
        echo '</html>                                                       ';
    }

    function form_update()
    {
        echo 'IN FUNC: form_update() <br/>';

        echo '<html lang="en">                                              ';
        echo '<head>                                                        ';
        echo '    <meta charset="utf-8">                                    ';
        echo '    <link href="../../css/bootstrap.min.css" rel="stylesheet">';
        echo '    <link href="../../css/cis355.css" rel="stylesheet">       ';
        echo '</head>                                                       ';
        echo '                                                              ';
        echo '<body>                                                        ';
        echo '    <div class="container">                                   ';
        echo '        <div class="span10 offset1">                          ';
        echo '            <div class="row">                                 ';
        echo "                <h3>Update a $this->title</h3>                ";
        echo '            </div>                                            ';
        echo '            <form class="form-horizontal"                     ';
        echo '                  action="index.php?fnc=id_DB_MOD_UPDATE"     ';
        echo '                  method="post">                              ';

        $this->control_group("name", 'Name', $this->nameError, $this->name);
        $this->control_group("email", 'Email Address', $this->emailError, $this->email);
        $this->control_group("mobile", 'Mobile Number', $this->mobileError, $this->mobile);

        echo '                <div class="form-actions">                    ';
        echo '                  <button type="submit"                       ';
        echo '                          class="btn btn-success">            ';
        echo '                              Update</button>                 ';
        echo '                    <a class="btn" href="index.php">Back</a>  ';
        echo '                </div>                                        ';
        echo '            </form>                                           ';
        echo '        </div>                                                ';
        echo '    </div>                                                    ';
        echo '</body>                                                       ';
        echo '</html>                                                       ';
    }

    function list_records()
    {
        echo "
        <html>
            <head>
                <title>$this->title" . "s" . "</title>
                    ";
        echo "
                <meta charset='UTF-8'>
                <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
                    ";
        echo "
            </head>
            <body>
                <div class='container'>
                    <p>
                        <a href='index.php?fnc=id_FORM_CREATE' class='btn btn-success'>Create</a>
                    </p>
                    <div class='row'>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";
        $pdo = Database::connect();
        $sql = "SELECT * FROM customers ORDER BY id DESC";
        foreach($pdo->query($sql) as $row)
        {
            echo "<tr>";
            echo "<td>". $row["name"] . "</td>";
            echo "<td>". $row["email"] . "</td>";
            echo "<td>". $row["mobile"] . "</td>";
            echo "<td width=250>";
            echo "<a class='btn' href='index.php?fnc=id_FORM_READ&id=".$row["id"]."'>Read</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-success' href='index.php?fnc=id_DB_MOD_UPDATE&id=".$row["id"]."'>Update</a>";
            echo "&nbsp;";
            echo "<a class='btn btn-danger' href='index.php?fnc=id_DB_MOD_DELETE&id=".$row["id"]."'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        Database::disconnect();
        echo "
                            </tbody>
                        </table>
                    </div>
                </div>
            </body>
        </html>
        ";
    }

    function control_group_read($label, $val)
    {
        echo "<div class='control-group'>";
        echo "    <label class='control-label'>$label</label>";
        echo "    <div class='controls'>";
        echo "        <label class='checkbox'>";
        echo "            $val";
        echo "        </label>";
        echo "    </div>";
        echo "</div>";
    }

    function control_group($input, $label, $labelError, $val)
    {
        echo "<div class='control-group";
        echo !empty($labelError) ? 'error' : '';
        echo "'>";
        echo "<label class='control-label'>$label</label>";
        echo "<div class='controls'>";

        echo "<input name='$input' type='text' placeholder='$label' value='";
        echo !empty($val) ? $val : '';
        echo "'>";
        if(!empty($labelError))
        {
            echo "<span class='help-inline'>";
            echo $labelError;
            echo "</span>";
        }
        echo "</div>";
        echo "</div>";
    }

    function db_mod_create()
    {
        $valid = true;

        if(empty($this->name))
        {
            $this->nameError = 'Please enter Name';
            $valid = false;
        }

        if(empty($this->email))
        {
            $this->emailError = 'Please enter Email Address';
            $valid = false;
        }

        if(empty($this->mobile))
        {
            $this->mobileError = 'Please enter Mobile Number';
            $valid = false;
        }

        if($valid)
        {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->name, $this->email, $this->mobile));
            Database::disconnect();
            header("Location: index.php");
        }
        else
        {
            $this->form_create();
        }
    }

    function db_mod_update()
    {
        echo 'IN FUNC: db_mod_update() <br/>';

        $id = null;

        if(!empty($_GET['id']))
        {
            $id = $_REQUEST['id'];
        }

        if(null == $id)
        {
            header("Location: index.php");
        }

        $valid = true;

        if(empty($this->name))
        {
            $this->nameError = 'Please enter Name';
            $valid = false;
        }

        if(empty($this->email))
        {
            $this->emailError = 'Please enter Email Address';
            $valid = false;
        }

        if(empty($this->mobile))
        {
            $this->mobileError = 'Please enter Mobile Number';
            $valid = false;
        }

        if($valid)
        {
            echo '$valid <br/>';

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE customers  set name = ?, email = ?, mobile =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->name, $this->email, $this->mobile, $this->id));
            Database::disconnect();
            header("Location: index.php");
        }
        else
        {
            echo 'NOT $valid <br/>';

            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM customers where id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->mobile = $data['mobile'];
            Database::disconnect();

            $this->form_update();
        }
    }

    function db_mod_delete()
    {
        $id = 0;

        if(!empty($_GET['id']))
        {
            $id = $_REQUEST['id'];
        }

        if(!empty($_POST))
        {
            /* track post values */
            $id = $_POST['id'];

            /* delete data */
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM customers  WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            Database::disconnect();
            header("Location: customers.php");
        }
    }
}

?>