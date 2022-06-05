<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name \TheFramework\Helpers\Form\Input\Checkbox
 * @file Checkbox.php
 * @date 06-12-2018 13:13 (SPAIN)
 * @observations:
 */
namespace TheFramework\Helpers\Form\Input;

use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;
use TheFramework\Helpers\Form\Legend;
use TheFramework\Helpers\Form\Fieldset;

class Checkbox extends AbsHelper
{
    private $arOptions;
    private $arValuesToCheck;
    private $arValuesDisabled;    
    private $isGrouped;
    //private $sOutText;
    private $iChecksPerLine=6;

    private $oLegend;
    private $oFieldset;
    private $isLabeled;
    
    /**
     * 
     * @param mixed $mxOptions array|string Las opciones deben ser array(value=>texto mostrar) si es string solo admite "value" ej. "val1|val2|..|valn"
     * @param string $name 
     * @param mixed $mxValuesToCheck array|string
     * @param mixed $mxValuesDisabled  array|string
     * @param string $class
     * @param array $extras
     * @param type $isGrouped
     * @param Legend $oLegend
     * @param Fieldset $oFieldset
     */
    public function __construct($mxOptions=[], $name="", 
            $mxValuesToCheck=[], $mxValuesDisabled=[], $class="", $extras="",$isGrouped=true,
            Legend $oLegend=null, Fieldset $oFieldset=null )
    {
        $this->conv_string_to_array($mxOptions,1);
        $this->conv_string_to_array($mxValuesToCheck);
        $this->conv_string_to_array($mxValuesDisabled);
        
        $this->type = "checkbox";
        $this->idprefix = "";
        $this->name = $name;
        $this->id = $name;
        $this->isLabeled = false;//permite customizar por defecto la etiqueta
        $this->arOptions = $mxOptions;
        $this->arValuesToCheck = $mxValuesToCheck;
        $this->arValuesDisabled = $mxValuesDisabled;
        $this->isGrouped = $isGrouped;
        if($class) $this->arclasses[] = $class;
        $this->extras = $extras;
        $this->oLegend = $oLegend;
        $this->oFieldset = $oFieldset;
    }//__construct

    public function get_html()
    {  
        $sHtmlToReturn ="";
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";

        if($this->oFieldset) $arHtml[] = $this->oFieldset->get_opentag();
        if($this->oLegend) $arHtml[] = $this->oLegend->get_html();
        
        $iOption=0;
        $iNumOptions = count($this->arOptions);
        foreach($this->arOptions as $sValue=>$sOutText)
        {
            $sCheckId = "";
            $isChecked = in_array($sValue,$this->arValuesToCheck);
            $isReadOnly = in_array($sValue,$this->arValuesDisabled);
            if($this->id) $sCheckId = "$this->idprefix$this->id";
            if($iNumOptions>1) $sCheckId.="_$iOption";
            //bug($sCheckId);
            //calculo de checkboxes por linea. Si cumple se hace un salto
            if(($iOption%($this->iChecksPerLine))==0 && $iOption>0) $arHtml[] = "<br/>";
            $arHtml[] = $this->build_check($sCheckId,$sValue,$sOutText,$isChecked,$isReadOnly);
            //bug($sHtmlToReturn); die;
            $iOption++;            
        }//foreach($this->arOptions)

        if($this->oFieldset) $arHtml[] = $this->oFieldset->get_closetag();
        //if($this->oLegend) $arHtml[] = $this->oLegend->get_closetag();
        return implode("",$arHtml);
    }//get_html

    private function build_check($id, $sValue, $sOutText, $isChecked=false, $isReadOnly=false)
    {
        $arHtml = [];
        $sName = $this->name;
        if(!$sName) $sName = "noname";

        $arHtml[] = "<input";
        $arHtml[] = " type=\"$this->type\" ";

        if($id) $arHtml[] = " id=\"$id\"";
        $arHtml[] = " name=\"$this->idprefix$sName";
        if($this->isGrouped) $arHtml[] = "[]";
        $arHtml[] = "\"";
        $arHtml[] = " value=\"$sValue\"";
        
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange;\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arHtml[] = " onkeypress=\"$this->_js_onkeypress;\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\"";
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arHtml[] = " class=\"$this->class\"";
        $this->load_style();
        if($this->style) $arHtml[] = " style=\"$this->style\"";
        
        //atributos extras
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        
        if($isChecked) $arHtml[] = " checked";
        if($isReadOnly) $arHtml[] = " disabled";
        $arHtml[] = ">";
        
        //out text
        if($this->isLabeled)
        {
            $oLabel = new Label($id,$sOutText);
            $arHtml[] =  $oLabel->get_html();
        }
        elseif($sOutText)
            $arHtml[] = "$sOutText";
        
        return implode("",$arHtml);
    }//build_check

    private function conv_string_to_array(&$mxStrArray,$isValIndex=0)
    {
        if(!$mxStrArray)
            $mxStrArray = [];
        
        if(is_string($mxStrArray))
        {   
            $mxStrArray = explode("|",$mxStrArray);
            //val index se utiliza para las opciones ya que estas deben
            //ser index1->texto1,index2->texto2
            if($isValIndex)
            {
                $arIndex = [];
                foreach($mxStrArray as $v)
                    $arIndex[$v]="";
                $mxStrArray = $arIndex;
            }
        }//is string
    }//conv_string_to_array

    //**********************************
    //             SETS
    //**********************************
    public function set_fieldset(Fieldset $oFieldset){$this->oFieldset = $oFieldset;}
    public function set_legend(Legend $oLegend){$this->oLegend = $oLegend;}
    //public function set_value($value){$this->conv_string_to_array($value);$this->arValuesToCheck = $value;}
    public function set_values_to_check($mxValues){$this->conv_string_to_array($mxValues);$this->arValuesToCheck = $mxValues;}
    public function not_groupedname($isOn=false){$this->isGrouped = $isOn;}
    public function set_checks_per_line($iNumChecks){$this->iChecksPerLine = $iNumChecks;}
    public function set_options($mxOptions){$this->conv_string_to_array($mxOptions,1);$this->arOptions=$mxOptions;}
    public function set_unlabeled($isOn=TRUE){$this->isLabeled=!$isOn;}
    public function setname($value){$this->name=$value;}
    
    //**********************************
    //             GETS
    //**********************************    
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    //public function show_opentag(){parent::show_opentag();}
    //public function show_closetag(){parent::show_closetag();}    
}//Checkbox