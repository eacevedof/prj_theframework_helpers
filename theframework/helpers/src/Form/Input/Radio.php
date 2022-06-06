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
    private $value_to_check;
    private $_legendtext;
    
    public function __construct($arOptions, $grpname, $legendtext=""
            , $valuetocheck="", $class="", $extras=[])
    {
        //$this->id = ""; el id se aplica por check no por legend
        $this->type = "radio";
        $this->idprefix="";
        $this->_arOptions = $arOptions;
        $this->value_to_check = $valuetocheck;
       
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
            $isChecked = ($this->value_to_check == $sValue);
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
        if($this->disabled) $arHtml[] = " disabled";
        if($this->readonly) $arHtml[] = " readonly"; 
        //if($this->_isRequired) $arHtml[] = " required"; 
        //eventos
        if($this->jsonblur) $arHtml[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange)$arHtml[] = " onchange=\"$this->jsonchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->jsonkeypress) $arHtml[] = " onon_keypress=\"$this->jsonkeypress\"";
        if($this->jsonfocus) $arHtml[] = " onfocus=\"$this->jsonfocus\"";
        if($this->jsonmouseover) $arHtml[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $arHtml[] = " onmouseout=\"$this->jsonmouseout\""; 
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arHtml[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arHtml[] = " style=\"$this->style\"";
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
    public function name($value){$this->name = $value;}
    public function setvalue_to_check($value){$this->value_to_check = $value;}
    public function set_legendtext($value){$this->_legendtext = $value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->name;}
    public function getvalue_checked(){return $this->value_to_check;}
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