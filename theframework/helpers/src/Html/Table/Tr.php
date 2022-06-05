<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.2
 * @name TheFramework\Helpers\Html\Table\Tr
 * @date 25-06-2014 09:25 ESP
 * @file Tr.php
 * @requires
 */
namespace TheFramework\Helpers\Html\Table;
use TheFramework\Helpers\AbsHelper;
class Tr extends AbsHelper
{
    protected $isRowHead = false;
    protected $isRowFoot = false;
    protected $iColSpan = null;
    protected $iRowSpan = null;
    protected $iNumCols = 0;
    
    protected $sAttrRownumber;
    
    public function __construct
    ($arinnerhelperss=[], $id="", $class="", $style="", $colspan=""
            , $rowpan="", $extras=[])
    {
        $this->type = "tr";
        $this->innerhtml = "";
        $this->idprefix = "tr";
        $this->id = $id;
        
        //$this->innerhtml = $innertext;
        $this->arinnerhelpers = $arinnerhelperss;
        $this->iNumCols = count($this->arinnerhelpers);
        $this->iColSpan = $colspan;
        $this->iRowSpan = $rowpan;
        if($class) $this->arclasses[] = $class;
        if($style) $this->arStyles[] = $style;
        $this->extras = $extras;
    }

    public function get_html()
    {
        $arHtml[] = $this->get_opentag();
        //$this->innerhtml .= $this->get_tds_as_string();
        $this->_load_inner_objects();
        if($this->innerhtml) $arHtml[] = $this->innerhtml;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }
    
    public function get_opentag() 
    {
         //tr
        $arHtml[] = "<$this->type";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
        if($this->iRowSpan) $arHtml[] = " rowspan=\"$this->iRowSpan\"";
        //eventos
        if($this->_js_onblur) $arHtml[] = " onblur=\"$this->_js_onblur\"";
        if($this->_js_onchange) $arHtml[] = " onchange=\"$this->_js_onchange\"";
        if($this->_js_onclick) $arHtml[] = " onclick=\"$this->_js_onclick\"";
        if($this->_js_onon_keypress) $arHtml[] = " onon_keypress=\"$this->_js_onon_keypress\"";
        if($this->_js_onfocus) $arHtml[] = " onfocus=\"$this->_js_onfocus\"";
        if($this->_js_onmouseover) $arHtml[] = " onmouseover=\"$this->_js_onmouseover\"";
        if($this->_js_onmouseout) $arHtml[] = " onmouseout=\"$this->_js_onmouseout\""; 
        
        //aspecto
        $this->_load_cssclass();
        if($this->class) $arHtml[] = " class=\"$this->class\"";
        $this->_load_style();
        if($this->style) $arHtml[] = " style=\"$this->style\"";
        //atributos extras
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";  
        if($this->sAttrRownumber!=="") $arHtml[] = " rownumber=\"$this->sAttrRownumber\"";  
        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }//get_opentag
    
    public function get_closetag(){ return parent::get_closetag();}
        
    //==================================
    //             SETS
    //==================================
    public function set_colspan($value){$this->iColSpan = $value;}
    public function set_objtds($arinnerhelpers=[]){$this->arinnerhelpers = $arinnerhelpers;$this->iNumCols = count($this->arinnerhelpers);}
    public function set_as_rowhead($isOn=true){$this->isRowHead = $isOn;}
    public function set_as_rowfoot($isOn=true){$this->isRowFoot = $isOn;}
    public function set_attr_rownumber($value){$this->sAttrRownumber = $value;}
    public function add_inner_object($mxValue){$this->arinnerhelpers[] = $mxValue; $this->iNumCols = count($this->arinnerhelpers);}
    public function add_td(Td $oTd){$this->arinnerhelpers[] = $oTd; $this->iNumCols = count($this->arinnerhelpers);}

    //==================================
    //             GETS
    //==================================
    public function get_colspan(){return $this->iColSpan;}
    public function get_objtds(){return $this->arinnerhelpers;}
    public function is_rowhead(){return $this->isRowHead;}
    public function is_rowfoot(){return $this->isRowFoot;}
    public function get_num_columns(){return $this->iNumCols;}
    
}//Tr