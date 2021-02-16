<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'].'/src/conf.php';

if ($conn = initDBConnection()) {

    if(isset($_SESSION['loggedin']) && $_SESSION['username'] == 'Flow' && isset($_GET['purgeoverride']) && $_GET['purgeoverride'] == 'true') {
        $del_stmt = "DELETE FROM files;";
        if ($query = mysqli_query($conn, $del_stmt)) {
            $files = glob('../files/*'); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file)) {
                    unlink($file); // delete file
                }
            }
        }
    }

    $stmt = "SELECT * FROM files";
    if ($exec = mysqli_query($conn, $stmt)) {
        while ($row = mysqli_fetch_assoc($exec)) {
            $expiration = new DateTime($row['expiration']);
            $file_location = $row['file_location'];
            $uri = $row['uri'];
            $now = new DateTime();

            if ($expiration < $now) {
                $del_stmt = "DELETE FROM files WHERE uri = '$uri';";
                if ($del_exec = mysqli_query($conn, $del_stmt)) {
                    unlink($file_location);
                }else{
                    echo 'db_error';
                }
            }
        }
    }
}

?>
