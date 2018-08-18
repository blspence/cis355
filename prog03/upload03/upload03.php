<?php
    /***************************************************************************
     * PHP for upload03.html
     **************************************************************************/
    /* include code for database access */
    require '../../database/database.php';

    /* set PHP variables from data in HTML form */
    $fileName       = $_FILES['Filename']['name'];
    $tempFileName   = $_FILES['Filename']['tmp_name'];
    $fileSize       = $_FILES['Filename']['size'];
    $fileType       = $_FILES['Filename']['type'];
    $fileDescription = $_POST['Description'];

    /* abort if no filename */
    if(!$fileName)
    {
       die("No filename.");
    }

    /* abort if file is not an image */
    /* never assume the upload succeeded */

    if($_FILES['Filename']['error'] !== UPLOAD_ERR_OK)
    {
       die("Upload failed with error code " . $_FILES['file']['error']);
    }

    $info = getimagesize($_FILES['Filename']['tmp_name']);

    if($info === FALSE)
    {
       die("ERROR: unable to determine <i>image</i> type of uploaded file");
    }

    if(($info[2] !== IMAGETYPE_GIF) &&
       ($info[2] !== IMAGETYPE_JPEG) &&
       ($info[2] !== IMAGETYPE_PNG))
    {
       die("Not a gif/jpeg/png");
    }

    /* abort if file is too big */
    if($fileSize > 2000000)
    {
        echo "Error: file exceeds 2MB.";
        exit();
    }

    /* put the content of the file into a variable, $content */
    $fp      = fopen($tempFileName, 'r');
    $content = fread($fp, filesize($tempFileName));
    $content = addslashes($content);
    fclose($fp);

    /* connect to database */
    $pdo = Database::connect();

    /* insert file info and content into table */
    $sql = "INSERT INTO upload03 (filename, filesize, filetype, content) "
         . "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $q = $pdo->prepare($sql);
    $q->execute(array());

    /* list all files in database */
    /* ORDER BY BINARY filename ASC (sorts case-sensitive, like Linux) */
    echo '<br><br>All files in database:<br><br>';
    $sql = 'SELECT * FROM upload03 '
        . 'ORDER BY BINARY filename ASC;';

    foreach($pdo->query($sql) as $row)
    {
        $id = $row['id'];
        $sql = "SELECT * FROM upload03 where id=$id";
        echo $row['id'] . ' - ' . $row['filename'] . '<br>'
            . '<img width=25% height=25% src="data:image/jpeg;base64,'
            . base64_encode( $row['content'] ).'"/>'
            . '<br><br>';
    }
    echo '<br><br>';

    /* disconnect */
    Database::disconnect();
?>