<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.0
 * @name TheFramework\Helpers\Form\Select
 * @date 17-02-2016 17:27
 * @file Select.php
 */
namespace TheFramework\Helpers\Form;
use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

class Select extends AbsHelper
{
    private $arOptions;
    private $mxValuesToSelect=null;
    private $_selected_as_hidden=null;
    private $_isMultiple;
    private $_size;
    
    public function __construct
    ($arOptions, $id="", $name="", Label $oLabel=null, $mxValueToSelect ="", $size=1
     ,$isMultiple=false, $extras=[], $class="", $readonly=false)
    {
        $this->type = "select";
        $this->mxValuesToSelect = $mxValueToSelect;
        
        $this->arOptions = $arOptions;
        $this->idprefix = "";
        $this->id = $id;
        $this->name = $name;
        $this->_isMultiple = $isMultiple;
        if($this->_size>1) $this->_isMultiple = true;
        $this->_size = $size;
        $this->oLabel = $oLabel;
        $this->extras = $extras;
        if($class) $this->arclasses[] = $class;
        $this->readonly = $readonly;
    }

    public function get_html()
    {  
        $arHtml = [];
        if($this->oLabel) $arHtml[] = $this->oLabel->get_html();
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = $this->get_opentag(); 
        //INICIO OPTIONS
        if(!is_array($this->mxValuesToSelect)) 
            $mxValueToSelect = (string)$this->mxValuesToSelect;
        else 
            $mxValueToSelect = $this->mxValuesToSelect;
        
        //No es readonly
        if(!$this->readonly)        
        {
            if(!$this->_isMultiple)
            {    
                //bug($mxValueToSelect,"to sel of $this->id");
                foreach($this->arOptions as $sValue=>$sInnerText)
                {
                    $sOptionValue = (string)$sValue;
                    //bug("$mxValueToSelect===$sOptionValue");
                    $isSelected = ($mxValueToSelect===$sOptionValue);
                    $arHtml[] = $this->build_htmloption($sValue, $sInnerText, $isSelected);
                }
            }
            //Multiple
            else
            {
                foreach($this->arOptions as $sValue=>$sInnerText)
                {
                    if(is_array($mxValueToSelect))
                        $isSelected = in_array($sValue, $mxValueToSelect);
                    else
                        $isSelected = ($mxValueToSelect==((string)$sValue));
                    $arHtml[] = $this->build_htmloption($sValue, $sInnerText, $isSelected);
                }
            }
        }
        //es readonly
        else
        {
            if(!$this->_isMultiple)
            {
                //Hay dos opciones y una es vacia.
                if(count($this->arOptions)<=2 && key_exists("",$this->arOptions))
                {
                    unset($this->arOptions[""]);
                    $arItemReadonly = $this->arOptions;
                }
                //no tiene item en blanco
                else
                {    
                    //recupera el valor de autoselección
                    $arItemReadonly = $this->get_item_readonly($this->arOptions,$mxValueToSelect);
                }
                foreach($arItemReadonly as $sValue => $sText)
                    $arHtml[] = $this->build_htmloption($sValue, $sText, true);
            }
            //es readonly y multiple
            else
            {
                //bug("is multiple"); bug(is_array($this->_isMultiple),"is multiple");
                //Falta implementar
            }
        }//fin es readonly
        //FIN OPTIONS
        
        $arHtml[] = $this->get_closetag();
        //el valor seleccionado se crea como hidden
        $arHtml[] = $this->_selected_as_hidden;
        return implode("",$arHtml);
    }//get_html
        
    public function get_opentag()
    {
        $arHtml[] = "<$this->type";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
        //Nombre dependiendo si es multiple o no
        if($this->_isMultiple) $arHtml[] = " name=\"$this->idprefix$this->name[]\"";
        else $arHtml[] = " name=\"$this->idprefix$this->name\"";
        
        if($this->_size) $arHtml[] = " size=\"$this->_size\"";
        if($this->_isMultiple) $arHtml[] = " multiple";
        if($this->disabled) $arHtml[] = " disabled";
        //if($this->readonly) $arHtml[] = " readonly"; //no existe esta propiedad para select
        if($this->_isRequired) $arHtml[] = " required"; 
        
        //eventos
        if($this->jsonblur) $arHtml[] = " onblur=\"$this->jsonblur\"";
        if($this->jsonchange)$arHtml[] = " onchange=\"$this->jsonchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->jsonkeypress) $arHtml[] = " onon_keypress=\"$this->jsonkeypress\"";
        if($this->jsonfocus) $arHtml[] = " onfocus=\"$this->jsonfocus\"";
        if($this->jsonmouseover) $arHtml[] = " onmouseover=\"$this->jsonmouseover\"";
        if($this->jsonmouseout) $arHtml[] = " onmouseout=\"$this->jsonmouseout\""; 
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arHtml[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arHtml[] = " style=\"$this->style\"";
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        $arHtml[] = ">\n";
        return implode("",$arHtml);        
    }//get_opentag
   
    /**
     * @param array $arOptions
     * @param string $sValueToSelect
     * @return array De un solo item tipo array[$value]=innertext
     */
    private function get_item_readonly($arOptions,$sValueToSelect)
    {
        $arItemReadOnly = array(""=>"");
        foreach($arOptions as $sOptValue=>$sOptText)
            if($sValueToSelect == (string)$sOptValue)
            {    
                $arItemReadOnly = array($sOptValue=>$sOptText);
                return $arItemReadOnly;
            }
        return $arItemReadOnly;
    }
   
    /**
     * @param array $arOptions 
     * @param array $arValuesToSelect
     * @return array
     */
    private function get_items_readonly($arOptions,$arValuesToSelect=[])
    {
        $arItemReadOnly = [];
        
        foreach($arOptions as $sOptValue=>$sOptText)
            foreach($arValuesToSelect as $sValue)
                if($sValue == (string)$sOptValue)
                    $arItemReadOnly[$sOptValue] = $sOptText;
        
        if(empty($arItemReadOnly))$arItemReadOnly = array(""=>"");
        
        return $arItemReadOnly;
    }
    
    private function build_htmloption($value,$innertext,$isSelected=false)
    {
        $sOption = "";
        $sOption .= "\t<option";
        $value = $this->_get_escaped_quot($value);
        $sOption .= " value=\"$value\"";
        if($isSelected) $sOption .= " selected";
        $sOption .= ">";
        $sOption .= htmlentities($innertext);                  
        $sOption .= "</option>\n";
        return $sOption;
    }

    //**********************************
    //             SETS
    //**********************************
    //protected function value(){;}
    
    public function readonly($readonly=true){$this->readonly = $readonly;}
    public function name($value){$this->name = $value;}
    public function setvalue_to_select($mxValues){$this->mxValuesToSelect = $mxValues;}
    public function set_null_option_text($value){$this->_null_option = $value;}
    public function set_multiple_size($value)
    {
        $this->_size = (int)$value;
        if($this->_size>1) $this->_isMultiple = true;
    }
    
    /**
     * Usar en caso de aplicar el atributo disabled: set_extras("disabled");
     */
    public function set_selectedvalue_as_hidden_on()
    {
        $this->_selected_as_hidden = "
        <input type=\"hidden\" name=\"$this->name\" id=\"$this->id\" value=\"$this->mxValuesToSelect\"/>\n";
    }
    
    public function set_options($arOptions){$this->arOptions=$arOptions;}    
    public function required($isRequired = true){$this->_isRequired=$isRequired;}
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->name;}
    //public function getvalue(){return $this->value;}
    public function get_selectedvalue(){return $this->mxValuesToSelect;}
    public function get_closetag(){return parent::get_closetag();}
}