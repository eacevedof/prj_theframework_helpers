<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentPagedata
 * @file component_pagedata.php 
 * @version 2.0.0
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
        $this->load_helpers_data();
        $this->init();
    }//__construct

    private function load_params()
    {
        $this->arParams["classname"] = $this->get_get("example");
        if($this->get_get("content")) 
            $this->arParams["classname"] = $this->get_get("content");
        //bug($this->arParams,"arParams");
    }//load_params

    private function load_helpers_data()
    {
        $arHelpers = $this->arHelpers;
        //bug($arHelpers);
        $arHelpLower = [];
        array_walk($arHelpers,function($sValue,$sKey) use(&$arHelpLower){
            $sKeyLow = strtolower($sKey);
            $arHelpLower[$sKeyLow] = ["classname"=>$sKey,"filename"=>$sValue];
        });
        $this->arHelpers = $arHelpLower;
        //bug($this->arHelpers,"arHelpers");
    }//load_helpers_data

    private function get_example_view($sClassParam)
    {
        $sFilename = $this->arHelpers[$sClassParam]["filename"];
        $sFilename = str_replace("helper_","view_",$sFilename);
        $sFilename = str_replace("theframework_helper","view_theframework",$sFilename);
        $sFilename .= ".php";
        $sFilename = "helpers/$sFilename";
        if(!stream_resolve_include_path($sFilename))
            $sFilename = "helpers/view_notyet.php";
        return $sFilename;
    }//get_example_view

    public function get_request_uri($sType=0)
    {
        $sReqUri = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
        //sin get
        if($sType==1)
        {
            if(strstr($sReqUri,"?"))
            {
                $sReqUri = explode("?",$sReqUri);
                $sReqUri=$sReqUri[0];
            }
            remove_firstchar($sReqUri);
            remove_lastchar($sReqUri);            
        }        
        elseif($sType==2)
        {
            remove_firstchar($sReqUri);
            remove_lastchar($sReqUri);
        }
        return $sReqUri;
    }//get_request_uri
   
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
        $this->arPage = $oBehSeo->get_data();
        $this->arScrumbs = $oBehSeo->get_scrumbs();
        
        $sParamClass = $this->arParams["classname"];//devuelve algo como helperanchor
        if($sParamClass)
        {
            $sClassName = $this->arHelpers[$sParamClass]["classname"];
            $oBehSeo->add_replace("classnamelower",$sParamClass);
            $oBehSeo->add_replace("classname",$sClassName);
            $this->arPage = $oBehSeo->get_data();
            $this->arScrumbs = $oBehSeo->get_scrumbs();
            $this->arView["params"]["classname"] = $sClassName;
            $this->arView["filename"] = $this->get_example_view($sParamClass);
            if($this->get_get("content"))
            {
                $this->arView["filename"] = "view_content.php";
                $this->arView["params"]["filecontent"] = $this->arHelpers[$sParamClass]["filename"].".php";
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
