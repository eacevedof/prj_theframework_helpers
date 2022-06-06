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
use TheFramework\Helpers\IHelper;

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

    public function __construct(
        string $id="", 
        string $name="", 
        string $method=self::METHOD_POST, 
        string $innerhtml="", 
        string $action="", 
        string $class="", 
        string $style="", 
        array $extras=[], 
        string $enctype="", 
        string $onsubmit=""
    ) {
        //enctype="multipart/form-data"
        $this
            ->type(self::TYPE)
            ->id($id)
            ->name($name)
            ->method($method)
            ->innerhtml($innerhtml)
            ->action($action)
            ->class($class)
            ->style($style)
            ->extras($extras)
            ->enctype($enctype)
            ->on_submit($onsubmit)
        ;
    }

    public function get_html(): string
    {  
        $arhtml = [];
        if($this->comment) $arhtml[] = "<!-- $this->comment -->\n";       
        $arhtml[] = $this->get_opentag();
        if($this->oFieldset) $arhtml[] = $this->oFieldset->get_opentag();
        if($this->oLegend) $arhtml[] = $this->oLegend->get_opentag();
        $this->_load_inner_objects();
        if($this->innerhtml) $arhtml[] = "$this->innerhtml\n";
        if($this->oLegend) $arhtml[] = $this->oLegend->get_closetag();
        if($this->oFieldset) $arhtml[] = $this->oFieldset->get_closetag();
        $arhtml[] = $this->get_closetag();

        return implode("",$arhtml);
    }

    public function get_opentag(): string
    {
        $opentag = [];
        $opentag[] = "<$this->type";
        if($this->id) $opentag[] = " id=\"$this->idprefix$this->id\"";

        //eventos
        if($this->jsonblur) $opentag[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange) $opentag[] = " onchange=\"$this->jsonchange\"";
        if($this->jsonclick) $opentag[] = " onclick=\"$this->jsonclick\"";
        if($this->jsonkeypress)$opentag[] = " onkeypress=\"$this->jsonkeypress\"";
        if($this->jsonfocus) $opentag[] = " onfocus=\"$this->jsonfocus\"";
        if($this->jsonsubmit) $opentag[] = " onsubmit=\"$this->jsonsubmit\"";
        if($this->jsonmouseover) $opentag[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $opentag[] = " onmouseout=\"$this->jsonmouseout\"";
        
        //propios del formulario
        if($this->method) $opentag[] = " method=\"$this->method\"";
        if($this->action) $opentag[] = " action=\"$this->action\"";
        if($this->enctype) $opentag[] = " enctype=\"$this->enctype\"";
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $opentag[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $opentag[] = " style=\"$this->style\"";
        //atributos extra
        if($this->_attr_dbfield) $opentag[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $opentag[] = " dbtype=\"$this->_attr_dbtype\"";              
        if($this->extras) $opentag[] = " ".$this->get_extras();

        $opentag[] =">\n";
        return implode("",$opentag);
    }//get_opentag

    public function legend(HelperLegend $oLegend): self {$this->oLegend = $oLegend; return $this;}
    public function fieldset(HelperFieldset $oFieldset): self {$this->oFieldset = $oFieldset; return $this;}
    public function method(string $value): self {$this->method = $value; return $this;}
    public function action(string $value): self {$this->action = $value; return $this;}
    public function enctype(string $value): self {$this->enctype = $value; return $this;}
    public function on_submit(string $jscode): self {$this->jsonsubmit=$jscode; return $this;}
    public function first_inner(IHelper $oHelper): self {array_unshift($this->arinnerhelpers,$oHelper); return $this;}
}