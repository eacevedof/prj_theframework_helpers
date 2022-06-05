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

    //Esto emula el atributo bloqueado. Si esta a TRUE crea el control autoseleccionado con un
    //único valor en los objetos tipo select
    protected bool $_is_primarykey = false;
    protected bool $_isReadOnly = false;
    protected bool $_isRequired = false;
    protected bool $_isDisabled = false;
    protected bool $_isPrimaryKey = false;
    protected bool $_isPostback = false;
    protected bool $_isEnterInsert = false;//aplica action=insert
    protected bool $_isEnterUpdate = false;//aplica action=update
    protected bool $_isEnterSubmit = false;//no aplica nada
    
    protected ?string $_js_onclick = null;
    protected ?string $_js_onchange = null;
    protected ?string $_js_onkeypress = null;
    protected ?string $_js_onkeydown = null;
    protected ?string $_js_onkeyup = null;
    
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
    /**
     * Agrega al atributo innerhtml el string obtenido con el metodo get_html()
     */
    protected function _load_inner_objects()
    {
        foreach($this->arinnerhelpers as $mxValue)
            if(is_object($mxValue) && method_exists($mxValue,"get_html"))
                $this->innerhtml .= $mxValue->get_html();
            elseif(is_string($mxValue))
                $this->innerhtml .= $mxValue;
    }
    
    protected function concat_param_value($sParamName,$sValue)
    {
        $sValue = urlencode($sValue);
        return "$sParamName=$sValue";
    }  
    
    protected function build_uri_params_with_keys($arKeysAndValues=[])
    {
        $arDestinyKeys = [];
        $sDestinyKeys = "";
        foreach($arKeysAndValues as $sFieldName=>$value)
            $arDestinyKeys[]=$this->concat_param_value($sFieldName, $value);

        if(!empty($arDestinyKeys))
            $sDestinyKeys = implode("&",$arDestinyKeys);
        return $sDestinyKeys;
    }
    
    protected function extract_fields_and_values($arFields, $arFieldNames)
    {
        $arExtracted = [];
        foreach($arFields as $sFieldName=>$value)
            if(in_array($sFieldName, $arFieldNames))
                $arExtracted[$sFieldName] = $value;
        return $arExtracted;
    }
       
    /**
     * De un array tipo ("fieldname"=>"value") recupera solo los "value" de los "fieldname"
     * indicados en $arFieldNames
     * @param array $arFields
     * @param array $arFieldNames
     * @param boolean $asArray
     * @param string $sSeparator
     * @return mixed Array or String depende de $asArray
     */
    protected function extract_values($arFields, $arFieldNames, $asArray=false, $sSeparator="-")
    {
        $arExtracted = []; $sExtracted="";
        foreach($arFields as $sFieldName=>$value)
            if(in_array($sFieldName, $arFieldNames)) 
                $arExtracted[] = $value;

        if(!empty($arExtracted) && !$asArray)
            $sExtracted = implode($sSeparator,$arExtracted);
        elseif(empty($arExtracted) && !$asArray)
            $sExtracted = "";
        else
            $sExtracted = $arExtracted;
        return $sExtracted;
    }  
    
    public function show(){if($this->display) echo $this->get_html();}
    
    //**********************************
    //             SETS
    //**********************************
    public function setcomment($value){$this->comment = $value;}
    public function setidprefix($value){$this->idprefix=$value;}
    public function setid($value){$this->id=$value;}
    public function set_js_onclick($value){$this->_js_onclick = $value;}
    public function set_js_onchange($value){$this->_js_onchange = $value;}
    public function set_js_keypress($value){$this->_js_onkeypress = $value;}
    public function set_js_keydown($value){$this->_js_onkeydown = $value;}
    public function set_js_keyup($value){$this->_js_onkeyup = $value;}
    public function set_js_onblur($value){$this->_js_onblur = $value;}
    public function set_js_onfocus($value){$this->_js_onfocus = $value;}
    public function set_js_onmouseover($value){$this->_js_onmouseover = $value;}
    public function set_js_onmouseout($value){$this->_js_onmouseout = $value;}
    
    public function display($showIt=TRUE){$this->display = $showIt;}        
    protected function required($isRequired=TRUE){$this->_isRequired = $isRequired;}
    protected function readonly($isReadOnly=TRUE){$this->_isReadOnly = $isReadOnly;}
    protected function disabled($isDisabled=TRUE){$this->_isDisabled = $isDisabled;}
    public function add_class($class){if($class) $this->arclasses[] = $class;}

    public function add_style($style){if($style) $this->arStyles[] = $style;}
    /**
     * 
     * @param mixed $mxValue helper object or string
     */
    public function add_inner_object($mxValue){if($mxValue) $this->arinnerhelpers[] = $mxValue;}
    
    public function set_extras(array $value){$this->extras = []; if($value) $this->extras = $value;}
    public function add_extras($sKey,$sValue=null)
    {
        if($sKey)
            $this->extras[$sKey] = $sValue;
        else
            $this->extras[] = $sValue;
    }
    
    protected function setplaceholder($value){$this->placeholder = htmlentities($value);}
    public function set_attr_dbtype($value){$this->_attr_dbtype=$value;}
    public function set_attr_dbfield($value){$this->_attr_dbfield=$value;}
    public function set_as_primarykey($isPk=TRUE){$this->_is_primarykey = $isPk;}
    public function set_innerhtml($sInnerHtml,$asEntity=0)
    {if($asEntity)$this->innerhtml = htmlentities($sInnerHtml);else $this->innerhtml=$sInnerHtml;}
    public function settype($value){$this->type = $value;}
    public function set_postback($isOn=TRUE){$this->_isPostback=$isOn;}
    public function on_enterinsert($isOn=TRUE){$this->_isEnterInsert=$isOn;}
    public function on_enterupdate($isOn=TRUE){$this->_isEnterUpdate=$isOn;}
    public function on_entersubmit($isOn=TRUE){$this->_isEnterSubmit=$isOn;}
    
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
    public function getid(){return $this->id;}
    public function gettype(){return $this->type;}
    public function get_class(){return $this->class;}
    public function get_extras($asString=TRUE)
    {
        $extras = [];
        if($asString)
        {
            foreach($this->extras as $sKey=>$sValue)
            {
                //Esto no funcionaría si aplicase valores para mostrar un atributo 0="nuevo"
                if(is_integer($sKey))
                {
                    if(strstr($sValue,"="))
                        $extras[] = $sValue;
                    elseif($sValue!==null)
                        $extras[] = "$sKey=\"$sValue\"";
                    else 
                        $extras[] = $sKey;
                }
                else 
                {
                    $extras[] = "$sKey=\"$sValue\"";
                }
            }
            return implode(" ",$extras);
        }
        else
            return $this->extras;
    }//get_extras
    
    public function get_innerhtml(){return $this->innerhtml;}
    protected function is_disabled(){return $this->_isDisabled;}

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