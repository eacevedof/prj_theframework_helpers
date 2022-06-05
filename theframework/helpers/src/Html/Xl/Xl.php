<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.2
 * @name TheFramework\Helpers\Html\Xl\Xl
 * @date 06-09-2013 16:58 (SPAIN)
 * @file Xl.php
 */
namespace TheFramework\Helpers\Html\Xl;
use TheFramework\Helpers\AbsHelper;

class Xl extends AbsHelper
{
    protected $arObjLi;
  
    public function __construct
    ($innerhtml="",$id="",$arObjLi=[])
    {
        $this->idprefix = "";
        $this->type = "ul";
        $this->id = $id;
        $this->innerhtml = $innerhtml;
        $this->arObjLi = $arObjLi;
    }
    
    public function get_html()
    {  
        $arHtml = [];
        if(!$this->innerhtml) $this->innerhtml = $this->get_array_li_as_string();
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = $this->get_opentag();
        $arHtml[] = $this->innerhtml;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }//get_html

    private function get_array_li_as_string()
    {
        $sLi = "";
        foreach($this->arObjLi as $oLi) 
            if(is_object($oLi))
                $sLi .= $oLi->get_html();
            elseif(is_string($oLi)) 
                $sLi .= $oL;

        return $sLi;
    }
        
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
        //if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        //if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";
        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);

    }//get_opentag

    //**********************************
    //             SETS
    //**********************************
    public function set_array_li($arObjLi){$this->arObjLi = $arObjLi;}
    public function add_li($oLi){$this->arObjLi[] = $oLi;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_array_li(){return $this->arObjLi;}

}//Xl
