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
     * GLOBAL VARIABLES
     **************************************************************************/
    /* $GLOBALS['api_base_addr'] */
    $api_base_addr = "https://api.svsu.edu/courses?prefix=";

    /* custom 'struct' type */
    class listingType
    {
        public $lineNumber;
        public $listingStr;
        public $days;
    }


    /***************************************************************************
     * FUNCTION DEFINITIONS
     **************************************************************************/

    function main()
    {
        /* todo */
        echo 'in main()';
        echo '<br/><br/>';

        $cust = new Customers();

        if(isset($_POST["name"])) $cust->name = $_POST["name"];
        if(isset($_POST["email"])) $cust->email = $_POST["email"];
        if(isset($_POST["mobile"])) $cust->mobile = $_POST["mobile"];

        if(isset($_GET["fun"])) $fun = $_GET["fun"];
        else $fun = 0;

        switch ($fun)
        {
            case 1: // create
                $cust->create_record();
                break;
            case 2: // read
                $cust->read_record();
                break;
            case 3: // update
                $cust->update_record();
                break;
            case 4: // delete
                $cust->delete_record();
                break;
            case 11: // insert database record from create_record()
                $cust->insert_record();
                break;
            case 33: // update database record from update_record()
                $cust->insert_update_record();
                break;
            case 44: // delete database record from delete_record()
                $cust->delete_update_record();
                break;
            case 0: // list
            default: // list
                $cust->list_records();
        }
    }


    /***************************************************************************
     * FUNCTION todo: TODO
     **************************************************************************/
    function todo($param)
    {
        return $param;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- TAB-TITLE/FAVICON ************************************************* -->
    <title>Customers - File Upload</title>
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
                <h1> <!--style="color:white;"> -->
                    PHP CRUD Tables</strong>
                </h1>
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