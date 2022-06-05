<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name TheFramework\Helpers\Form\Input\Radio
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Radio.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

class Radio extends AbsHelper
{
    private $_arOptions;
    private $_value_to_check;
    private $_legendtext;
    
    public function __construct($arOptions, $grpname, $legendtext=""
            , $valuetocheck="", $class="", $extras=[])
    {
        //$this->id = ""; el id se aplica por check no por legend
        $this->type = "radio";
        $this->idprefix="";
        $this->_arOptions = $arOptions;
        $this->_value_to_check = $valuetocheck;
       
        $this->name = $grpname;
        $this->_legendtext = $legendtext;
        if($class) $this->arclasses[] = $class;
        $this->extras = $extras;
    }

    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        if($this->_legendtext) $arHtml[] = "<legend>$this->_legendtext</legend>\n";

        $i=0;
        foreach($this->_arOptions as $sValue => $sLabel)
        {
            $isChecked = ($this->_value_to_check == $sValue);
            $id = $this->idprefix.$this->name."_".$i;
            $id = str_replace("[]","",$id);
            $oLabel = new Label($id, $sLabel, "lbl$id");
            $arHtml[] = $this->build_input_radio($id, $sValue, $oLabel, $isChecked);
            $i++;            
        }
        //if($this->_inFieldsetDiv) $sHtmlToReturn = $sHtmlFieldSet.$sHtmlToReturn.$sHtmlFieldSetEnd;
        return implode("",$arHtml);
    }//get_html

    private function build_input_radio($id, $value, Label $oLabel=null, $isChecked=false)
    {
        $this->id = $id;
        $arHtml = [];
        $arHtml[] = "<input";
        if($this->type) $arHtml[] = " type=\"$this->type\"";
        if($this->id) $arHtml[] = " id=\"$id\"";
        if($this->name) $arHtml[] = " name=\"$this->idprefix$this->name\"";
        if($value) $arHtml[] = " value=\"$value\"";
        if($isChecked) $arHtml[] = " checked" ;
        //propiedades html5
        //if($this->maxlength)$arHtml[] = " maxlength=\"$this->maxlength\"";
        if($this->_isDisabled) $arHtml[] = " disabled";
        if($this->_isReadOnly) $arHtml[] = " readonly"; 
        //if($this->_isRequired) $arHtml[] = " required"; 
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
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        $arHtml[] = " />\n";
        if($oLabel) $arHtml[] = $oLabel->get_html();

        return implode("",$arHtml);
    }//build_input_radio

    //**********************************
    //             SETS
    //**********************************
    public function setname($value){$this->name = $value;}
    public function set_value_to_check($value){$this->_value_to_check = $value;}
    public function set_legendtext($value){$this->_legendtext = $value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function getname(){return $this->name;}
    public function get_value_checked(){return $this->_value_to_check;}
    public function get_legendtext(){return $this->_legendtext;}
}
/*<form>
  <fieldset>
    <legend>Personalia:</legend> The <legend> tag defines a caption for the <fieldset> element.
    Name: <input type="text" size="30"><br>
    Email: <input type="text" size="30"><br>
    Date of birth: <input type="text" size="10">
  </fieldset>
</form>
 * 
<form ...>
    <input type="radio" name="creditcard" value="Visa" id="visa" />
    <label for="visa">Visa</label>
    <input type="radio" name="creditcard" value="Mastercard" id="mastercard" />
    <label for="mastercard">Mastercard</label>
</form>
 */