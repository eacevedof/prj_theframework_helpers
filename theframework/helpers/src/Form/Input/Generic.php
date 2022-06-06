<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.6
 * @name TheFramework\Helpers\Form\Input\Generic
 * @date 04-12-2018 17:56 (SPAIN)
 * @file Generic.php
 */
namespace TheFramework\Helpers\Form\Input;
use TheFramework\Helpers\AbsHelper;

class Generic extends AbsHelper
{
    public function __construct($value,$extras=[])
    {
        $this->value = $value;
        $this->extras = $extras;
    }

    public function get_html()
    {  
        $arHtml = [];
        if($this->comment) $arHtml[] = "<!-- $this->comment -->\n";
        $arHtml[] = "<input";
        if($this->value || $this->value=="0") 
            $arHtml[] = " value=\"{$this->get_cleaned($this->value)}\"";
        if($this->extras) $arHtml[] = " ".$this->get_extras();

        $arHtml[] = ">\n";
        return implode("",$arHtml);
    }//get_html
    
    //**********************************
    //             TO HIDE
    //**********************************
    //private function get_closetag(){;}     
    //private function get_opentag(){;}

    //**********************************
    //             SETS
    //**********************************
    public function value($value,$asEntity=0){($asEntity)?$this->value = htmlentities($value):$this->value=$value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function getvalue($asEntity=0){if($asEntity) return htmlentities($this->value); else return $this->value;}
}//HelperGeneric