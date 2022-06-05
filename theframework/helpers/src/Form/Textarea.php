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
namespace TheFramework\Helpers\Form;
use TheFramework\Helpers\AbsHelper;
use TheFramework\Helpers\Form\Label;

class Textarea extends AbsHelper
{ 
    private $_cols;
    private $_rows;
    private $isCounterSpan;
    private $isCounterJs;
    
    public function __construct
    ($id="",$name="",$innerhtml="",$extras=[],$maxlength=-1
    ,$cols=40,$rows=8,$class="",$style="",Label $oLabel=null)
    {
        $this->type = "textarea";

        $this->idprefix = "";
        $this->id = $id;
        $this->innerhtml = $innerhtml;
        $this->name = $name;
        $this->_cols = $cols;
        $this->_rows = $rows;

        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
       
        $this->maxlength = $maxlength;
        $this->extras = $extras;
        $this->oLabel = $oLabel;
        
        $this->isCounterSpan = false;
        $this->isCounterJs = false;        
    }//__construct
    
    private function js_counter()
    {
        //pr("js_counter.in");
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
        $arHtml = [];
        if($this->oLabel) $arHtml[] = $this->oLabel->get_html();
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        //Una longitud de 0 tiene un comportamiento parecido a un bloqueado
        if($this->maxlength>-1 && $this->isCounterJs && $this->isCounterSpan) 
            $this->_jsonkeyup .= " return fn_txamaxlength(this,event);";              
        $arHtml[] = $this->get_opentag();
        $arHtml[] = htmlentities($this->innerhtml);
        $arHtml[] = $this->get_closetag();

        //addon contador
        if($this->isCounterSpan)
        {
            $arHtml[] = "\n<span id=\"sp$this->idprefix$this->id\"></span>"; 
            //se imprime el js que gestiona el contador (si se desea)
            if($this->isCounterJs) 
            {              
                //bug("js_counter");die;
                $this->js_counter();
            }
        }

        return implode("",$arHtml);
    }//get_html
    
    public function get_opentag()
    {
        $arOpenTag[] = "<$this->type ";
        if($this->id) $arOpenTag[] = "id=\"$this->idprefix$this->id\" ";
        if($this->name) $arOpenTag[] = "name=\"$this->idprefix$this->name\" ";
        if($this->_rows) $arOpenTag[] = "rows=\"$this->_rows\" ";
        if($this->_cols) $arOpenTag[] = "cols=\"$this->_cols\" ";
        //propiedades html5
        if($this->disabled) $arOpenTag[] = "disabled ";
        if($this->readonly) $arOpenTag[] = "readonly "; 
        if($this->_isRequired) $arOpenTag[] = "required "; 
        //eventos
        if($this->_js_onfocus) $arOpenTag[] = "onfocus=\"$this->_js_onfocus\" ";
        if($this->_js_onblur) $arOpenTag[] = "onblur=\"$this->_js_onblur\" ";
        if($this->jsonchange) $arOpenTag[] = "onchange=\"$this->jsonchange\" ";
        if($this->_js_onclick) $arOpenTag[] = "onclick=\"$this->_js_onclick\" ";
        if($this->jsonkeypress) $arOpenTag[] = "onon_keypress=\"$this->jsonkeypress\" ";        
        if($this->jsonkeydown) $arOpenTag[] = "onkeydown=\"$this->jsonkeydown\" ";
        if($this->_jsonkeyup) $arOpenTag[] = "onkeyup=\"$this->_jsonkeyup\" ";
        if($this->_js_onmouseover) $arOpenTag[] = "onmouseover=\"$this->_js_onmouseover\" ";
        if($this->_js_onmouseout) $arOpenTag[] = "onmouseout=\"$this->_js_onmouseout\" ";

        //aspecto
        $this->_load_cssclass();
        if($this->class) $arOpenTag[] = "class=\"$this->class\" ";
        $this->_load_style();
        if($this->style) $arOpenTag[] = "style=\"$this->style\" ";
        //atributos extras
        if($this->maxlength) $arOpenTag[] = "maxlength=\"$this->maxlength\" ";
        if($this->extras) $arOpenTag[] = " ".$this->get_extras();
        if($this->_isPrimaryKey) $arOpenTag[] = "pk=\"pk\" ";
        if($this->_attr_dbtype) $arOpenTag[] = "dbtype=\"$this->_attr_dbtype\" ";
        
        $arOpenTag[] = ">\n";        
        return implode("",$arOpenTag);
    }//get_opentag
    
    //**********************************
    //             SETS
    //**********************************
    public function setmaxlength($value){$this->maxlength = $value;}
    public function set_rows($iValue){$this->_rows=$iValue;}
    public function set_cols($iValue){$this->_cols=$iValue;}
    public function set_counterspan($isOn=true){$this->isCounterSpan = $isOn;}
    public function set_counterjs($isOn=true){$this->isCounterJs = $isOn;}
    
    //**********************************
    //             GETS
    //**********************************
    public function getmaxlength(){return $this->maxlength;}
    public function readonly($readonly=true){$this->readonly = $readonly;}

}//Textarea
