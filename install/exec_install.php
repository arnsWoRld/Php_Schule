<?php
session_start();
/*
 * exec_install.php - installation cms
 */
    if (isset($_POST["commit"])){
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
        echo "<br> User MySQL = ".$user;
        echo "<br> Passwort MySQL= ".$password;
        echo "<br> Adresse bzw. DNS zu MySQL = ".$adress;
        echo "<br> Name der Datenbank in MySQL = ".$dbName;
        echo "<br> User Admin = ".$userAdmin;
        echo "<br> Passwort Admin = ".$passwordAdmin;

        echo "<br> <br> 1) Klasse fuer Verbindung zur Datenbank wird erstellt ...";
        
        //<!-- ACHTUNG Dateiname muss fuer Wirkbetrieb noch geaendert werden ... ohne auto -->
        
        $myfile = fopen("../includes/auto_dbConnect.php", "w") or die("Kann Datei -dbConnect.php- nicht erstellen!");
        $txt = "<?php \n /* \n * Automatisch von Install.php erstellt \n */ \n";
        fwrite($myfile, $txt);
        $txt = "class dbConnect { \n  private \$mySQLi; \n  private \$isConnected = false; \n ";
        fwrite($myfile, $txt);
        $txt = "  public function __construct() { \n   \$this->connect(); \n  } \n";
        fwrite($myfile, $txt);
        $txt = "  public function isConnect () { \n   return \$this->isConnected; \n   } \n";
        fwrite($myfile, $txt);
        $txt = "  public function connect() { \n    \$this->mySQLi = new mysqli( '" .$adress ."', '" .$user ."', '" .$password ."', '" .$dbName  ."'); \n";
        fwrite($myfile, $txt);
        $txt = "     \$this->isConnected = true; \n ";
        fwrite($myfile, $txt);
        $txt = "     if (\$this->mySQLi->connect_errno) { \n ";
        fwrite($myfile, $txt);
        $txt = "       echo \"Fehler beim Verbinden zu MySQL: (\" . \$this->mySQLi->connect_errno . \") \" . \$this->mySQLi->connect_error; \n";
        fwrite($myfile, $txt);
        $txt = "       \$this->isConnected = false; \n     } \n ";
        fwrite($myfile, $txt);
        $txt = "     return \$this->mySQLi; \n    } \n ";
        fwrite($myfile, $txt);
        $txt = "  public function getErrorNo(){ \n     return \$this->mySQLi->connect_errno; \n     } \n } \n ";
        fwrite($myfile, $txt);
        fclose($myfile);
        echo " erledigt!";
        
        
        ?>
    </body>
</html>