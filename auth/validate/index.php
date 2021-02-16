<?php

    if (!isset($_GET['license'])) {
        echo 'EXPT_ARGS_MISSING';
    }else{
        
        $license = $_GET['license'];
        include $_SERVER['DOCUMENT_ROOT'].'/src/conf.php';

        if ($conn = initDBConnection()) {
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
                        echo 'EXPT_DB_FETCH';
                    }
                }else{
                    echo 'invalid';
                }
            }else{
                echo 'EXPT_DB_QUERY';
            }
        }else{
            echo 'EXPT_DB_CONN';
        }
    }

?>