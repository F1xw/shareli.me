<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "qrlib/phpqrcode.php";

if (isset($_GET['fid'])) {
    $url = "https://shareli.me/?".$_GET['fid'];
    QRcode::png($url);

}else{
    die("ERR_INVALID_REQUEST");
}

?>