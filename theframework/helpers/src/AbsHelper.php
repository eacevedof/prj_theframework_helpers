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
    protected $arStyles = [];
    protected $arinnerhelpers = [];
    protected $_value;

    //Esto emula el atributo bloqueado. Si esta a true crea el control autoseleccionado con un
    //único valor en los objetos tipo select
    protected bool $_is_primarykey = false;
    protected bool $_readonly = false;
    protected bool $required = false;
    protected bool $disabled = false;
    protected bool $_isPrimaryKey = false;
    protected bool $_isPostback = false;
    protected bool $_isEnterInsert = false;//aplica action=insert
    protected bool $_isEnterUpdate = false;//aplica action=update
    protected bool $_isEnterSubmit = false;//no aplica nada
    
    protected ?string $jsonclick = null;
    protected ?string $jsonchange = null;
    protected ?string $jsonkeypress = null;
    protected ?string $jsonkeydown = null;
    protected ?string $_jsonkeyup = null;
    
    protected ?string $_js_onblur = null;
    protected ?string $_js_onfocus = null;
    protected ?string $_js_onmouseover = null;
    protected ?string $_js_onmouseout = null;

    protected ?string $_attr_dbtype = null;
    protected ?string $_attr_dbfield = null;

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
        if($this->arStyles)
            $this->style = trim(implode(";",$this->arStyles));
        return $this;
    }

    protected function _load_inner_objects(): self
    {
        $tmp = [];
        foreach($this->arinnerhelpers as $mxValue) {
            if (is_object($mxValue) && method_exists($mxValue, "get_html"))
                $tmp[] = $mxValue->get_html();
            elseif (is_string($mxValue))
                $tmp[] = $mxValue;
        }
        if($tmp)
            $this->innerhtml .= implode("",$tmp);
        return $this;
    }
    
    private function _concat_param_value(string $param, string $value): string
    {
        $value = urlencode($value);
        return "$param=$value";
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
    public function on_keyup(string $jscode): self {$this->_jsonkeyup = $jscode; return $this;}
    public function on_blur(string $jscode): self {$this->_js_onblur = $jscode; return $this;}
    public function on_focus(string $jscode): self {$this->_js_onfocus = $jscode; return $this;}
    public function on_mouseover(string $jscode): self {$this->_js_onmouseover = $jscode; return $this;}
    public function on_mouseout(string $jscode): self {$this->_js_onmouseout = $jscode; return $this;}
    
    public function add_class($class){if($class) $this->arclasses[] = $class;}

    public function add_style($style){if($style) $this->arStyles[] = $style;}

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
    
    public function setplaceholder($value){$this->placeholder = htmlentities($value);}
    public function set_attr_dbtype($value){$this->_attr_dbtype=$value;}
    public function set_attr_dbfield($value){$this->_attr_dbfield=$value;}
    public function set_as_primarykey($isPk=true){$this->_is_primarykey = $isPk;}
    public function innerhtml($sInnerHtml,$asEntity=0)
    {if($asEntity)$this->innerhtml = htmlentities($sInnerHtml);else $this->innerhtml=$sInnerHtml;}
    public function settype($value){$this->type = $value;}
    public function set_postback($isOn=true){$this->_isPostback=$isOn;}
    public function on_enterinsert($isOn=true){$this->_isEnterInsert=$isOn;}
    public function on_enterupdate($isOn=true){$this->_isEnterUpdate=$isOn;}
    public function on_entersubmit($isOn=true){$this->_isEnterSubmit=$isOn;}
    
    protected function setname($value){$this->name = $value;}

    public function set_label(\TheFramework\Helpers\Form\Label $oLabel){$this->oLabel = $oLabel;}
    public function set_class($class){$this->arclasses=[];if($class)$this->arclasses[] = $class;}    
    public function set_style($value){$this->arStyles=[];if($value) $this->arStyles[] = $value;}
    protected function set_style_object(HelperStyle $oStyle){$this->oStyle = $oStyle;}
    protected function reset_class(){$this->arclasses=[];$this->class="";}
    protected function reset_style(){$this->arStyles=[];$this->style="";}
    protected function reset_inner_object(){$this->arinnerhelpers=[];}
    protected function set_inner_objects($arObjHelpers){$this->arinnerhelpers=$arObjHelpers;}
    protected function set_value($value,$asEntity=0){($asEntity)?$this->_value = htmlentities($value):$this->_value=$value;}
    protected function get_cleaned($sString)
    {
        $sString = str_replace("\"","&quot;",$sString);
        return $sString;
    }
    
    //**********************************
    //             GETS
    //**********************************
    public function get_id(){return $this->id;}
    public function gettype(){return $this->type;}
    public function get_class(){return $this->class;}
    public function get_extras($asString=true)
    {
        $extras = [];
        if($asString)
        {
            foreach($this->extras as $sKey=>$value)
            {
                //Esto no funcionaría si aplicase valores para mostrar un atributo 0="nuevo"
                if(is_integer($sKey))
                {
                    if(strstr($value,"="))
                        $extras[] = $value;
                    elseif($value!==null)
                        $extras[] = "$sKey=\"$value\"";
                    else 
                        $extras[] = $sKey;
                }
                else 
                {
                    $extras[] = "$sKey=\"$value\"";
                }
            }
            return implode(" ",$extras);
        }
        else
            return $this->extras;
    }//get_extras
    
    public function get_innerhtml(){return $this->innerhtml;}
    protected function isdisabled(){return $this->disabled;}

    public function get_dbtype(){return $this->_attr_dbtype;}
    public function is_primarykey(){return $this->_is_primarykey;}
    protected function getname(){return $this->name;}
    
    protected function get_icon_path($isIcon,$sIconFile)
    {
        $sIconPath = "images/";
        $sIconPath .= $sIconFile;
        if($isIcon && is_file($sIconPath))
            return $sIconPath;
        return "";    
    }
    
    //**********************************
    // OVERRIDE TO PUBLIC IF NECESSARY
    //**********************************
    //to override
    protected function get_opentag(){}
    //to override
    protected function get_closetag(){return "</$this->type>\n";}
    //to override
    protected function show_opentag(){echo $this->get_opentag();}
    //to override
    protected function show_closetag(){echo $this->get_closetag();}
    protected function get_label(){return $this->oHlpLabel;}
    protected function get_style(){return $this->oHlpStyle;}
    protected function getplaceholder(){return $this->placeholder;}

    protected function is_enterinsert(){return $this->_isEnterInsert;}
    protected function is_enterupdate(){return $this->_isEnterUpdate;}
    protected function is_entersubmit(){return $this->_isEnterSubmit;}
    protected function get_value($asEntity=0){if($asEntity) return htmlentities($this->_value); else return $this->_value;}    
}