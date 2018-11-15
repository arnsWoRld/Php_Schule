
<?php
session_start();
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
    <title>VIF4-CMS Admin</title>
  </head>
  <body>
      
      <button type=""button">Seite anlegen </button>
      
      <<form id="Seiteanlegen">
          
          mmain Menu:
            <select name="MainMenuName">
                <option value="">Select...</option>
                <?php
                foreach($cContentManager->getMainMenuName() AS $key => $value){
                    echo "<option value='".$key."'>".$value."</option>";
                }
                ?>
            </select>
            <input type="text">
          <br>
          Submenu:
          <input type="text">
          <br>
          Content:
          <textarea></textarea>
          
               
      </form>
      
  </body>
</html>