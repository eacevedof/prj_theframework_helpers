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

    public function get_closetag(){return "\n</{$this->_tag}>";}//get_closetag

    public function get_html()
    {  
        $arHtml[] = $this->get_opentag();
        $this->load_inner_objects("\n");
        $arHtml[] = $this->_inner_html;
        $arHtml[] = $this->get_closetag();
        return implode("",$arHtml);
    }//get_html
    
    public function get_htmlsrc()
    {
        //pr($this->arSrc);die;
        $arHtml = [];
        foreach($this->arSrc as $mxSrc)
        {
            $arTmp = [];       
            if($this->_type) 
                $arTmp[] = "type=\"{$this->_type}\"";
                
            if(is_string($mxSrc))
            {
                $arTmp[] = "src=\"$mxSrc\"";
                $arHtml[] = "<script ".implode(" ",$arTmp)."></script>";
            }
            elseif(is_array($mxSrc))
            {
                foreach($mxSrc as $k=>$v)
                    $arTmp[] = "$k=\"$v\"";
                $arHtml[] = "<script ".implode(" ",$arTmp)."></script>";
            }
        }//foreach arSrc
        return implode("\n",$arHtml);
        
    }//get_htmlsrc
    
    private function move($sFrom,$sTo,$sMode)
    {
        //bug("$sFrom,$sTo,$sMode","move");die;
        switch($sMode) 
        {
            //solo copia si no existe
            case "c":
                if(is_file($sFrom) && !is_file($sTo))
                {
                    //pr("copying...");
                    copy($sFrom,$sTo);
                }
            break;

            //rescribe siempre
            case "rw":
                if(is_file($sFrom) && is_file($sTo))
                {
                    unlink($sTo);
                    copy($sFrom,$sTo);
                }
            break;
        
            default:
            break;
        }//switch(mode)
    }//move
    
    public function move_topublic()
    {
        foreach($this->arPublic as $arPublic)
        {
            //pr($arPublic,"arPublic");
            $sFrom = $arPublic["from"];
            $sTo = $arPublic["to"];
            $sMode = $arPublic["mode"];
            $this->move($sFrom,$sTo,$sMode);
        }
    }//move_topublic
    
    //**********************************
    //             SETS
    //**********************************
    public function set_src($arSrc=[]){$this->arSrc = $arSrc;}    
    public function add_src($sSrc){$this->arSrc[] = $sSrc;}
    public function add_srcext($sSrc,$arExtra=[]){$this->arSrc[] = array_merge(["src"=>$sSrc],$arExtra);}
    public function add_public($sPathFrom,$sPathTo,$sMode="c")
    {
        //pr("pathfrom:$sPathFrom,pathto:$sPathTo");
        if($sPathFrom && $sPathTo)
            $this->arPublic[] = ["from"=>$sPathFrom, "to"=>$sPathTo, "mode"=>$sMode];
    }//add_public
    
    //**********************************
    //             GETS
    //**********************************
    

    //**********************************
    //           MAKE PUBLIC
    //**********************************
    public function show_opentag(){echo $this->get_opentag();}
    public function show_closetag(){echo $this->get_closetag();}
    public function show_htmlsrc(){echo $this->get_htmlsrc();}
    
}//Script