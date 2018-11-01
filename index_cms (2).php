<?php

$draft = true;
$templateID = "default";

if ($draft) {
    $tableBorder = 1;
} else {
    $tableBorder = 0;
}

$tableWidth = 0;
$headerheight = 0;
$menuWidth = 0;
$footerheight = 0;

$db = mysqli_connect("localhost", "root", "", "cdsammlung");
echo "geht";
if (!$db) {
    exit("Verbindungsfehler: " . mysqli_connect_error());
}


$db_erg = mysqli_query($db, $sql);
if (!$db_erg) {
    die('Ungültige Abfrage: ' . mysqli_error());
}

while ($zeile = mysqli_fetch_array($db_erg)) {
    $tableWidth = $zeile['Value'];
    $footerheight = $zeile['Value'];
    $headerheight = $zeile['Value'];
}

ECHO $tableWidth;
ECHO $footerheight;
ECHO $headerheight;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>VIF4-CMS</title>
    </head>
    <body>
    <center>
        <table width="<?php echo $tableWidth; ?>" border="<?php echo $tableBorder; ?>">
            <colgroup>
                <col width="<?php echo $menuWidth; ?>%">
                <col width="<?php echo 100 - $menuWidth; ?>%">
            </colgroup>
            <tr>
                <td colspan="2" height="<?php echo $headerheight; ?>">
<?php
//headerInhalt
?>
                </td>
            </tr>
            <tr>
                <td>
<?php
//menuInhalt
?>
                </td>
                <td>
                    <?php
                    //content
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="<?php echo $footerheight; ?>">
<?php
//footerInhalt
?>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
