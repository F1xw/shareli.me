<?php

session_start();
#Check for pro license and set as undefined if not set
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] == '') {
    $license = 'undefined';
}else{
    $license = $_SESSION['license'];
}

include $_SERVER['DOCUMENT_ROOT'].'/src/conf.php';
file_get_contents('https://shareli.me/del/');

#If URL has file id
if ($_SERVER['REQUEST_URI'] != '/' && $_SERVER['REQUEST_URI'] != '/?' && strpos($_SERVER['REQUEST_URI'], '/#') === false && strpos($_SERVER['REQUEST_URI'], '=') === false) {
    $uri = ltrim($_SERVER['REQUEST_URI'], '/?');
    if ($db_link = initDBConnection()) {
        $query = "SELECT * FROM files WHERE uri = '$uri'";
        if ($exec = mysqli_query($db_link, $query)) {
            if (mysqli_num_rows($exec) == 1) {
                $data = mysqli_fetch_assoc($exec);        
                $file_location = $data['file_location'];
                $file_name_array = explode('.', $data['file_basename']);
                $file_name = $file_name_array[0];
                $file_extension = '.'.$file_name_array[1];
                $file_basename = $file_name.$file_extension;
                $file_basename_display = $file_name.$file_extension;
                if (strlen($file_name) > 15) {
                    $file_basename_display = substr($file_name, 0, 15).'..'.$file_extension;
                    $file_basename_display = $file_basename;
                }
                #Include the HTML for viewing files

                if ($data['maxDownloads'] > 0 && $data['downloads'] >=  $data['maxDownloads']) {
                    include 'src/html/viewFileNoDl.php';
                }else{
                    include 'src/html/viewFile.php';
                }     
            }else{
                $error = ["ERR_INVALID_FID", "The requested File was not found."];

                #Include default html if invalid file id
                include 'src/html/default.php';
            }
        }else{
            $error = ["ERR_QUERY_EXEC_FAILED", "Seems like there is a bug in the system. Maybe a moth or a fly."];
            include 'src/html/default.php';
        }
    }else{
        $error = ["ERR_DB_CONN_FAILED", "Seems like there is a bug in the system. Maybe a moth or a fly."];
        include 'src/html/default.php';
    }
}else{
    #Include default HTML if no file id is set
    include 'src/html/default.php';
}

#Generate alert if there was an error
if (isset($error)) {
    echo "<script>
    new Toast({
        message: '{$error[1]}',
        type: 'danger'
    });
    </script>";
}


?>
