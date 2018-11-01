<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title> TEST </title>
    </head>
    <body>
        
        <?php
        
            $db = mysqli_connect("localhost", "root", "", "cdsammlung");
            echo "geht";
            if(!$db)
            {
              exit("Verbindungsfehler: ".mysqli_connect_error());
            }
            	
            $statement = $db->prepare("UPDATE album SET bid = 7 WHERE aid = 2");
                        
            $sql = "SELECT * FROM php_schule";

            $db_erg = mysqli_query( $db, $statement );
            if ( ! $db_erg )
            {
              die('Ungültige Abfrage: ' . mysqli_error());
            }

            echo '<table border="1">';
            while ($zeile = mysqli_fetch_array( $db_erg))
               
            {
              echo "<tr>";
              echo "<td>". $zeile['aid'] . "</td>";
              echo "<td>". $zeile['titel'] . "</td>";
              echo "<td>". $zeile['bid'] . "</td>";
              echo "</tr>";
            }
            
            echo "</table>";
            mysqli_free_result( $db_erg );

        ?>
        
    </body>
</html>
