<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.3
 * @name TheFramework\Helpers\Form\Input\Password
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Password.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

class Password extends AbsHelper
{
 
    public function __construct
    ($id="",$name="",$value="",$length=50,$class="",Label $oLabel=null)
    {
        $this->oLabel = $oLabel;
        $this->idprefix = "";
        $this->type = "password";
        $this->id = $id;
        $this->name = $name;
        $this->_value = $value;
        $this->maxlength = $length;
        if($class) $this->arclasses[] = $class;
        $this->oLabel = $oLabel;
    }
    
    public function get_html()
    {  
        $arHtml = [];
        
        if($this->oLabel) $arHtml[] = $this->oLabel->get_html();
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = "<input";
        if($this->type) $arHtml[] = " type=\"$this->type\"";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
        if($this->name) $arHtml[] = " name=\"$this->idprefix$this->name\"";
        if($this->_value || $this->_value=="0") 
            $arHtml[] = " value=\"{$this->get_cleaned($this->_value)}\"";
        //propiedades html5
        if($this->maxlength)$arHtml[] = " maxlength=\"$this->maxlength\"";
        if($this->_isDisabled) $arHtml[] = " disabled";
        if($this->_isReadOnly) $arHtml[] = " readonly"; 
        if($this->_isRequired) $arHtml[] = " required"; 
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onon_keypress) $arHtml[] = " onon_keypress=\"$this->_js_onon_keypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\"";        
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arHtml[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arHtml[] = " style=\"$this->style\"";
        //atributos extras pe. para usar el quryselector
        if($this->placeholder) $arHtml[] = " placeholder=\"$this->placeholder\"";
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        
        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }//get_html

    //**********************************
    //             SETS
    //**********************************
    public function setname($value){$this->name = $value;}
    public function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    public function setmaxlength($iNumChars){$this->maxlength = $iNumChars;}
    public function readonly($isReadOnly=true){parent::readonly($isReadOnly);}
    public function disabled($isDisabled=true){parent::disabled($isDisabled);}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    
    //**********************************
    //             GETS
    //**********************************
    public function getname(){return $this->name;}
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}
    public function getmaxlength(){return $this->maxlength;}
    public function is_readonly(){return $this->_isReadOnly;}
    
}//Password