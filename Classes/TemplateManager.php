<?php

//require("dbConnect.php");

class TemplateManager {

    public $name = "";
    public $sql = "";
    private $mysqli;

    public function __construct($mysqli) {

        // wichtig Übergabe an Konstruktor OOP
        // keine Übergabe von Params; !Global Variable - unsauber
        $this->mysqli = $mysqli;
    }

    public function getsqlvif4() {

        $sql = "select * from settingtemplatevalue 
                left join template on settingtemplatevalue.TemplateID = Template.TemplateID
                left join templatesetting on templatesetting.SettingID = settingtemplatevalue.SettingID";

        $sql = "select * from vif4";

        return $sql;
    }

    public function getTableWidth() {

        // Statement einfügen 

        return $this->templatesettings["TableWidth"];
    }

    public function getMenuWidth() {

        // Statement einfügen 

        return $this->templatesettings["MenuWidth"];
    }

    public function getHeaderHeight() {

        //$sql = "Select * from vif4";
//        $sql = "select * from settingtemplatevalue 
//        left join template on settingtemplatevalue.TemplateID = Template.TemplateID
//        left join templatesetting on templatesetting.SettingID = settingtemplatevalue.SettingID";
        //echo $sql;


        $sql = "SELECT * FROM settingtemplatevalue";
//      //  $db_erg = mysqli_query($this->mysqli, $sql);
//
//        if (!$db_erg) {
//            die('Ungültige Abfrage: ' . mysqli_error());
//        }
//        
//        echo '<table border="1">';
//        while ($zeile = mysqli_fetch_array($db_erg, MYSQL_ASSOC)) {
//            echo "<tr>";
//            //echo "<td>" . $zeile['TemplateID'] . "</td>";
//            //echo "<td>" . $zeile['SettingID'] . "</td>";
//            echo "<td>" . $zeile['Value'] . "</td>";
//            echo "</tr>";
//        }
//        echo "</table>";
        
        //das wieder rein
//        $result = mysqli_query($this->mysqli, $sql);
//        if (!$result) {
//            die('Error in SQL:' . mysql_error());
//        } else {
//            while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
//                printf("TemplateID: %s  SettingID: %s", $row[0], $row[1]);
//            }
//            mysql_free_result($result);
//
//            // mysqli_free_result($db_erg);
//            // Statement einfügen 
//            //return $this->templatesettings["getHeaderHeight"];
//            return $sql;
//        }
//
//        function getStatement($param) {
//            $this->name = "nein";
//        }

        //im admin ht access einfügen      
    }
}
