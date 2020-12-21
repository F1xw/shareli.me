<?php

    if (!isset($_GET['license'])) {
        echo 'false_request';
    }else{
        
        $license = $_GET['license'];

        if ($conn = mysqli_connect('localhost', 'flo', 'ihFuha7AG', 'share.it')) {
            $stmt = "SELECT * FROM licenses WHERE license = '$license'";
            if ($exec = mysqli_query($conn, $stmt)) {
                if (mysqli_num_rows($exec) == 1) {
                    if ($row = mysqli_fetch_assoc($exec)) {
                        $now = new DateTime();
                        $expiration = new DateTime($row['expiration']);
                        $start = new DateTime($row['start']);
        
                        if ($expiration == $start) {
                            echo 'valid';
                        }elseif($expiration > $start){
                            echo 'invalid';
                        }else{
                            echo 'valid';
                        }
                    }else{
                        echo 'db_fetch_err';
                    }
                }else{
                    echo 'invalid';
                }
            }else{
                echo 'db_query_err';
            }
        }else{
            echo 'db_conn_err';
        }
    }

?>