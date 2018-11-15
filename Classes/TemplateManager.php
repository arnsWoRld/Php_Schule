
<!DOCTYPE html>
<?php

class TemplateManager {

    private $actualTemplate = "default";
    private $mysqli;
    private $templateSettingsAssocArr;

    public function __construct($mysqli) {

        $this->mysqli = $mysqli;
        $this->setTemplateSetting();
    }

    public function getActualTemplate() {
        return $this->actualTemplate;
    }

    public function getActualTemplateID() {


        if (!$resultTemplate = $this->mysqli->query("SELECT TemplateID From template WHERE TemplateBezeichnung='" . $this->getActualTemplate() . "';")) {
            printf("Errormessage: %s\n", $mysqli->error);
        } else {
            return $resultTemplate->fetch_object()->TemplateID;
            
        }
    }

    public function setTemplateSetting() {


        $resultSetting = $this->mysqli->query(
                "SELECT templatesetting.SettingLabel,settingtemplatevalue.Value "
                . "FROM settingtemplatevalue "
                . "LEFT JOIN template "
                . "ON settingtemplatevalue.TemplateID=template.TemplateID "
                . "LEFT JOIN templatesetting "
                . "ON templatesetting.SettingID=settingtemplatevalue.SettingID "
                . "WHERE settingtemplatevalue.TemplateID=" . $this->getActualTemplateID() . ";");



        /*
          $resultSetting = $this->mysqli->query(
          "SELECT templatesetting.SettingLabel,settingtemplatevalue.Value "
          . "FROM settingtemplatevalue "
          . "LEFT JOIN template "
          . "ON settingtemplatevalue.TemplateID=template.TemplateID "
          . "LEFT JOIN templatesetting "
          . "ON templatesetting.SettingID=settingtemplatevalue.SettingID "
          . "WHERE settingtemplatevalue.TemplateID=2");

         */

        $settingValues = array();
        while ($rowSetting = $resultSetting->fetch_assoc()) {
            $settingValues[$rowSetting["SettingLabel"]] = $rowSetting["Value"];
        }
        $this->templateSettingsAssocArr = $settingValues;
    }

    public function getTableWidth() {

        //return $this-> setTemplateSetting("tableWidth");
        //return $this-> setTemplateSetting["tableWidth"];
        //return $this->setTemplateSetting("tableWidth");
        //return $this->templateSetting("tableWidth");
        return $this->templateSettingsAssocArr["tableWidth"];
    }

    public function getMenuWidth() {
        return $this->templateSettingsAssocArr["menuWidth"];
    }

    public function getHeaderHeight() {
        return $this->templateSettingsAssocArr["headerHeight"];
    }

    public function getFooterHeight() {
        return $this->templateSettingsAssocArr["footerHeight"];
    }

}
