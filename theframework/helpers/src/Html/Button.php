<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.1
 * @name TheFramework\Helpers\Html\Button
 * @file Button.php
 * @date 24-12-2016 11:28
 * @observations 
 * https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\AbsHelper;

class Button extends AbsHelper
{
    protected $sIcon;
    
    /**
     * innerhtml: content between <button>{$innerhtml}</button>
     * type: button, reset or submit
     * id: <button id={$id}>..</button>
     */
    public function __construct($innerhtml="",$type="button",$id="")
    {
        //tiene que ser button sino hay tipo ejecuta un submit
        $this->type = $type;
        $this->idprefix="";
        $this->id = $id;
        $this->innerhtml = $innerhtml;
    }
    
    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = $this->get_opentag();
        //Agrega a inner_html los valores obtenidos con 
        //$this->load_inner_objects(); A un boton no se le puede pasar objetos embebidos
        if($this->sIcon) $arHtml[] = "<span class=\"$this->sIcon\"> </span> ";
        $arHtml[] = $this->innerhtml;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }
        
    public function get_opentag()
    {    
        $arHtml[] = "<button";
        if($this->type) $arHtml[] = " type=\"$this->type\"";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
        if($this->_isDisabled) $arHtml[] = " disabled"; 
         
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onkeypress) $arHtml[] = " onkeypress=\"$this->_js_onkeypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\"";
        
        $this->load_cssclass();
        if($this->class) $arHtml[] = " class=\"$this->class\"";
        $this->load_style();
        if($this->style) $arHtml[] = " style=\"$this->style\"";
        //atributos extra
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->extras) $arHtml[] = " ".$this->get_extras();
 
        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }//get_opentag

    public function get_closetag()
    {
        return "</button>";
    }//get_close_tag
    
    public function set_icon($sClass){$this->sIcon=$sClass;}
}//Button