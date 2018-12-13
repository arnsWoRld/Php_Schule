<?php
session_start();
/*
 * createMenues.php - Eingabeformular fuer Anlage und Aenderung von Menüeinträgen für den Content
 */
header('Content-Type: text/html; charset=ISO-8859-1');
$draft = true;
require_once "../admin/adminClassLoader.php";


if ($draft) {
    $tableBorder = 1;
} else {
    $tableBorder = 0;
}
?>

<html> 
  <head>
    <title>VIF4-CMS Admin Menues definieren und aendern</title>
  </head>
  <body> 
  </body>
</html>