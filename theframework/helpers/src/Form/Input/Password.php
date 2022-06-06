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
        $this->value = $value;
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
        if($this->value || $this->value=="0") 
            $arHtml[] = " value=\"{$this->_get_escaped_quot($this->value)}\"";
        //propiedades html5
        if($this->maxlength)$arHtml[] = " maxlength=\"$this->maxlength\"";
        if($this->disabled) $arHtml[] = " disabled";
        if($this->readonly) $arHtml[] = " readonly"; 
        if($this->_isRequired) $arHtml[] = " required"; 
        //eventos
        if($this->jsonblur) $arHtml[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange) $arHtml[] = " onchange=\"$this->jsonchange\"";
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
    public function name($value){$this->name = $value;}
    public function value($value,$asEntity=0){($asEntity)?$this->value = htmlentities($value):$this->value=$value;}
    public function setmaxlength($iNumChars){$this->maxlength = $iNumChars;}
    public function readonly($readonly=true){parent::readonly($readonly);}
    public function disabled($disabled=true){parent::disabled($disabled);}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->name;}
    public function getvalue($asEntity=0){if($asEntity) return htmlentities($this->value); else return $this->value;}
    public function getmaxlength(){return $this->maxlength;}
    public function is_readonly(){return $this->readonly;}
    
}//Password