<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name TheFramework\Helpers\Form\Label
 * @date 09-01-2017 12:55 (SPAIN)
 * @file Label.php
 */
namespace TheFramework\Helpers\Form;
use TheFramework\Helpers\AbsHelper;

class Label extends AbsHelper
{
    private $_for = "";
    
    public function __construct($for="", $innerhtml="", $id="", 
            $class="", $style="", $extras=[])
    {
        $this->type = "label";
        $this->idprefix = "";
        $this->id = $id;
        
        $this->innerhtml = $innerhtml;
        $this->_for = $for;
        //$this->arclasses[] = "control-label";
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->extras = $extras;
    }
    
    //label
    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";        
        $arHtml[] = $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        $this->_load_inner_objects();
        $arHtml[] = $this->innerhtml;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }//get_html
    
    public function get_opentag()
    {
        $arOpenTag[] = "<$this->type";
        if($this->id) $arOpenTag[] = " id=\"$this->idprefix$this->id\"";
        if($this->_for) $arOpenTag[] = " for=\"$this->_for\"";
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
    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    public function set_for($value){$this->_for = $value;}
    //**********************************
    //             GETS
    //**********************************
    public function get_for(){return $this->_for;}
}//Label