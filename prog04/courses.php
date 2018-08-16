<?php

/* global variables */
$api_base_addr = "https://api.svsu.edu/courses?prefix=";

/* suppress notices for NetBeans (TODO: remove if not needed) */
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

/* call main */
main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------

function main()
{
    /* echo html head section */
    echo '<html>';
    echo '<head>';
    echo '    <link rel="icon" href="img/cardinal_logo.png" type="image/png" />';
    echo '</head>';

    /* open html body section */
    echo '<body>';

    /* in html body section, if gpcorser's schedule, then print gpcorser's heading
       else print general CS/CIS/CSIS heading */
    if(!strcmp($_GET['instructor'], 'gpcorser'))
    {
        echo '<h1 align="center">George Corser, PhD</h1>';
        echo '<h2 align="center">CURRENT COURSES</h2>';
    }
    else
    {
        echo '<h1 align="center">SVSU/CSIS Department</h1>';
        echo '<h2 align="center">';
        echo $_GET['prefix'] ? ' - Prefix: ' . strtoupper($_GET['prefix']) : "";
        echo $_GET['courseNumber'] ? ' - Course Number: ' . $_GET['courseNumber'] : "";
        echo $_GET['instructor'] ? ' - Instructor: ' . strtoupper($_GET['instructor']) : "";
        echo '</h2>';
    }

    /* if user entered something in a search box, then call printCourses() to filter */
    if(($_GET['prefix'] != "") || ($_GET['courseNumber'] != "") || ($_GET['instructor'] != ""))
    {
        printCourses($_GET['prefix'], $_GET['courseNumber'], $_GET['instructor']);
    }
    /* otherwise call printSemester() for all courses for each semester */
    else
    {
        echo "<h3>Spring</h3>";
        printSemester("18/SP");
        echo "<h3>Summer</h3>";
        printSemester("18/SU");
        echo "<h3>Fall</h3>";
        printSemester("18/FA");
        echo "<h3>Winter</h3>";
        printSemester("19/WI");
    }

    /* display the entry form for next search */
    /* printForm(); */

    /* display button for course search */
    echo '<a href="coursesearch.php" class="btn btn-primary">Search</a>';

    /* close html body section */
    echo '</body>';
    echo '</html>';
}

#-----------------------------------------------------------------------------
/* display the entry form for next search */

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

#-----------------------------------------------------------------------------
/* print all courses for a given filter */

function printCourses($prefix, $courseNumber, $instructor)
{
    /* call printListing() for each semester using all parameters */
    $term = "18/SP";
    $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
    echo "<h3>2018 - Spring</h3>";
    printListing($string);

    $term = "18/SU";
    $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
    echo "<h3>2018 - Summer</h3>";
    printListing($string);

    $term = "18/FA";
    $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
    echo "<h3>2018 - Fall</h3>";
    printListing($string);

    $term = "19/WI";
    $string = $GLOBALS['api_base_addr'] . "$prefix&courseNumber=$courseNumber&term=$term&instructor=$instructor";
    echo "<h3>2019 - Winter</h3>";
    printListing($string);
}

#-----------------------------------------------------------------------------
/* print all CS/CIS/CSIS courses for a given semester */

function printSemester($term)
{
    /* note: printSemester() is only called when user has not entered anything in entry form */

    /* print all CIS courses for semester */
    $string = $GLOBALS['api_base_addr'] . "CIS&term=$term";
    printListing($string);

    /* print all CS courses for semester */
    $string = $GLOBALS['api_base_addr'] . "CS&term=$term";
    printListing($string);

    /* print all CSIS courses for semester */
    $string = $GLOBALS['api_base_addr'] . "CSIS&term=$term";
    printListing($string);
}

#-----------------------------------------------------------------------------
/* print an html table for one single query of the api */

function printListing($apiCall)
{
    /* get JSON object */
    $json = curl_get_contents($apiCall);

    /* convert JSON object into PHP object */
    $obj = json_decode($json);

    if(!($obj->courses == null))
    { /* can show obj with var_dump($obj); */
        echo "<table border='3' width='100%'>";

        foreach ($obj->courses as $course)
        {
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

            /* different <tr bgcolor=...> for each professor */
            switch ($course->meetingTimes[0]->instructor)
            {
                case "james": /* 1 */
                    $printline = "<tr bgcolor='#B19CD9'>";  /* pastel purple */
                    break;
                case "icho": /* 2 */
                    $printline = "<tr bgcolor='lightblue'>";  /* light blue */
                    break;
                case "krahman": /* 3 */
                    $printline = "<tr bgcolor='pink'>";  /* pink */
                    break;
                case "gpcorser": /* 4 */
                    $printline = "<tr bgcolor='yellow'>";   /* yellow */
                    break;
                case "pdharam": /* 5 */
                    $printline = "<tr bgcolor='#77DD77'>";  /* pastel green (light green) */
                    break;
                case "amulahuw": /* 6 */
                    $printline = "<tr bgcolor='#FFB347'>";  /* pastel orange */
                    break;
                default:
                    $printline = "<tr>"; /* no background color */
            }

            $printline .= "<td width='13%'>" . $course->prefix . " " . $course->courseNumber . "*" . $course->section . "</td>";
            $printline .= "<td width='40%'>" . $course->title . " (" . $course->lineNumber . ")" . "</td>";
            $printline .= "<td width='12%'>Av:" . $course->seatsAvailable . " (" . $course->capacity . ")" . "</td>";

            /* print day and time column */
            if($course->meetingTimes[0]->days)
            {
                $printline .= "<td width='15%'>" . $course->meetingTimes[0]->days . " " . $course->meetingTimes[0]->startTime;
                $printline .= "</td>";
            }
            else
            {
                $printline .= "<td width='15%'>";
                $printline .= $course->meetingTimes[1]->days . " " . $course->meetingTimes[1]->startTime . "</td> ";
            }

            /* print building and room column */

            $printline .= "<td width='10%'>";

            if(substr($course->section, -2, 1) == "9")
            {
                $printline .= "(Online)";
            }
            else
            {
                /* todo: if diff behavior change this - refer to orig templ */
            }

            if(substr($course->section, -2, 1) == "7")
            {
                $printline .= $course->meetingTimes[1]->building . " " . $course->meetingTimes[1]->room;
            }
            else
            {
                $printline .= $course->meetingTimes[0]->building . " " . $course->meetingTimes[0]->room;
            }

            $printline .= "</td>";

            /* print instructor column */

            $printline .= "<td width='10%'>" . $course->meetingTimes[0]->instructor . "</td>";
            $printline .= "</tr>";
            echo $printline;
        } /* end foreach */

        echo "</table>";
        echo "<br/>";
    } /* end if(!($obj->courses == null)) */
    else
    {
        echo "No courses fit search criteria";
        echo "<br />";
    }
}

#-----------------------------------------------------------------------------
/* read file into a string */

function curl_get_contents($url)
{
    /* alternative to file_get_contents */

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
