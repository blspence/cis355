<?php

/*******************************************************************************
 * NetBeans ERROR SUPRESSION (TODO: remove if not needed)
 ******************************************************************************/

ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


/*******************************************************************************
 * GLOBAL VARIABLES
 ******************************************************************************/

/* $GLOBALS['api_base_addr'] */
$api_base_addr = "https://api.svsu.edu/courses?prefix=";


/*******************************************************************************
 * INVOKE MAIN
 ******************************************************************************/
main();


/*******************************************************************************
 * FUNCTION DEFINITIONS
 ******************************************************************************/

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


/*******************************************************************************
 * FUNCTION printForm: display the entry form for next search
 ******************************************************************************/
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


/*******************************************************************************
 * FUNCTION printCourses: print all courses for a given filter
 ******************************************************************************/
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


/*******************************************************************************
 * FUNCTION printSemester: print all CS/CIS/CSIS courses for a given semester
 ******************************************************************************/
function printSemester($term)
{
    /* note: printSemester() is only called when user hasn't used entry form */

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


/*******************************************************************************
 * FUNCTION getListing: print an html table for a single query of the api
 ******************************************************************************/
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
            /* PARSE 'building' ***********************************************/
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

            /* PARSE: 'room' **************************************************/
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

            /* PARSE: 'username' for row color ********************************/
            /* different <tr bgcolor=...> for each professor */
            switch($course->instructors[0]->username)
            {
                case "james": /* 1 */
                    $listing .= "<tr bgcolor='#B19CD9'>";  /* pastel purple */
                    break;
                case "icho": /* 2 */
                    $listing .= "<tr bgcolor='lightblue'>";  /* light blue */
                    break;
                case "krahman": /* 3 */
                    $listing .= "<tr bgcolor='pink'>";  /* pink */
                    break;
                case "gpcorser": /* 4 */
                    $listing .= "<tr bgcolor='yellow'>";   /* yellow */
                    break;
                case "pdharam": /* 5 */
                    $listing .= "<tr bgcolor='#77DD77'>";  /* pastel green (light green) */
                    break;
                case "amulahuw": /* 6 */
                    $listing .= "<tr bgcolor='#FFB347'>";  /* pastel orange */
                    break;
                default:
                    $listing .= "<tr>"; /* no background color */
            }

            /* STORE: 'prefix courseNumber*section' ***************************/
            $listing .= "<td width='13%'>" . $course->prefix . " " . $course->courseNumber . "*" . $course->section . "</td>";

            /* STORE: 'title (lineNumber)'  ***********************************/
            $listing .= "<td width='40%'>" . $course->title . " (" . $course->lineNumber . ")" . "</td>";

            /* STORE: 'seatsAvailable'  ***************************************/
            $listing .= "<td width='12%'>Av: " . $course->seatsAvailable . " / " . $course->capacity . "</td>";

            /* STORE: 'days startTime' ****************************************/
            if($course->meetingTimes[0]->days)
            {
                $listing .= "<td width='15%'>" . $course->meetingTimes[0]->days . " " . $course->meetingTimes[0]->startTime;
                $listing .= "</td>";
            }
            else
            {
                $listing .= "<td width='15%'>";
                $listing .= $course->meetingTimes[1]->days . " " . $course->meetingTimes[1]->startTime . "</td> ";
            }

            /* STORE: 'building room' *****************************************/
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

            /* determine whether to use meetingTimes[0] or meetingTimes[1] */
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

            /* STORE: 'instructors name' **************************************/
            $listing .= "<td width='10%'>" . $course->instructors[0]->name . "</td>";
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


/*******************************************************************************
 * FUNCTION curl_get_contents: reads file into string; alt. to file_get_contents
 ******************************************************************************/
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

