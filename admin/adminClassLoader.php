<?php
include_once ".././classes/ContentManager.php";
include_once '../includes/dbconnect.php';

if (isset($_GET)) {
    $cContentManager = new ContentManager($mysqli, $_GET);
}else{
    $cContentManager = new ContentManager($mysqli);
}

