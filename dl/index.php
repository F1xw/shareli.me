<?php

include $_SERVER['DOCUMENT_ROOT'].'/src/conf.php';

if ($_SERVER['REQUEST_URI'] !== '/dl/') {
    $uri_array = explode('?', $_SERVER['REQUEST_URI']);
    $uri = $uri_array[1];
    if ($db_link = initDBConnection()) {
        $query = "SELECT * FROM files WHERE uri = '$uri'";
        if ($exec = mysqli_query($db_link, $query)) {
            if (mysqli_num_rows($exec) == 1) {
                $data = mysqli_fetch_assoc($exec);
                $file_location = $data['file_location'];
                $file_basename = $data['file_basename'];
                $dlval = $data['downloads'] + 1;
                $update = "UPDATE files SET downloads = $dlval WHERE uri = '$uri'";

                $uexec = mysqli_query($db_link, $update);
                    
                header("Content-Disposition: attachment; filename=$file_basename");
                header("Content-Length: " . filesize($file_location));
                header("Content-Type: application/octet-stream;");
                readfile($file_location);

            }else{
                echo 'ERR_INVALID_FID';
            }
        }else{
            echo 'ERR_QUERY_FAILED';
        }
    }else{
        echo 'ERR_DB_CONN_FAILED';
    }
}
?>
