<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentPagedata
 * @file component_pagedata.php 
 * @version 2.0.1
 * @date 23-06-2017 20:41 (SPAIN)
 * @observations:
 * @requires
 */
namespace TheApplication\Components;

use TheApplication\Components\ComponentDownload;
use TheApplication\Behaviours\BehaviourSeo;

class ComponentPagedata
{
    private $arParams;
    private $arPage;
    private $arHelpers;
    private $arView;
    private $arScrumbs;

    public function __construct($arHelpers=[])
    {
        //bugg();
        $this->arHelpers = $arHelpers;
        //$this->arScrumbs = $arScrumbs;
        $this->arView = ["filename"=>"view_list.php","params"=>[]];
        //$this->arPage = $arSEO;
        $this->load_params();
        $this->init();
    }//__construct

    private function load_params()
    {
        $this->arParams["uri_parts"] = $this->get_get("REQUEST_URI");
        $this->arParams["helper-slug"] = $this->get_get("helper-slug");
        $this->arParams["uri_parts"] = $this->arParams["uri_parts"]["parts"];
    }//load_params

    private function get_example_view($sSlug)
    {
        foreach($this->arHelpers as $arHelper)
            if($arHelper["slug"]===$sSlug)
            {
               $sFileView = $arHelper["view"];
               break;
            }
        
        $sFileView = "helpers/$sFileView";
        if(!stream_resolve_include_path($sFileView))
            $sFileView = "helpers/view_notyet.php";
        return $sFileView;
    }//get_example_view
   
    public function is_inrequesturi($mxSearch)
    {
        $sReqUri = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
        if(is_array($mxSearch))
        {
            foreach($mxSearch as $sSearch)
            {
                if(strstr($sReqUri,$sSearch))
                    return true;
            }
            return false;
        }
        else
        {
            return strstr($sReqUri,$mxSearch);
        }
    }//is_inrequesturi
   
    private function init()
    {
        //pr("init");       
        $oBehSeo = new BehaviourSeo();
        //$this->arPage = $oBehSeo->get_data();
        $this->arScrumbs = $oBehSeo->get_scrumbs();
        
        $sHelperSlug = $this->arParams["helper-slug"];//devuelve algo como helperanchor

        //pr($sHelperSlug,"helper-slug");die;
        if($sHelperSlug)
        {
            foreach($this->arHelpers as $arHelper)
                if($arHelper["slug"]===$sHelperSlug)
                {
                    $sClassName = $arHelper["classname"];
                    break;
                }
            
            //bug($sClassName,"className");
            $oBehSeo->add_replace("slug",$sHelperSlug);
            $oBehSeo->add_replace("classname",$sClassName);            
            $this->arPage = $oBehSeo->get_data();
            //pr($this->arPage);die;
            $this->arScrumbs = $oBehSeo->get_scrumbs();
            $this->arView["params"]["classname"] = $sClassName;
            $this->arView["filename"] = $this->get_example_view($sHelperSlug);
            
            //parche: Si no viene la palabra example entonces se busca el contenido de la clase
            //y no los ejemplos
            if(!in_array("examples",$this->arParams["uri_parts"]))
            {
                $this->arView["filename"] = "view_content.php";
                $this->arView["params"]["filecontent"] = $arHelper["filename"];
            }
        }
        elseif($this->get_get("download"))
        {
            $sVersion = $this->get_get("download");
            if($sVersion)
            {
                $oDownload = new ComponentDownload($this);
                $oDownload->returnfile($sVersion);
            }
        }
        elseif($this->get_get("view"))
        {
            $sView = $this->get_get("view");
            //bug($sView);die;
            $this->arView["filename"] = "view_{$sView}.php";
        }
    }//init()
    
    private function add_scrumb($sUrl,$sDescription){$this->arScrumbs[] = ["url"=>$sUrl,"description"=>$sDescription];}
    
    public function show_content()
    {
        $sFilename = $this->get_view_var("filecontent");
        //pr($sFilename,"filename get_contents");
        if($sFilename)
        {
            $sContent = file_get_contents($sFilename,1);
            $sContent = htmlentities($sContent);
            echo $sContent;
        }
    }//show_content

    public function get_post($sKey){return (isset($_POST[$sKey])?$_POST[$sKey]:NULL);}
    public function get_get($sKey){return (isset($_GET[$sKey])?$_GET[$sKey]:NULL);}
    public function get_page($sKey){return $this->arPage[$sKey];}
    public function get_view_file(){return $this->arView["filename"];}
    public function get_view_var($sKey){return (isset($this->arView["params"][$sKey])?$this->arView["params"][$sKey]:NULL);}
    public function get_scrumbs(){return $this->arScrumbs;}
    
}//ComponentPagedata
