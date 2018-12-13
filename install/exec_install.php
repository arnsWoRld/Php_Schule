<?php
session_start();
/*
 * exec_install.php - installation cms
 */
if (isset($_POST["commit"])) {
    $user = $_POST["UserSQL"];
    $password = $_POST["PassSQL"];
    $adress = $_POST["AdrSQL"];
    $dbName = $_POST["DbNameSQL"];
    $userAdmin = $_POST["UserAdmin"];
    $passwordAdmin = $_POST["PassAdmin"];
}
if (!isset($user)) {
            echo "Achtung, dieses Programm sollte nur ueber das Programm 'install.php' gestartet werden. <br>";
            echo "Programm wird nun beendet.";
            exit(1);
        }

?>
<html>
    <head>
        <title> 
            MeinCMS wird installiert
        </title>
    </head> 
    <body>
        <h1>
            Installation wird durchgefuehrt ...
        </h1>
        Ihre Eingaben waren:
        <?php
        echo "<br> User MySQL = " . $user;
        echo "<br> Passwort MySQL= " . $password;
        echo "<br> Adresse bzw. DNS zu MySQL = " . $adress;
        echo "<br> Name der Datenbank in MySQL = " . $dbName;
        echo "<br> User Admin = " . $userAdmin;
        echo "<br> Passwort Admin = " . $passwordAdmin;

        echo "<br> <br> 1) Klasse fuer Verbindung zur Datenbank wird erstellt ... " ;

        //<!-- ACHTUNG Dateiname muss fuer Wirkbetrieb noch geaendert werden ... ohne auto -->

        $myfile = fopen("../includes/auto_dbConnect.php", "w") or die("Kann Datei -dbConnect.php- nicht erstellen!");
        $txt = "<?php \r\n /* \r\n * Automatisch von Install.php erstellt \r\n */ \r\n";
        fwrite($myfile, $txt);
        $txt = "class dbConnect { \r\n  private \$mySQLi; \r\n  private \$isConnected = false; \r\n ";
        fwrite($myfile, $txt);
        $txt = "  public function __construct() { \r\n    \$this->connect(); \r\n    } \r\n";
        fwrite($myfile, $txt);
        $txt = "  public function isConnect () { \r\n   return \$this->isConnected; \r\n  } \r\n";
        fwrite($myfile, $txt);
        $txt = "  public function connect() { \r\n    \$this->mySQLi = new mysqli('" . $adress . "', '" . $user . "', '" . $password . "', '" . $dbName . "'); \r\n";
        fwrite($myfile, $txt);
        $txt = "   \$this->isConnected = true; \r\n ";
        fwrite($myfile, $txt);
        $txt = "  if (\$this->mySQLi->connect_errno) { \r\n ";
        fwrite($myfile, $txt);
        $txt = "      echo \"Fehler beim Verbinden zu MySQL: (\" . \$this->mySQLi->connect_errno . \") \" . \$this->mySQLi->connect_error; \r\n";
        fwrite($myfile, $txt);
        $txt = "       \$this->isConnected = false; \r\n     } \r\n ";
        fwrite($myfile, $txt);
        $txt = "     return \$this->mySQLi; \r\n    } \r\n ";
        fwrite($myfile, $txt);
        $txt = "  public function getErrorNo(){ \r\n     return \$this->mySQLi->connect_errno; \r\n     } \r\n } \r\n ";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo " erledigt!";

        echo "<br> <br> 2) Datei .htpasswd wird erstellt ...";
        //<!-- ACHTUNG Dateiname muss fuer Wirkbetrieb noch geaendert werden ... ohne auto -->
        $myfile2 = fopen("../admin/auto_.htpasswd", "w") or die("Kann Datei -.htpasswd- nicht erstellen!");
        $txt = "admin:\$apr1\$wSDffAcN\$yQ2L10d/31iSJtgQu3cqG0 \r\n";  // uebernommen aus .htpasswd von Arni
        fwrite($myfile2, $txt);
        $passwordEncrypted = crypt($passwordAdmin, base64_encode($passwordAdmin));
        $txt = $userAdmin . ":" . $passwordEncrypted . " \r\n";
        fwrite($myfile2, $txt);
        fclose($myfile2);
        echo " erledigt! ";
        //echo $passwordEncrypted;        

        echo "<br> <br> 3) Datenbank wird in MySQL angelegt ...";
        $conn = new mysqli($adress, $user, $password, "mysql");
        if ($conn->connect_errno) {
            echo "<br>!!! Fehler beim Verbinden zu MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
            exit(1);
        }
        echo "<br>    ... Verbindung zu MySQL hergestellt via: " . $conn->host_info . "<br>";

        $sqlData = file_get_contents('meincms.sql');
        $sqlDataArr = explode(';', $sqlData);
        foreach ($sqlDataArr as $query) {
            if ($query) {
                $conn->query($query);
                    if ($conn->errno) {
                        echo "<br>     ... Fehler bei ausfuehren dieser Abfrage: " .$query ." <br>";
                        echo "         ... Fehlermeldung:  " .$conn->error ." <br>";
                }
            }
        }
/*        
        $sql = "CREATE DATABASE " . $dbName;
        if ($conn->query($sql) === TRUE) {
            echo "    ... Datenbank erfolgreich angelegt." . "<br>";
        } else {
            echo "    !!! Fehler beim anlegen der Datenbank: " . $conn->error . "<br>";
            exit(1);
        }
        $conn->close();
        echo "    ... erledigt! ";

        echo "<br> <br> 4) Tabellen werden in der Datenbank angelegt ...";
        $connMyCMS = new mysqli($adress, $user, $password, $dbName);
        if ($connMyCMS->connect_errno) {
            echo "<br>    !!! Fehler beim Verbinden zu MySQL-myCMS: (" . $connMyCMS->connect_errno . ") " . $connMyCMS->connect_error . "<br>";
            exit(1);
        }
        echo "<br>    ... Verbindung zu myCMS in MySQL hergestellt via: " . $connMyCMS->host_info . "<br>";

        if (!$connMyCMS->query("DROP TABLE IF EXISTS `cms_settings`") ||
                !$connMyCMS->query("CREATE TABLE `cms_settings`("
                        ."`property` varchar(255) NOT NULL PRIMARY KEY, "
                        ."`value` varchar(255) DEFAULT NULL)") ) {
            echo "    !!! Tabelle cms_settings konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `cms_user`") ||
                !$connMyCMS->query("CREATE TABLE `cms_user` ("
                        ."`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                        ."`name` VARCHAR(50) NOT NULL, "
                        ."`password` VARCHAR(100) NOT NULL)") ) {
            echo "    !!! Tabelle cms_user konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `content`") ||
                !$connMyCMS->query("CREATE TABLE `content` ("
                        ."`CID` INT(11) UNSIGNED NOT NULL PRIMARY KEY, "
                        ."`CLongText` VARCHAR(1024) NOT NULL, "
                        ."`CName` VARCHAR(50) DEFAULT NULL, "
                        ."`LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, "
                        ."`deleteFlag` TINYINT(1) DEFAULT NULL)") ) {
            echo "   !!! Tabelle content konnte nicht angelegt werden: (" . $connMyCMS->errno . ") <br> " . $connMyCMS->error . "<br>" .$connMyCMS->connect_error;
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `mainmenu`") ||
                !$connMyCMS->query("CREATE TABLE `mainmenu`("
                        . "`MmID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                        . "`MmName` VARCHAR(50) NOT NULL)") ){
            echo "   !!! Tabelle mainmenu konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `template`") ||
                !$connMyCMS->query("CREATE TABLE `template`("
                        . "`TemplateID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                        . "`TemplateBezeichnung` VARCHAR(50) NOT NULL, "
                        . "`LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, "
                        . "`deleteFlag` TINYINT(1) DEFAULT NULL)") ){
            echo "   !!! Tabelle template konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `templatesetting`") ||
                !$connMyCMS->query("CREATE TABLE `templatesetting`("
                        . "`SettingID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                        . "`SettingLabel` VARCHAR(50) DEFAULT NULL, "
                        . "`SettingEinheit` VARCHAR(15) DEFAULT NULL, "
                        . "`LastModified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, "
                        . "`deleteFlag` TINYINT(1) DEFAULT NULL)") ){
            echo "   !!! Tabelle templatesetting konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `settingtemplatevalue`") ||
                !$connMyCMS->query("CREATE TABLE `settingtemplatevalue`("
                        ."`TemplateID` INT(11) UNSIGNED NOT NULL, "
                        ."`SettingID` INT(11) UNSIGNED NOT NULL, "
                        ."`value` VARCHAR(50) DEFAULT NULL, "
                        ."KEY `settingtemplatevalue_templatesetting` (`SettingID`), "
                        ."KEY `settingtemplatevalue_template` (`TemplateID`), "
                        ."CONSTRAINT `settingtemplatevalue_template` FOREIGN KEY (`TemplateID`) REFERENCES `template` (`TemplateID`), "
                        ."CONSTRAINT `settingtemplatevalue_templatesetting` FOREIGN KEY (`SettingID`) REFERENCES `templatesetting` (`SettingID`))")  ){
            echo "   !!! Tabelle settingtemplatevalue konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS `submenu`") ||
                !$connMyCMS->query("CREATE TABLE `submenu`("
                        ."`SmID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                        ."`MmID` INT(11) UNSIGNED NOT NULL, "
                        ."`SmName` VARCHAR(50) DEFAULT NULL, "
                        ."KEY `FK_submenu_mainmenu` (`MmID`), "
                        ."CONSTRAINT `FK_submenu_mainmenu` FOREIGN KEY (`MmID`) REFERENCES `mainmenu` (`MmID`) )") ){
            echo "   !!! Tabelle submenu konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS subcont") ||
                !$connMyCMS->query("CREATE TABLE subcont("
                        ."SCID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, "
                        ."CID INT(11) UNSIGNED NOT NULL, "
                        ."SmID INT(11) UNSIGNED NOT NULL, "
                        ."rank INT(11) UNSIGNED DEFAULT NULL, "
                        ."KEY `FK__content` (`CID`), "
                        ."KEY `FK__submenu` (`SmID`), "
                        ."CONSTRAINT `FK__content` FOREIGN KEY (`CID`) REFERENCES `content` (`CID`), "
                        ."CONSTRAINT `FK__submenu` FOREIGN KEY (`SmID`) REFERENCES `submenu` (`SmID`))") ){
            echo "   !!! Tabelle subcont konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        echo "    ... erledigt! ";

        echo "<br> <br> 4) Musterdaten werden in die Tabellen eingefuegt ...";
        $conn->query("INSERT INTO content (CID, CLongText, CName) VALUES (null, 'Dies ist ein langer Text mit sehr intaeressanten Inhalten', 'TagesNews')");
        $conn->query("INSERT INTO cms_user (id, name, password) VALUES (null, 'admin', '21232f297a57a5a743894a0e4a801fc3')");
        $conn->query("INSERT INTO mainmenu VALUES (null, 'Hauptmenue')");
        $conn->query("INSERT INTO template (`TemplateBezeichnung`) VALUES ('default')");
        $conn->query("INSERT INTO templatesetting (`SettingLabel`, `SettingEinheit`) VALUES "
                . "('tableWidth', 'px'), "
                . "('headerHight', 'px'), "
                . "('footerHight', 'px'), "
                . "('menuWidth', 'percent'), "
                . "('tableBorder', 'px') " );
        $conn->query("INSERT INTO settingtemplatevalue VALUES (1, 1, '1050')");
        $conn->query("INSERT INTO submenu VALUES (null, 1, 'Admin')");
        $conn->query("INSERT INTO subcont VALUES (null, 1, 1, null)");
*/
        $conn->close();
        echo "    ... erledigt! ";

        echo "<br> <br> 4) Diese Funktion wird unkenntlich gemacht ...";
        //<!-- ACHTUNG Dateiname muss fuer Wirkbetrieb noch geaendert werden ... ohne auto -->
        $myfile3 = fopen("auto_install.php", "w") or die("Kann Datei -install.php- nicht erstellen!");
        $txt = "<html> <head> <title>Dummy Install</title></head> \r\n";
        fwrite($myfile3, $txt);
        $txt = "<body> <h1> Installation kann kein zweites Mal gestartet werden!</h1></body></html> \r\n";
        fwrite($myfile3, $txt);
        fclose($myfile3);
        echo " erledigt! <br> <br>";
        echo "<h1>Installation erfolgreich abgeschlossen!</h1><br>";
        ?>
    </body>
</html>