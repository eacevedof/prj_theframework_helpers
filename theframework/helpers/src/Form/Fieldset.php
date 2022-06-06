<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.3
 * @name TheFramework\Helpers\Form\Fieldset
 * @file Fieldset.php
 * @date 06-06-2013 14:02 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers\Form;
use TheFramework\Helpers\AbsHelper;

final class Fieldset extends AbsHelper
{
    private const TYPE = "fieldset";
    
    public function __construct(
        string $innerhtml="", 
        string $id="", 
        string $class="", 
        string $style="", 
        array $extras=[]
    ) {
        
        $this
            ->id($id)
            ->innerhtml($innerhtml)
            ->class($class)
            ->style($style)
            ->extras($extras)
        ;
    }

    public function get_html(): string
    {  
        $arhtml = [];
        if($this->comment) $arhtml[] = "<!-- $this->comment -->\n";
        $arhtml[] = $this->get_opentag();
        $this->_load_inner_objects();
        $arhtml[] = $this->innerhtml;
        $arhtml[] = $this->get_closetag();
        return implode("",$arhtml);
    }//get_html
        
    public function get_opentag(): string
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
        if($this->extras) $arOpenTag[] = " ".$this->get_extras();
        $arOpenTag[] =">";        
        return implode("",$arOpenTag);        
    }
}