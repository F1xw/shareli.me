<?php

const DB_HOST = "shareli.me";
const DB_USER = "shareli_me";
const DB_PASSWD = "Vrc41_z9";
const DB_NAME = "shareli_main";

function initDBConnection() {
    try {
        $db_conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
        return $db_conn;
    } catch (\Throwable $th) {
        return false;
    }
}


?>