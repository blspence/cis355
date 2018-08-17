<!--************************************************************************
    * AUTHOR     : Brionna Spencer
    * ASSIGNMENT : cis355 Prog04 - Parsing JSON with PHP
    * URL        : https://csis.svsu.edu/~blspence/cis355/prog04/index.php
    ************************************************************************ -->

<?php
    /***************************************************************************
     * NetBeans ERROR SUPRESSION (TODO: remove if not needed)
     **************************************************************************/
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


    /***************************************************************************
     * GLOBAL VARIABLES
     **************************************************************************/
    /* $GLOBALS['api_base_addr'] */
    $api_base_addr = "https://api.svsu.edu/courses?prefix=";


    /***************************************************************************
     * FUNCTION DEFINITIONS
     **************************************************************************/

    function main()
    {
        /* print CS/CIS/CSIS heading */
        echo '<h1 align="center">SVSU/CSIS Department</h1>';
        echo '<h2 align="center">';
        echo $_GET['prefix'] ? ' - Prefix: ' . strtoupper($_GET['prefix']) : "";
        echo $_GET['courseNumber'] ? ' - Course Number: ' . $_GET['courseNumber'] : "";
        echo $_GET['instructor'] ? ' - Instructor: ' . strtoupper($_GET['instructor']) : "";
        echo '</h2>';

        /* if user entered something in a search box, then call printCourses() to filter */
        if(($_GET['prefix'] != "") || ($_GET['courseNumber'] != "") || ($_GET['instructor'] != ""))
        {
            printCourses($_GET['prefix'], $_GET['courseNumber'], $_GET['instructor']);
        }
        /* otherwise call printSemester() for all courses for each semester */
        else
        {
            echo "<h3>Summer</h3>";
            printSemester("18/SU");
            echo "<h3>Fall</h3>";
            printSemester("18/FA");
            echo "<h3>Winter</h3>";
            printSemester("19/WI");
        }
    }


    /***************************************************************************
     * FUNCTION printForm: display the entry form for next search
     **************************************************************************/
    function printForm()
    {
        echo '<br />';
        echo '<br />';
        echo '<h2>Course Lookup</h2>';

        /* print user entry form */
        echo "<form action='courses.php'>";
        echo "Course Prefix (Department)<br/>";
        echo "<input type='text' placeholder='CS' name='prefix'><br/>";
        echo "Course Number<br/>";
        echo "<input type='text' placeholder='116' name='courseNumber'><br/>";
        echo "Instructor<br/>";
        echo "<input type='text' placeholder='gpcorser' name='instructor'><br/>";
        /* echo "Building/Room<br/>"; */
        /* echo "<input type='text' name='building'>"; */
        /* echo "<input type='text' name='room'><br/>"; */
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    }


    /***************************************************************************
     * FUNCTION printCourses: print all courses for a given filter
     **************************************************************************/
    function printCourses($prefix, $courseNumber, $instructor)
    {
        /* call getListing() for each semester using all parameters */
        $term = "18/SP";
        $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
        echo "<h3>2018 - Spring</h3>";
        getListing($string);

        $term = "18/SU";
        $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
        echo "<h3>2018 - Summer</h3>";
        getListing($string);

        $term = "18/FA";
        $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
        echo "<h3>2018 - Fall</h3>";
        getListing($string);

        $term = "19/WI";
        $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
        echo "<h3>2019 - Winter</h3>";
        getListing($string);
    }


    /***************************************************************************
     * FUNCTION printSemester: print all CS/CIS/CSIS courses for given semester
     **************************************************************************/
    function printSemester($term)
    {
        /* NOTE:
           printSemester() is only called when user hasn't used entry form */

        /* print all CIS courses for semester */
        $string = $GLOBALS['api_base_addr'] . "CIS&term=$term";
        getListing($string);

        /* print all CS courses for semester */
        $string = $GLOBALS['api_base_addr'] . "CS&term=$term";
        getListing($string);

        /* print all CSIS courses for semester */
        $string = $GLOBALS['api_base_addr'] . "CSIS&term=$term";
        getListing($string);
    }


    /***************************************************************************
     * FUNCTION getListing: print an html table for a single query of the api
     **************************************************************************/
    function getListing($apiCall)
    {
        /* init listing string */
        $listing = "";

        /* get JSON object */
        $json = curl_get_contents($apiCall);

        /* convert JSON object into PHP object */
        $obj = json_decode($json);

        if(!($obj->courses == null))
        { /* can show obj with var_dump($obj); */
            echo "<table border='3' width='100%'>";

            /* loop through each course */
            foreach($obj->courses as $course)
            {
                /* PARSE 'building' *******************************************/
                $building = strtoupper(trim($_GET['building']));
                $buildingMatch = false;
                $thisBuilding0 = trim($course->meetingTimes[0]->building);
                $thisBuilding1 = trim($course->meetingTimes[1]->building);

                if($building && ($thisBuilding0 == $building || $thisBuilding1 == $building))
                {
                    $buildingMatch = true;
                }

                if(!($building))
                {
                    $buildingMatch = true;
                }

                if(!$buildingMatch)
                {
                    continue;
                }

                /* PARSE: 'room' **********************************************/
                $room = strtoupper(trim($_GET['room']));
                $roomMatch = false;
                $thisroom0 = trim($course->meetingTimes[0]->room);
                $thisroom1 = trim($course->meetingTimes[1]->room);

                if($room && ($thisroom0 == $room || $thisroom1 == $room))
                {
                    $roomMatch = true;
                }

                if(!($room))
                {
                    $roomMatch = true;
                }

                if(!$roomMatch)
                {
                    continue;
                }

                /* PARSE: row color based on instructor 'username' ************/
                $tr = "<tr bgcolor='";
                switch($course->instructors[0]->username)
                {
                    case "james":
                        $tr .= "#B19CD9'>";   /* light purple */
                        break;
                    case "icho":
                        $tr .= "lightblue'>"; /* light blue */
                        break;
                    case "krahman":
                        $tr .= "pink'>";      /* pink */
                        break;
                    case "gpcorser":
                        $tr .= "yellow'>";    /* yellow */
                        break;
                    case "pdharam":
                        $tr .= "#77DD77'>";   /* light green */
                        break;
                    case "amulahuw":
                        $tr .= "#FFB347'>";   /* light orange */
                        break;
                    default:
                        $tr = "<tr>";         /* no background color */
                }
                $listing .= $tr;

                /* STORE: 'prefix courseNumber*section' ***********************/
                $listing .= "<td width='10%'>" . $course->prefix . " " . $course->courseNumber . "*" . $course->section . "</td>";

                /* STORE: 'title (lineNumber)'  *******************************/
                $listing .= "<td width='40%'>" . $course->title . " (" . $course->lineNumber . ")" . "</td>";

                /* STORE: 'seatsAvailable'  ***********************************/
                $listing .= "<td width='10%'>Av: " . $course->seatsAvailable . " / " . $course->capacity . "</td>";

                /* STORE: 'days startTime' ************************************/
                /* Use meetingTimes[0] or meetingTimes[1] */
                $index = 1;
                if($course->meetingTimes[0]->days)
                {
                    $index = 0;
                }
                else
                {
                    /* no action needed */
                }

                $listing .= "<td width='15%'>";
                $listing .= $course->meetingTimes[$index]->days . " " . $course->meetingTimes[$index]->startTime . "</td> ";

                /* STORE: 'building room' *************************************/
                $listing .= "<td width='10%'>";

                /* handle Online courses */
                if(substr($course->section, -2, 1) == "9")
                {
                    $listing .= "(Online)";
                }
                else
                {
                    /* no action needed */
                }

                /* Use meetingTimes[0] or meetingTimes[1] */
                $index = 0;
                if(substr($course->section, -2, 1) == "7")
                {
                    $index = 1;
                }
                else
                {
                    /* no action needed */
                }

                $listing .= $course->meetingTimes[$index]->building . " " . $course->meetingTimes[$index]->room;

                $listing .= "</td>";

                /* STORE: 'instructors name' **********************************/
                $listing .= "<td width='15%'>" . $course->instructors[0]->name . "</td>";
                $listing .= "</tr>";
            } /* END: foreach */

            $listing .= "</table>";
            $listing .= "<br />";

            /* print the listing */
            echo $listing;

        } /* END: if(!($obj->courses == null)) */
        else
        {
            echo "No courses fit search criteria";
            echo "<br />";
        }
    }


    /***************************************************************************
     * FUNCTION curl_get_contents: reads file into string;
     *                             alternative to file_get_contents
     **************************************************************************/
    function curl_get_contents($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- TAB-TITLE/FAVICON ************************************************* -->
    <title>Course Lookup</title>
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
        <div class="btn-toolbar">
            <div class="btn-group" role="group">
                <a href="https://github.com/blspence/cis355/tree/master/prog04"
                   target="_blank"
                   class="btn btn-primary"
                   role="button"
                   aria-pressed="false">
                       Go to GitHub
                </a>
            </div>
            <div class="btn-group" role="group">
                <a href="coursesearch.php"
                   target="_blank"
                   class="btn btn-primary btn-success"
                   role="button"
                   aria-pressed="false">
                       Search
                </a>
            </div>
        </div>
        <div class="row">
            <?php main();?>
        </div> <!-- END: <div class="row"> -->
    </div> <!-- END: <div class="container"> -->
</body>

</html>