<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 2.0.0
 * @name TheFramework\Helpers\Form\Input\File
 * @date 06-12-2018 17:56 (SPAIN)
 * @file File.php
 * @observations
 * @requires:
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

class File extends AbsHelper
{
    protected $_maxsize;
    protected $_accept;
  //<input accept="audio/*|video/*|image/*|MIMEtype"> 
    public function __construct
    ($id="", $name="", $class="", Label $oLabel=null)
    {
        $this->oLabel = $oLabel;
        $this->idprefix = "";
        $this->type = "file";
        $this->id = $id;
        $this->name = $name;
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
        if($this->value || $this->value=="0") $arHtml[] = " value=\"$this->value\"";
        //bug($this->value,"input_file $this->id");
        //propiedades html5
        if($this->_accept) $arHtml[] = " accept=\"$this->_accept\"";
        if($this->_maxsize) $arHtml[] = " maxsize=\"$this->_maxsize\"";
        if($this->disabled) $arHtml[] = " disabled";
        if($this->readonly) $arHtml[] = " readonly"; 
        if($this->_isRequired) $arHtml[] = " required"; 
        //bug($this->_isRequired,  $this->id);
        //eventos
        if($this->jsonblur) $arHtml[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange) $arHtml[] = " onchange=\"$this->jsonchange\"";
        if($this->jsonclick) $arHtml[] = " onclick=\"$this->jsonclick\"";
        
        if($this->jsonkeypress) $arHtml[] = " onkeypress=\"$this->jsonkeypress\"";

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
    public function value($value,$sVoid=null){$this->value = $value;}
    public function set_maxsize($iNumBytes){$this->_maxsize = $iNumBytes;}
    public function readonly($readonly=true){$this->readonly=$readonly;}
    public function disabled($disabled=true){$this->disabled=$disabled;}
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    public function set_accept($sAccept){$this->_accept=$sAccept;}
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->name;}
    public function get_maxsize(){return $this->_maxsize;}
    public function is_readonly(){return $this->readonly;}
    public function get_accept(){return $this->_accept;}
}//File