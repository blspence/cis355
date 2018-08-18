<?php
    /***************************************************************************
     * PHP for upload01.html
     **************************************************************************/
    require_once('functions01.php');

    /* set PHP variables from data in HTML form */
    $fileName       = $_FILES['Filename']['name'];
    $tempFileName   = $_FILES['Filename']['tmp_name'];
    $fileSize       = $_FILES['Filename']['size'];
    $fileType       = $_FILES['Filename']['type'];

    /* set server location (subdirectory) to store uploaded files */
    $fileLocation = "uploads/";
    $fileFullPath = $fileLocation . $fileName;

    /* create subdirectory, if it doesn't exist */
    if(!file_exists($fileLocation))
    {
        mkdir($fileLocation);
    }

    /* if file does not already exist, upload it */
    if(!file_exists($fileFullPath))
    {
        $result = move_uploaded_file($tempFileName, $fileFullPath);

        if($result)
        {
            echo "File <b><i>" . $fileName
                . "</i></b> has been successfully uploaded.";
            /* code below assumes filepath is same as filename of this file
               minus the 12 characters of this file, "upload01.php"
               plus the string, $fileLocation, i.e. "uploads/" */
            echo "<br>To see all uploaded files, visit: "
                    . "<a href='"
                    . substr(get_current_url(), 0, -12)
                    . "$fileLocation'>"
                    . substr(get_current_url(), 0, -12)
                    . "$fileLocation</a>";
        }
        else
        {
            echo "Upload denied for file. " . $fileName
                . "</i></b>. Verify file size < 2MB. ";
        }
    }

    /* file already exists */
    else
    {
        echo "File <b><i>" . $fileName . "</i></b> already exists."
            . " Please rename file.";
    }
?>