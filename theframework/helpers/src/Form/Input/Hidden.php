<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name TheFramework\Helpers\Form\Input\Hidden
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Hidden.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\AbsHelper;

class Hidden extends AbsHelper
{
    //private $name = "hidname";

    public function __construct($id="",$name="",$value="",$extras=[])
    {
        $this->type = "hidden";
        $this->idprefix = "";
        $this->id = $id;
        $this->value = $value;
        $this->name = $name;
        $this->extras = $extras;
    }

    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = "<input";
        if($this->type) $arHtml[] = " type=\"$this->type\"";
        if($this->id) $arHtml[] = " id=\"$this->idprefix$this->id\"";
        if($this->name) $arHtml[] = " name=\"$this->idprefix$this->name\"";
        if($this->value || $this->value=="0") 
            $arHtml[] = " value=\"{$this->_get_escaped_quot($this->value)}\"";
        //propiedades html5
        if($this->maxlength)$arHtml[] = " maxlength=\"$this->maxlength\"";
        //atributos extras pe. para usar el quryselector
        if($this->_attr_dbfield) $arHtml[] = " dbfield=\"$this->_attr_dbfield\"";
        if($this->_attr_dbtype) $arHtml[] = " dbtype=\"$this->_attr_dbtype\"";        
        if($this->_isPrimaryKey) $arHtml[] = " pk=\"pk\"";
        if($this->extras) $arHtml[] = " ".$this->get_extras();
        
        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }
    
    //**********************************
    //             TO HIDE
    //**********************************
    //private function get_closetag(){;}     
    //private function get_opentag(){;}

    //**********************************
    //             SETS
    //**********************************
    public function name($value){$this->name = $value;}
    public function value($value,$asEntity=0){($asEntity)?$this->value = htmlentities($value):$this->value=$value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_name(){return $this->name;}
    public function get_value($asEntity=0){if($asEntity) return htmlentities($this->value); else return $this->value;}
}//HelperHidden