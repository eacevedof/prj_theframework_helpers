<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.3
 * @name TheFramework\Helpers\Html\P
 * @date 01-01-2016 16:21
 * @file P.php
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\AbsHelper;
class P extends AbsHelper
{
    
    public function __construct($innerhtml="", $id="", $class="", $style="", $extras=[])
    {
        $this->type = "p";
        $this->idprefix = "";
        $this->id = $id;
        
        $this->innerhtml = $innerhtml;
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        
        $this->extras = $extras;
    }
    
    //Fieldset
    public function get_html()
    {  
        $sHtmlToReturn = $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
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
        //atributos extra
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->extras) $arOpenTag[] = " ".$this->get_extras();
        $arOpenTag[] = ">\n";
        return implode("",$arOpenTag);
        //TODO
    }

    //**********************************
    //             SETS
    //**********************************
    
    //**********************************
    //             GETS
    //**********************************
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){parent::show_opentag();}
    public function show_closetag(){parent::show_closetag();}
}