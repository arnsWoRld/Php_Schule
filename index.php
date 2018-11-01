<?php
$draft = true;
if ($draft) {
    $tableBorder = 1;
} else {
    $tableBorder = 0;
}

$tableWidth = 0;
$headerheight = 0;
$menuWidth = 0;
$footerheight = 0;

//$dir = dirname(__FILE__);
//echo "<p>Full path to this dir: " . $dir . "</p>";
//echo "<p>Full path to a .htpasswd file in this dir: " . $dir . "/.htpasswd" . "</p>";


////test .htaccess
//function displayContent()
//{
//    // Das Modul, das geladen wird, wenn kein Modul explizit angefordert wurde
//    $called_module = "indexs";
//    if (isset($_GET['q'])) {
//        $q = $_GET['q'];
//        $ex = explode("/", $q); // Exploding die URL Variable $_GET['q']
//        $called_module = $ex[0];
//    }
//    // Wir nehmen an, dass die Inhaltsdateien im Ordner modules liegen
//    // und dabei zum Beispiel "start.php"  heißen.
//    $moduleFile = "modules/" . $called_module . ".php"; // Die Modul-Datei, also dein Inhalt
//    if (file_exists($moduleFile)) {
//        // Die Datei existiert! Includen!
//        include($moduleFile);
//    } else {
//        include("modules/error.php");
//    }
//}



session_start();
require_once './includes/dbConnect.php';
require_once './includes/Classloader.php';

$headerheight = $cTemplateManager->getHeaderHeight();

// objekt erstelle Variablen füllen?
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
