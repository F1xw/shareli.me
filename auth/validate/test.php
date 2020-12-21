<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$timestamp = '0000-00-00 00:00:00';
$datetime = strtotime($timestamp);

echo $datetime;

?>