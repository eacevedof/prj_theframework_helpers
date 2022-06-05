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
            $class="", $style="", $arExtras=[])
    {
        $this->type = "label";
        $this->idprefix = "";
        $this->id = $id;
        
        $this->innerhtml = $innerhtml;
        $this->_for = $for;
        //$this->arclasses[] = "control-label";
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->arExtras = $arExtras;
    }
    
    //label
    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";        
        $arHtml[] = $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        $this->load_inner_objects();
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
        if($this->_js_onblur) $arOpenTag[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arOpenTag[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arOpenTag[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arOpenTag[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arOpenTag[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arOpenTag[] = " onmouseout=\"$this->_js_onmouseout\""; 
        
        //aspecto
        $this->load_cssclass();
        if($this->_class) $arOpenTag[] = " class=\"$this->_class\"";
        $this->load_style();
        if($this->_style) $arOpenTag[] = " style=\"$this->_style\"";
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arOpenTag[] = " pk=\"pk\"";
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();

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