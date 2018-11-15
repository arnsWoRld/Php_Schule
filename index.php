<?php
session_start();
header('Content-Type: text/html; charset=ISO-8859-1');
$draft = true;
require_once "./includes/dbconnect.php";
require_once "./includes/classLoader.php";


if ($draft) {
    $tableBorder = 1;
} else {
    $tableBorder = 0;
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">

        <?php require_once "./includes/headLoader.php"; ?>
        <title>VIF4-CMS</title>
    </head>
    <body>
    <center>
        <table width="<?php echo $cTemplateManager->getTableWidth() ?>" border="<?php echo $tableBorder; ?>">
            <colgroup>
                <col width="<?php echo $cTemplateManager->getMenuWidth(); ?>%">               
                <col width="<?php echo 100 - $cTemplateManager->getMenuWidth(); ?>%">
            </colgroup>
            <tr>
                <td colspan="2" height="<?php echo $cTemplateManager->getHeaderHeight(); ?>">
                    <?php
                    //header
                    //echo "<a href='index.php?MmID=1'>Link1</a> | ";
                    //echo "<a href='index.php?MmID=2'>Link1</a>";
                    echo $cContentManager->getMainMenu();
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    //SubMenu
                    echo $cContentManager->getSubMenu();
                    ?>
                </td>
                <td>

                  
                    <?php
                      //Content
                      echo $cContentManager->getContent();
                    ?>





                </td>
            </tr>
            <tr>
                <td colspan="2" height="<?php echo $cTemplateManager->getFooterHeight(); ?>">
<?php
//footer
?>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
