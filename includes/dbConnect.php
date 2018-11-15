<?php
    $mysqli = new mysqli("localhost", "user", "passwort", "cms");
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        die();
    } 
    ?>