<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name TheFramework\Helpers\AbsHelper
 */
namespace TheFramework\Helpers;

use TheFramework\Helpers\Form\Label;
use TheFramework\Helpers\Html\Style;

abstract class AbsHelper implements IHelper
{
    protected string $comment = "";
    protected string $type = "";
    protected string $id = "";
    protected string $name = "";
    protected string $idprefix = "";
    protected string $maxlength = "";
    protected string $placeholder = "";
    protected string $class = "";
    protected string $style = "";

    protected string $innerhtml = "";
    protected array $extras = [];
    protected bool $display = true;

    protected array $arclasses = [];
    protected $arstyles = [];
    protected $arinnerhelpers = [];
    protected $value;

    //Esto emula el atributo bloqueado. Si esta a true crea el control autoseleccionado con un
    //único valor en los objetos tipo select

    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $disabled = false;
    
    protected ?string $jsonclick = null;
    protected ?string $jsonchange = null;
    protected ?string $jsonkeypress = null;
    protected ?string $jsonkeydown = null;
    protected ?string $jsonkeyup = null;
    
    protected ?string $jsonblur = null;
    protected ?string $jsonfocus = null;
    protected ?string $jsonmouseover = null;
    protected ?string $jsonmouseout = null;
    
    //helpers
    protected ?Label $oLabel = null;
    protected ?Style $oStyle = null;

    protected function _load_cssclass(): self
    {
        if($this->arclasses)
            $this->class = trim(implode(" ",$this->arclasses));
        return $this;
    }

    protected function _load_style(): self
    {
        if($this->arstyles)
            $this->style = trim(implode(";",$this->arstyles));
        return $this;
    }

    protected function _load_inner_objects(): self
    {
        $tmp = [];
        foreach($this->arinnerhelpers as $mxValue) {
            if (is_object($mxValue) && method_exists($mxValue, "get_html")) {
                if ($this->readonly) {
                    if (method_exists($mxValue, "readonly")) {
                        $mxValue->readonly();
                    }
                }
                $tmp[] = $mxValue->get_html();
            }
            elseif (is_string($mxValue))
                $tmp[] = $mxValue;
        }
        if($tmp)
            $this->innerhtml .= implode("",$tmp);
        return $this;
    }

    public function show(): void
    {
        if($this->display) echo $this->get_html();
    }

    public function comment(string $value): self {$this->comment = $value; return $this;}
    public function idprefix(string $value): self {$this->idprefix=$value; return $this;}
    public function id(string $value): self {$this->id=$value; return $this;}
    
    public function display(bool $display=true): self {$this->display = $display; return $this;}
    public function required(bool $required=true): self {$this->required = $required; return $this;}
    public function readonly(bool $readonly=true): self {$this->readonly = $readonly; return $this;}
    public function disabled(bool $disabled=true): self {$this->disabled = $disabled; return $this;}
    
    public function on_click(string $jscode): self {$this->jsonclick = $jscode; return $this;}
    public function on_change(string $jscode): self {$this->jsonchange = $jscode; return $this;}
    public function on_keypress(string $jscode): self {$this->jsonkeypress = $jscode; return $this;}
    public function on_keydown(string $jscode): self {$this->jsonkeydown = $jscode; return $this;}
    public function on_keyup(string $jscode): self {$this->jsonkeyup = $jscode; return $this;}
    public function on_blur(string $jscode): self {$this->jsonblur = $jscode; return $this;}
    public function on_focus(string $jscode): self {$this->jsonfocus = $jscode; return $this;}
    public function on_mouseover(string $jscode): self {$this->jsonmouseover = $jscode; return $this;}
    public function on_mouseout(string $jscode): self {$this->jsonmouseout = $jscode; return $this;}
    
    public function add_class(string $class): self {if($class) $this->arclasses[] = $class; return $this;}
    public function style(string $style): self {$this->arstyles = []; if($style) $this->arstyles[] = $style; return $this;}

    public function add_inner_object(IHelper|string $mxValue): self
    {
        if($mxValue)
            $this->arinnerhelpers[] = $mxValue;
        return $this;
    }
    
    public function set_extras(array $extras): self
    {
        $this->extras = $extras;
        return $this;
    }

    public function add_extras(string $attr, ?string $value=null): self
    {
        if($attr)
            $this->extras[$attr] = $value;
        else
            $this->extras[] = $value;

        return $this;
    }
    
    public function placeholder(string $value): self {$this->placeholder = htmlentities($value); return $this;}
    public function innerhtml(string $innerhtml, $rawmode=true): self
    {$rawmode ? $this->innerhtml=$innerhtml : $this->innerhtml = htmlentities($innerhtml); return $this;}
    public function type(string $value): self {$this->type = $value; return $this;}
    protected function name(string $value): self {$this->name = $value; return $this;}

    public function label(Label $oLabel){$this->oLabel = $oLabel;}
    public function class(string $class): self {$this->arclasses=[];if($class)$this->arclasses[] = $class; return $this;}
    public function style_object(HelperStyle $oStyle): self {$this->oStyle = $oStyle; return $this;}
    public function reset_class(){$this->arclasses=[];$this->class="";}
    public function reset_style(){$this->arstyles=[];$this->style="";}
    public function reset_innerhelpers(): self {$this->arinnerhelpers=[]; return $this;}
    public function value($value, bool $rawmode=true): self
    {($rawmode)?$this->value = htmlentities($value):$this->value=$value; return $this;}
    protected function _get_escaped_quot(string $value): string
    {
        return str_replace("\"","&quot;",$value);
    }
    
    //**********************************
    //             GETS
    //**********************************
    public function get_id():string {return $this->id;}
    public function get_type():string {return $this->type;}
    public function get_class():string {return $this->class;}
    public function get_extras(bool $asstring=true): array|string
    {
        if(!$asstring) return $this->extras;
        $extras = [];
        foreach($this->extras as $attr=>$value) {
            if (!is_integer($attr)) {
                $extras[] = "$attr=\"$value\"";
                continue;
            }
            if(strstr($value,"="))
                $extras[] = $value;
            elseif($value!==null)
                $extras[] = "$attr=\"$value\"";
            else
                $extras[] = $attr;
        }
        return implode(" ",$extras);
    }
    
    public function get_innerhtml():string {return $this->innerhtml;}
    protected function is_disabled():bool {return $this->disabled;}

    protected function get_name(){return $this->name;}

    //**********************************
    // OVERRIDE TO PUBLIC IF NECESSARY
    //**********************************
    //to override
    public abstract function get_opentag(): string;
    //to override
    protected function get_closetag(){return "</$this->type>\n";}
    //to override
    protected function show_opentag(){echo $this->get_opentag();}
    //to override
    protected function show_closetag(){echo $this->get_closetag();}

    protected function get_label(): ?Label {return $this->oHlpLabel;}
    protected function get_style(): ?Style {return $this->oHlpStyle;}
    protected function get_placeholder(): string {return $this->placeholder;}
    
    protected function get_value(bool $rawmode=true): string
    {
        return $rawmode ? $this->value : htmlentities($this->value);
    }
}