
<?php

$test = "";

$objdb = new dbConnect() ;
$objdb ->getConnection() ;

$mysqli = new mysqli("localhost", "root", "", "vif4");


//if ($mysqli->connect_errno) {
 //   echo "Failed to connect to MySQL: " . $mysqli->connect_error;
//}
//if (isset($_GET["TemplateID"])) {
  //  $res = $mysqli->query("SELECT * FROM template WHERE TemplateID =" . $_GET["TemplateID"] . ";");
  //  $row = $res->fetch_assoc();
//}

require_once 'TemplateManager.php';
$cTemplateManager = new TemplateManager();

//$test = $cTemplateManager->getsqlvif4;

//echo $test;


$sql = "Select * from vif4";

$statement = $mysqli->prepare($sql);
$statement->execute();


$mysqli->query($sql);
if (!$mysqli) {
    die('Ungültige Abfrage: ' . mysqli_error());
}
?>

<html>
    <head>
        <title>
            content via link und DB
        </title>
    </head>
    <body>

        <?php
        $resLink = $mysqli->query("SELECT * FROM template;");
        $iLinkCount=1;
        while($rowLink = $resLink->fetch_assoc()){
            echo "<a href='index.php?contentID=".$rowLink["ID"]."'>Text ".$iLinkCount."</a> | ";
            $iLinkCount++;
        }
  
        if (isset($row)) {
            echo "<br><br>";
            echo "<font color='#ff0000'>Zuletzt ge&auml;ndert: " . $row["LastModified"] . "</font><br><br>";
            echo $row["Content"];
        }
        ?>
    </body>
</html>


