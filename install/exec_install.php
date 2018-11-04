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

        echo "<br> <br> 1) Klasse fuer Verbindung zur Datenbank wird erstellt ...";

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
            echo "Fehler beim Verbinden zu MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
            exit(1);
        }
        echo "    ... Verbindung zu MySQL hergestellt via: " . $conn->host_info . "<br>";

        $sql = "CREATE DATABASE " . $dbName;
        if ($conn->query($sql) === TRUE) {
            echo "    ... Datenbank erfolgreich angelegt." . "<br>";
        } else {
            echo "    ... Fehler beim anlegen der Datenbank: " . $conn->error . "<br>";
            exit(1);
        }
        $conn->close();
        echo "    ... erledigt! ";

        echo "<br> <br> 4) Tabellen werden in der Datenbank angelegt ...";
        $connMyCMS = new mysqli($adress, $user, $password, $dbName);
        if ($connMyCMS->connect_errno) {
            echo "    ... Fehler beim Verbinden zu MySQL-myCMS: (" . $connMyCMS->connect_errno . ") " . $connMyCMS->connect_error . "<br>";
            exit(1);
        }
        echo "    ... Verbindung zu myCMS in MySQL hergestellt via: " . $connMyCMS->host_info . "<br>";

        // alles nachfolgende ist falsch, keine Ahnung wie die DB aussehen soll ...
        if (!$connMyCMS->query("DROP TABLE IF EXISTS content") ||
                !$connMyCMS->query("CREATE TABLE content(ContentID INT UNSIGNED PRIMARY KEY, ContentLink VARCHAR(30), ContentInhalt VARCHAR(255), LastModified TIMESTAMP DEFAULT CURRENT_TIMESTAMP, deleteFlag TINYINT DEFAULT 0)") ||
                !$connMyCMS->query("INSERT INTO content(ContentID, ContentLink, ContentInhalt) VALUES (1, 'TestLink 1', '11111 Inhalt Test Link 1')")) {
            echo "    ... Tabelle content konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS template") ||
                !$connMyCMS->query("CREATE TABLE template(TemplateID INT UNSIGNED PRIMARY KEY, TemplateBezeichnung VARCHAR(50), deleteFlag TINYINT DEFAULT 0, LastModified TIMESTAMP DEFAULT CURRENT_TIMESTAMP)") ||
                !$connMyCMS->query("INSERT INTO template(TemplateID, TemplateBezeichnung) VALUES (1, 'default')")) {
            echo "    ... Tabelle template konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        if (!$connMyCMS->query("DROP TABLE IF EXISTS tvalues") ||
                !$connMyCMS->query("CREATE TABLE tvalues(TemplateID INT UNSIGNED, SettingID INT UNSIGNED, value VARCHAR(50), LastModified TIMESTAMP DEFAULT CURRENT_TIMESTAMP)") ||
                !$connMyCMS->query("INSERT INTO tvalues(TemplateID, SettingID, value) VALUES (1, 1, '700')")) {
            echo "   ... Tabelle tvalues konnte nicht angelegt werden: (" . $connMyCMS->errno . ") " . $connMyCMS->error . "<br>";
            exit(1);
        }
        $connMyCMS->close();
        echo "    ... erledigt! ";

        echo "<br> <br> 5) Diese Funktion wird unkenntlich gemacht ...";
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