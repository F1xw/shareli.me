<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'].'/src/conf.php';

if ($conn = initDBConnection()) {
    $stmt = "SELECT * FROM files";
    if ($exec = mysqli_query($conn, $stmt)) {
        while ($row = mysqli_fetch_assoc($exec)) {
            $expiration = new DateTime($row['expiration']);
            $file_location = $row['file_location'];
            $uri = $row['uri'];
            $now = new DateTime();

            if ($expiration < $now) {
                $del_stmt = "DELETE FROM files WHERE uri = '$uri';";
                if($_SESSION['loggedin'] && $_SESSION['username'] == 'Flow' && isset($_GET['purgeoverride']) && $_GET['purgeoverride'] == 'true') $del_stmt = "DELETE FROM files;";
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
