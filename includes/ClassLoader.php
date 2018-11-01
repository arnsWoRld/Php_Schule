<?php

include_once './includes/dbConnect.php';
$objdb = new dbConnect();
$mysqli = $objdb->getConnection();

include_once './Classes/TemplateManager.php';
//require_once 'TemplateManager.php';
$cTemplateManager = new TemplateManager($mysqli);

