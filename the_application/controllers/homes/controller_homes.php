<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Controllers\ControllerHomes
 * @file controller_homes.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Controllers;

use TheApplication\Controllers\TheApplicationController;
use TheApplication\Components\ComponentPagedata;
use TheApplication\Components\ComponentDownload;
use TheApplication\Models\ModelHelper;

class ControllerHomes extends TheApplicationController
{
    private $arHelpers;
    private $oPageData;
    
    public function __construct()
    {
        $oModelHelper = new ModelHelper();
        $oModelHelper->load();
        $this->arHelpers = $oModelHelper->get_by_props("is_enabled","1");
        //bugpg();
        $oPagedata = new ComponentPagedata($this->arHelpers);
        $this->oPageData = $oPagedata;
        $sView = $this->oPageData->get_view_file();
        if(in_string("404.php",$sView))
        {
            $this->status_404();
            exit();
        }
    }
    
    //
    public function index()
    {
        $arHelpers = $this->arHelpers;
        $oPagedata = $this->oPageData;
        include("homes/view_index.php");
    }
    
    //versions
    public function versions()
    {
        $this->set_get("view","versions");
        $arHelpers = $this->arHelpers;
        $oPagedata = new ComponentPagedata($arHelpers);
        $oDownload = new ComponentDownload($oPagedata);
        $arVersions = $oDownload->get_versions();
        $arVersions = $arVersions["version"];
        krsort($arVersions);        
        include("homes/view_index.php");
        //include("homes/view_versions.php");
    }
    
    //helper:/examples
    public function examples()
    {
        $arHelpers = $this->arHelpers;
        $oPagedata = $this->oPageData;
        include("homes/view_index.php");        
    }
    
    //content:/
    public function code()
    {
        //bug("code");
        $oPagedata = $this->oPageData;        
        include("homes/view_index.php");          
    }    
    
    //download/version:/
    public function download()
    {
        
    }    
    
}//ControllerHomes