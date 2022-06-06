<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.4.0
 * @name TheFramework\Helpers\Form\Form
 * @file Form.php
 * @date 30-04-2016 07:22 (SPAIN)
 * @observations: core library
 */
namespace TheFramework\Helpers\Form;

use TheFramework\Helpers\AbsHelper;

class Form extends AbsHelper
{
    private $_method;
    private $_enctype;
    private $_action;
    private $_js_onsubmit;
    
    private $oFieldset;
    private $oLegend;

    public function __construct($id="", $name="", $method="post", $innerhtml=""
            , $action="", $class="", $style="", $extras=[], $enctype="", $onsubmit="")
    {
        //enctype="multipart/form-data"
        $this->type = "form";
        $this->idprefix = "";
        $this->id = $id;
        $this->name = $name;
        $this->innerhtml = $innerhtml;
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        
        $this->extras = $extras;
        $this->_method = $method;
        $this->_action = $action;
        $this->_enctype = $enctype;
        $this->_js_onsubmit = $onsubmit;
    }

    public function get_html(): string
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";       
        $arHtml[] = $this->get_opentag();
        if($this->oFieldset) $arHtml[] = $this->oFieldset->get_opentag();
        if($this->oLegend) $arHtml[] = $this->oLegend->get_opentag();
        //Agrega a inner_html los valores obtenidos con get_html de cada objeto
        $this->_load_inner_objects();
        if($this->innerhtml)$arHtml[] = "$this->innerhtml\n";
        if($this->oLegend) $arHtml[] = $this->oLegend->get_closetag();
        if($this->oFieldset) $arHtml[] = $this->oFieldset->get_closetag();
        $arHtml[] = $this->get_closetag();

        return implode("",$arHtml);
    }

    public function get_opentag(): string
    {
        $arOpenTag = [];
        $arOpenTag[] = "<$this->type";
        if($this->id) $arOpenTag[] = " id=\"$this->idprefix$this->id\"";

        //eventos
        if($this->jsonblur) $arOpenTag[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange) $arOpenTag[] = " onchange=\"$this->jsonchange\"";
        if($this->jsonclick) $arOpenTag[] = " onclick=\"$this->jsonclick\"";
        if($this->jsonkeypress)$arOpenTag[] = " onkeypress=\"$this->jsonkeypress\"";
        if($this->jsonclick) $arOpenTag[] = " onclick=\"$this->jsonclick\"";
        if($this->jsonfocus) $arOpenTag[] = " onfocus=\"$this->jsonfocus\"";
        if($this->_js_onsubmit) $arOpenTag[] = " onsubmit=\"$this->_js_onsubmit\"";
        if($this->jsonmouseover) $arOpenTag[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $arOpenTag[] = " onmouseout=\"$this->jsonmouseout\"";
        
        //propios del formulario
        if($this->_method) $arOpenTag[] = " method=\"$this->_method\"";
        if($this->_action) $arOpenTag[] = " action=\"$this->_action\"";
        if($this->_enctype) $arOpenTag[] = " enctype=\"$this->_enctype\"";
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arOpenTag[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arOpenTag[] = " style=\"$this->style\"";
        //atributos extra
        if($this->_attr_dbfield) $arOpenTag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arOpenTag[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->extras) $arOpenTag[] = " ".$this->get_extras();

        $arOpenTag[] =">\n";
        return implode("",$arOpenTag);
    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    public function set_legend(HelperLegend $oLegend){$this->oLegend = $oLegend;}
    public function set_fieldset(HelperFieldset $oFieldset){$this->oFieldset = $oFieldset;}
    public function set_method($value){$this->_method = $value;}
    public function set_action($value){$this->_action = $value;}
    public function set_enctype($value){$this->_enctype = $value;}
    public function set_js_onsubmit($value){$this->_js_onsubmit=$value;}
    public function add_controltop($oHelper){if($oHelper) array_unshift($this->arinnerhelpers,$oHelper);}
    public function add_control($oHelper){$this->arinnerhelpers[]=$oHelper;}
    public function add_controls($arObjControls){$this->arinnerhelpers=$arObjControls;}
    public function readonly($readonly = true){$this->readonly = $readonly;}
    //**********************************
    //             GETS
    //**********************************

    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){parent::show_opentag();}
    public function show_closetag(){parent::show_closetag();}

}//HelperForm