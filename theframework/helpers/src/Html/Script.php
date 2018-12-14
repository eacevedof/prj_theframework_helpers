<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 2.0.0
 * @name TheFramework\Helpers\Html\Script
 * @file Script.php
 * @date 14-12-2018 10:46 (SPAIN)
 * @observations core library
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\TheFrameworkHelper;

class Script extends TheFrameworkHelper
{ 
    private $_tag;
    protected $arSrc = [];
    
    //js que se moverán a la carpeta pública
    protected $arPublic = [];

    public function __construct($sType="")
    {
        $this->_idprefix = "";
        $this->_tag = "script";
        $this->_type = $sType;
    }
 
    public function get_opentag() 
    {
        $arOpenTag[] = "<$this->_tag";
        if($this->_id) $arOpenTag[] = " id=\"$this->_idprefix$this->_id\"";           
        if($this->arExtras) $arOpenTag[] = " ".$this->get_extras();
        $arOpenTag[] = ">\n";
        return implode("",$arOpenTag);
    }//get_opentag


    public function get_closetag(){return "</{$this->_tag}>";}//get_closetag

    public function get_html()
    {  
        $arHtml[] = $this->get_opentag();
        $this->load_inner_objects();
        $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);

    }//get_html
    

    //**********************************
    //             SETS
    //**********************************

 
    //**********************************
    //             GETS
    //**********************************
   

    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){echo $this->get_opentag();}
    public function show_closetag(){echo $this->get_closetag();}
 
}//Script