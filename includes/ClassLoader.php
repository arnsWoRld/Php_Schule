<?php

include_once "./classes/TemplateManager.php";
$cTemplateManager = new TemplateManager($mysqli);

include_once "./classes/ContentManager.php";
if (isset($_GET)) {
    $cContentManager = new ContentManager($mysqli, $_GET);
}else{
    $cContentManager = new ContentManager($mysqli);
}


