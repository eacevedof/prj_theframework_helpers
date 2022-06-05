<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name TheFramework\Helpers\Form\Input\Date
 * @file Date.php
 * @date 06-12-2018 13:48 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

class Date extends AbsHelper
{
    private $_useClearButton = true;
    private $_convert_date_before_show = true;
    private $isIpadIphone;
    private $cSeparator;

    public function __construct
    ($id="", $name="", $value="", $arExtras=[], $maxlength="", $class="", Label $oLabel=null)
    {
        $this->idprefix = "";//dtb
        $this->cSeparator = "/";
        $this->id = $id;
        $this->_value = $value;
        $this->maxlength  = $maxlength;
        $this->name = $name;
        if($class) $this->arclasses[] = $class;        
        $this->arExtras = $arExtras;
        $this->oLabel = $oLabel;        
    }

    private function get_date_arranged($arDate)
    {
        $arReturn = ["y"=>"","m"=>"","d"=>""];
        $sDate0 = (isset($arDate[0])?$arDate[0]:"");
        $sDate2 = (isset($arDate[2])?$arDate[2]:"");
        $arReturn["m"] = (isset($arDate[1])?$arDate[1]:"");
        if(strlen($sDate0)===4)
        {
            $arReturn["y"] = $sDate0;
            $arReturn["d"] = $sDate2;
        }
        else 
        {
            $arReturn["d"] = $sDate0;
            $arReturn["y"] = $sDate2;
        }
        return $arReturn;
    }//get_date_arranged
    
    /**
     * Pasa cualquier fecha la formato que debe tener value para que se pinte bien en el html
     * value debe tener el siguiente formato: dd-mm-yyyy
     * @param type $sAnyDate
     * @return type
     */
    private function get_converted($sAnyDate)
    {
        $sInputDate = "";
        $sAnyDate = trim($sAnyDate);
        if($sAnyDate)
        {
            $sAnyDate = str_replace(" ","",$sAnyDate);
            $cSep = $this->cSeparator;
            
            if(strstr($sAnyDate,"/"))
                $cSep = "/";
            elseif(strstr($sAnyDate,"-"))
                $cSep = "-";

            //si tiene formato hydra
            if($cSep)
            {
                //pr($sAnyDate);
                $arDate = explode($cSep,$sAnyDate);
                $arDate = $this->get_date_arranged($arDate);
                //bug($arDate);die;
                $sInputDate = "{$arDate["y"]}-{$arDate["m"]}-{$arDate["d"]}";
            }
            else
                $sInputDate = $sAnyDate;
        }
        return $sInputDate;
    }
    
    public function get_html()
    {  
        $arHtml = [];               
        if($this->oLabel) $arHtml[] = $this->oLabel->get_html();
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = "<input";
        $arHtml[] = " type=\"date\"";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
        if($this->name) $arHtml[] = " name=\"$this->idprefix$this->name\"";
        if($this->_value) $arHtml[] = " value=\"".$this->get_converted($this->_value)."\"";

        //propiedades html5
        if($this->maxlength)$arHtml[] = " maxlength=\"$this->maxlength\"";
        if($this->_isDisabled) $arHtml[] = " disabled";
        if($this->_isReadOnly) $arHtml[] = " readonly"; 
        if($this->_isRequired) $arHtml[] = " required"; 
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange)$arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arHtml[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\"";
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arHtml[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arHtml[] = " style=\"$this->_style\"";
            
        if($this->_placeholder) $arHtml[] = " placeholder=\"$this->_placeholder\"";
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->arExtras) $arHtml[] = " ".$this->get_extras();
        $arHtml[] = ">";
        
        return implode("",$arHtml);
    }//get_html

    //**********************************
    //             SETS
    //**********************************
    public function setname($value){$this->name = $value;}
    public function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    public function set_today(){$this->_convert_date_before_show = false;$this->_value = date("d/m/Y");}
    public function in_fieldsetdiv($isOn=true){$this->_inFieldsetDiv = $isOn;}
    public function use_clearbutton($isOn=true){$this->_useClearButton = $isOn;}
    public function set_is_ipadiphone($isOn=true){$this->isIpadIphone = $isOn;}
    public function set_separator($sValue){$this->cSeparator = $sValue;}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    public function readonly($isReadOnly = true){$this->_isReadOnly = $isReadOnly;}
     
    //**********************************
    //             GETS
    //**********************************
    public function getname(){return $this->name;}
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}
    
}//Date

/*
<fieldset data-role="controlgroup" data-type="horizontal">
<label for="det_DateP" class="clsRequired" >Fecha</label>    
<input type="date" data-role="datebox" name="det_DateP" id="det_DateP" 
value="<? echo (!$isNew) ? to_user_date($oActivity->get_datep()) : $oSite->get_today_date(); ?>" 
required <?echo (!$isNew)? "readonly":""; ?> class="clsRequired" />
</fieldset>
*/