<?php


    // Initialize the session
    session_start();

    sleep(1);
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();

    header("location: /");


?>
