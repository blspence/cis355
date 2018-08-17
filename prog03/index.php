<!--************************************************************************
    * AUTHOR     : Brionna Spencer
    * ASSIGNMENT : cis355 Prog03 - CRUD OO PHP & File Upload
    * URL        : http://localhost/scripts/cis355/prog03/index.php
    ************************************************************************ -->

<?php
    require "../database/database.php";
    require "customers.class.php";

    /***************************************************************************
     * NetBeans ERROR SUPRESSION
     **************************************************************************/
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


    /***************************************************************************
     * FUNCTION DEFINITIONS
     **************************************************************************/

    function main()
    {
        $cust = new Customers();

        if(isset($_POST["name"]))
        {
            $cust->name = $_POST["name"];
        }

        if(isset($_POST["email"]))
        {
            $cust->email = $_POST["email"];
        }

        if(isset($_POST["mobile"]))
        {
            $cust->mobile = $_POST["mobile"];
        }

        if(isset($_GET["fnc"]))
        {
            $fnc = $_GET["fnc"];
        }
        else
        {
            $fnc = "id_LIST_RECORDS";
        }

        switch($fnc)
        {
            case "id_FORM_CREATE":
                $cust->form_create();
                break;
            case "id_FORM_READ":
                $cust->form_read();
                break;
            case "id_FORM_UPDATE":
                $cust->form_update();
                break;
            case "id_FORM_DELETE":
                $cust->form_delete();
                break;
            case "id_DB_MOD_CREATE":
                $cust->db_mod_create();
                break;
            case "id_DB_MOD_UPDATE":
                $cust->db_mod_update();
                break;
            case "id_DB_MOD_DELETE":
                $cust->db_mod_delete();
                break;
            case "id_LIST_RECORDS":
            default:
                $cust->list_records();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- TAB-TITLE/FAVICON ************************************************* -->
    <title>Prog03</title>
    <link rel="icon" href="../img/cardinal_logo.png" type="image/png" />

    <!-- METADATA ********************************************************** -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Brionna Spencer" />
    <meta name="copyright" content="Brionna Spencer" />
    <meta name="keywords" content="web, development, server side, back end" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- LOCAL CSS CONFIG ************************************************** -->
    <link rel="stylesheet" type="text/css" href="../css/cis355.css">

    <!-- BOOTSTRAP CONFIG ************************************************** -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <!-- HTML Body Container *********************************************** -->
    <div class="container">

        <!-- GitHub Button ************************************************* -->
        <div class="btn-group" role="group">
            <a href="https://github.com/blspence/cis355/tree/master/prog03"
               target="_blank"
               class="btn btn-primary"
               role="button"
               aria-pressed="false">
                   Go to GitHub
            </a>
        </div>
        <!-- Course Lookup ************************************************* -->
        <div class="row">
            <div class=".col-md-12">
                <br/>
                <h1>Table: 'Customers' in 'blspence' Database</h1>
            </div>
        </div>
        <!-- main() call *************************************************** -->
        <div class="row">
            <?php main();?>
            <br/><br/>
        </div> <!-- END: <div class="row"> -->
    </div> <!-- END: <div class="container"> -->
</body>

</html>