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

final class Form extends AbsHelper
{
    private const TYPE = "form";
    public const METHOD_POST = "post";
    public const METHOD_GET = "get";
    public const ENCTYPE_MULTIPART = "multipart/form-data";
    
    private string $method = "";
    private string $enctype = "";
    private string $action = "";
    protected ?string $jsonsubmit = null;
    
    private ?Fieldset $oFieldset = null;
    private ?Legend $oLegend = null;

    public function __construct($id="", $name="", $method="post", $innerhtml=""
            , $action="", $class="", $style="", $extras=[], $enctype="", $onsubmit="")
    {
        //enctype="multipart/form-data"
        $this->type = self::TYPE;
        $this->idprefix = "";
        $this
            ->id($id)
            ->name($name)
            ->innerhtml()
        ;

        $this->name = $name;
        $this->innerhtml = $innerhtml;
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        
        $this->extras = $extras;
        $this->method = $method;
        $this->action = $action;
        $this->enctype = $enctype;
        $this->jsonsubmit = $onsubmit;
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
        if($this->jsonfocus) $arOpenTag[] = " onfocus=\"$this->jsonfocus\"";
        if($this->jsonsubmit) $arOpenTag[] = " onsubmit=\"$this->jsonsubmit\"";
        if($this->jsonmouseover) $arOpenTag[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $arOpenTag[] = " onmouseout=\"$this->jsonmouseout\"";
        
        //propios del formulario
        if($this->method) $arOpenTag[] = " method=\"$this->method\"";
        if($this->action) $arOpenTag[] = " action=\"$this->action\"";
        if($this->enctype) $arOpenTag[] = " enctype=\"$this->enctype\"";
        
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
    public function setmethod($value){$this->method = $value;}
    public function setaction($value){$this->action = $value;}
    public function setenctype($value){$this->enctype = $value;}
    public function setjsonsubmit($value){$this->jsonsubmit=$value;}
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