<?php

class dbConnect {

    public function getConnection() {

        $mysqli = new mysqli("localhost", "root", "", "vif4");
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        }

        return  $mysqli;
    }

}
