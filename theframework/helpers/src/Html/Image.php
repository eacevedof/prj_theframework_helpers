<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.5
 * @name TheFramework\Helpers\Html\Image
 * @date 06-06-2014 10:2
 * @file Image.php
 * @observations:
 * @requires: 
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\AbsHelper;

class Image extends AbsHelper
{
    protected $_src;
    protected $_alt;
    protected $_title;

    public function __construct($src="", $id="", $class="", $style="", $extras=[])
    {
        $this->type = "img";
        $this->idprefix = "";
        $this->id = $id;
        
        $this->_src = $src;
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->extras = $extras;
    }
    
    public function get_html()
    {  
        $arHtml[] = "<$this->type";
        if($this->_src) $arHtml[] = " src=\"$this->_src\"";
        if($this->_alt) $arHtml[] = " alt=\"{$this->_get_escaped_quot($this->_alt)}\"";
        if($this->_title) $arHtml[] = " title=\"{$this->_get_escaped_quot($this->_title)}\"";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
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
        //atributos extra
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        //if($this->_isPrimaryKey) $arOpenTag[] = " pk=\"pk\"";
        //if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";  
        $arHtml[] = ">";
        return implode("",$arHtml);
    }//get_html
        
        
    //**********************************
    //             SETS
    //**********************************
    public function set_src($sUrl){$this->_src = $sUrl;}
    public function set_alt($value){$this->_alt = $value;}
    public function set_title($value){$this->_title = $value;}
    //**********************************
    //             GETS
    //**********************************
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){parent::show_opentag();}
    public function show_closetag(){parent::show_closetag();}
    
}