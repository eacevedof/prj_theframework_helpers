<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.0
 * @name TheFramework\Helpers\Html\Span
 * @date 08-01-2017 12:40
 * @file Span.php
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\AbsHelper;
class Span extends AbsHelper
{    
    public function __construct($innerhtml="", $id="", 
            $class="", $style="", $extras=[])
    {
        $this->type = "span";
        $this->idprefix = "";
        $this->id = $id;
        
        $this->innerhtml = $innerhtml;
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->extras = $extras;
    }
    
    //span
    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = $this->get_opentag(); 
        $this->_load_inner_objects();
        $arHtml[] = $this->innerhtml;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }
        
    public function get_opentag()
    {
        $arOpenTag[] = "<$this->type";
        if($this->id) $arOpenTag[] = " id=\"$this->idprefix$this->id\"";
        //eventos
        if($this->jsonblur) $arOpenTag[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange) $arOpenTag[] = " onchange=\"$this->jsonchange\"";
        if($this->jsonclick) $arOpenTag[] = " onclick=\"$this->jsonclick\"";
        if($this->jsonkeypress) $arOpenTag[] = " onkeypress=\"$this->jsonkeypress\"";
        if($this->jsonfocus) $arOpenTag[] = " onfocus=\"$this->jsonfocus\"";
        if($this->jsonmouseover) $arOpenTag[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $arOpenTag[] = " onmouseout=\"$this->jsonmouseout\""; 
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arOpenTag[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arOpenTag[] = " style=\"$this->style\"";
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arOpenTag[] = " pk=\"pk\"";
        if($this->extras) $arOpenTag[] = " ".$this->get_extras();

        $arOpenTag[] =">";        
        return implode("",$arOpenTag);        
    }    
    //**********************************
    //             SETS
    //**********************************
    //**********************************
    //             GETS
    //**********************************
}