<?php
session_start();



if (!isset($_SESSION['loggedin']) || $_SESSION['username'] == '') {
    echo 'access denied';
    exit;
}

if($link = mysqli_connect('yeetlabs.de', 'shareli_me', 'Vrc41_z9', 'shareli_main')) {
    $user = "'".$_SESSION['username']."'";
    $query = "SELECT * FROM files WHERE user = $user";

    sleep(2.3);

    if ($exec = mysqli_query($link, $query)) {
        if (mysqli_num_rows($exec) > 0) {
            while ($row = mysqli_fetch_assoc($exec)) {
                $d = new DateTime($row['expiration']);
                $expiration = $d->format('m.d.Y');
                echo '
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="row w-100 m-0">
                        <div class="col-4 text-left"><a href="https://shareli.me/?'.$row['uri'].'" target="_blank">'.$row['file_basename'].'</a></div>
                        <div class="col-4 text-center"><span class="text-muted">'.$expiration.'</span></div>
                        <div class="col-4 text-right"><span class="badge badge-primary badge-pill">'.$row['downloads'].'</span></div>
                    </div>
                </li>
                ';
            }
        }else{
            echo "<span class='text-center'>No files shared</span>";
        }
    }else{
        echo "db_exec_err";
    }
}
?>
