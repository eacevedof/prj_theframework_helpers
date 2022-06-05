<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name TheFramework\Helpers\Html\Xl\Li
 * @date 10-04-2013 14:33 (SPAIN)
 * @file Li.php
 */
namespace TheFramework\Helpers\Html\Xl;
use TheFramework\Helpers\AbsHelper;

class Li extends AbsHelper
{  
    public function __construct($innerhtml="",$id="")
    {
        $this->idprefix = "li";
        $this->type = "li";
        $this->id = $id;
        $this->innerhtml = $innerhtml;
    }
    
    //li
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
        //propiedades html5
        if($this->disabled) $arOpenTag[] = " disabled";
        if($this->readonly) $arOpenTag[] = " readonly"; 
        if($this->_isRequired) $arOpenTag[] = " required"; 
        //eventos
        if($this->jsonblur) $arOpenTag[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange) $arOpenTag[] = " onchange=\"$this->jsonchange\"";
        if($this->_js_onclick) $arOpenTag[] = " onclick=\"$this->_js_onclick\"";
        if($this->jsonkeypress) $arOpenTag[] = " onon_keypress=\"$this->jsonkeypress\"";
        if($this->jsonfocus) $arOpenTag[] = " onfocus=\"$this->jsonfocus\"";
        if($this->jsonmouseover) $arOpenTag[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $arOpenTag[] = " onmouseout=\"$this->jsonmouseout\""; 
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arOpenTag[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arOpenTag[] = " style=\"$this->style\"";
        //atributos extras
        if($this->extras) $arOpenTag[] = " ".$this->get_extras();
        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);

    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    //public function set_array_items($arItems=[]){$this->_arItems = $arItems;}
    
    //**********************************
    //             GETS
    //**********************************
    //public function get_array_li(){return $this->_arItems;}

}//Li