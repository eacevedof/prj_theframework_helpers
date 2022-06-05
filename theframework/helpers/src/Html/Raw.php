<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.1
 * @name TheFramework\Helpers\Html\Raw
 * @date 06-12-2016 14:38
 * @file Raw.php
 * @requires
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\AbsHelper;
class Raw extends AbsHelper
{
    
    public function __construct($sRawHtml="")
    {
        $this->innerhtml = $sRawHtml;
    }
    
    //Raw
    public function get_html()
    {  
        //Agrega a inner_html los valores obtenidos con get_html
        $arHtml = [];
        $this->_load_inner_objects();
        $arHtml[] = $this->innerhtml;
        return implode("",$arHtml);
    }
    
    //Escondo este metodo
    public function set_rawhtml($sRawHtml,$asEntity=0){parent::innerhtml($sRawHtml,$asEntity);}
    
    //**********************************
    //             SETS
    //**********************************
    
    //**********************************
    //             GETS
    //**********************************
    
    //**********************************
    //           MAKE PUBLIC
    //**********************************
}