<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.2.2
 * @name TheFramework\Helpers\Form\Textarea
 * @date 21-11-2016 22:24 (SPAIN)
 * @file Textarea.php
 * @observations
 */
namespace TheFramework\Helpers\Input;
use TheFramework\Helpers\TheFrameworkHelper;

class Textarea extends TheFrameworkHelper
{ 
    private $_cols;
    private $_rows;
    private $isCounterSpan;
    private $isCounterJs;
    
    public function __construct
    ($id="",$name="",$innerhtml="",$arExtras="",$maxlength=-1
    ,$cols=40,$rows=8,$class="",$style="",Label $oLabel=NULL)
    {
        $this->_type = "textarea";

        $this->_idprefix = "";
        $this->_id = $id;
        $this->_inner_html = $innerhtml;
        $this->_name = $name;
        $this->_cols = $cols;
        $this->_rows = $rows;

        if($class) $this->arClasses[] = $class;
        if($style) $this->arStyles[] = $style;
       
        $this->_maxlength = $maxlength;
        $this->arExtras = $arExtras;
        $this->oLabel = $oLabel;
        
        $this->isCounterSpan = TRUE;
        $this->isCounterJs = TRUE;        
    }//__construct
    
    private function js_counter()
    {
?>

<script type="text/javascript" helper="textarea.js_counter">
    var fn_txaspan = function(oTextarea,sValue)
    {
        var sNameSpan = "sp"+oTextarea.id;
        var oSpan = document.getElementById(sNameSpan);
        if(oSpan)
            oSpan.innerHTML = sValue;
    };
    
    var fn_txamaxlength = function(oTextarea,oEvent)
    {
        var sInnerHtml = "";
        var isEvent = true;
        if(oTextarea)
        {
            var iMaxLen = oTextarea.getAttribute("maxlength") || 1000;
            sInnerHtml = oTextarea.value;
            var iLen = sInnerHtml.length;
            if(iLen>iMaxLen)
            {
                isEvent = false;
                iLen = iMaxLen;
                oTextarea.value = sInnerHtml;
            }
            var sLenText = iLen+"/"+iMaxLen;
            fn_txaspan(oTextarea,sLenText);
        }
        return isEvent;
    };
</script>    
<?php
    }//js_counter
    
    public function get_html()
    {  
        $arHtml = array();
        if($this->oLabel) $arHtml[] = $this->oLabel->get_html();
        //Una longitud de 0 tiene un comportamiento parecido a un bloqueado
        if($this->_maxlength>-1)
            $this->_js_onkeyup .= " return fn_txamaxlength(this,event);";
        
        if($this->_comments) $arHtml[] = "<!-- $this->_comments -->\n";
        $arHtml[] = $this->get_opentag();
        $arHtml[] = htmlentities($this->_inner_html);
        $arHtml[] = $this->get_closetag();
        
        if($this->isCounterSpan)
            $arHtml[] = "\n<span id=\"sp$this->_idprefix$this->_id\"></span>"; 
        
        if($this->isCounterJs)
            $this->js_counter();
        
        return implode("",$arHtml);
    }//get_html
    
    public function get_opentag()
    {
        $arOpenTag[] = "<$this->_type ";
        if($this->_id) $arOpenTag[] = "id=\"$this->_idprefix$this->_id\" ";
        if($this->_name) $arOpenTag[] = "name=\"$this->_idprefix$this->_name\" ";
        if($this->_rows) $arOpenTag[] = "rows=\"$this->_rows\" ";
        if($this->_cols) $arOpenTag[] = "cols=\"$this->_cols\" ";
        //propiedades html5
        if($this->_isDisabled) $arOpenTag[] = "disabled ";
        if($this->_isReadOnly) $arOpenTag[] = "readonly "; 
        if($this->_isRequired) $arOpenTag[] = "required "; 
        //eventos
        if($this->_js_onfocus) $arOpenTag[] = "onfocus=\"$this->_js_onfocus\" ";
        if($this->_js_onblur) $arOpenTag[] = "onblur=\"$this->_js_onblur\" ";
        if($this->_js_onchange) $arOpenTag[] = "onchange=\"$this->_js_onchange\" ";
        if($this->_js_onclick) $arOpenTag[] = "onclick=\"$this->_js_onclick\" ";
        
        if($this->_js_onkeypress)
        {
            if($this->_isEnterInsert)
                $arOpenTag[] = "onkeypress=\"$this->_js_onkeypress;onenter_insert(event);\" ";
            elseif($this->_isEnterUpdate)
                $arOpenTag[] = "onkeypress=\"$this->_js_onkeypress;onenter_update(event);\" ";
            elseif($this->_isEnterSubmit)
                $arOpenTag[] = "onkeypress=\"$this->_js_onkeypress;onenter_submit(event);\" ";
            $arOpenTag[] = "onkeypress=\"$this->_js_onkeypress\" ";
        }
        
        if($this->_js_onkeydown) $arOpenTag[] = "onkeydown=\"$this->_js_onkeydown\" ";
        if($this->_js_onkeyup) $arOpenTag[] = "onkeyup=\"$this->_js_onkeyup\" ";
        //postback(): Funcion definida en HelperJavascript
        elseif($this->_isEnterInsert) $arOpenTag[] = "onkeypress=\"onenter_insert(event);\" ";
        elseif($this->_isEnterUpdate) $arOpenTag[] = "onkeypress=\"onenter_update(event);\" ";
        elseif($this->_isEnterSubmit) $arOpenTag[] = "onkeypress=\"onenter_submit(event);\" ";
        
        if($this->_js_onmouseover) $arOpenTag[] = "onmouseover=\"$this->_js_onmouseover\" ";
        if($this->_js_onmouseout) $arOpenTag[] = "onmouseout=\"$this->_js_onmouseout\" ";

        //aspecto
        $this->load_cssclass();
        if($this->_class) $arOpenTag[] = "class=\"$this->_class\" ";
        $this->load_style();
        if($this->_style) $arOpenTag[] = "style=\"$this->_style\" ";
        //atributos extras
        if($this->_maxlength) $arOpenTag[] = "maxlength=\"$this->_maxlength\" ";
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();
        if($this->_isPrimaryKey) $arOpenTag[] = "pk=\"pk\" ";
        if($this->_attr_dbtype) $arOpenTag[] = "dbtype=\"$this->_attr_dbtype\" ";
        
        $arOpenTag[] = ">\n";        
        return implode("",$arOpenTag);
    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    public function set_maxlength($value){$this->_maxlength = $value;}
    public function set_rows($iValue){$this->_rows=$iValue;}
    public function set_cols($iValue){$this->_cols=$iValue;}
    public function set_counterspan($isOn=TRUE){$this->isCounterSpan = $isOn;}
    public function set_counterjs($isOn=TRUE){$this->isCounterJs = $isOn;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_maxlength(){return $this->_maxlength;}
    public function readonly($isReadOnly=TRUE){$this->_isReadOnly = $isReadOnly;}

}//Textarea
