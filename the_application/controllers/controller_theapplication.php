<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Controllers\TheApplicationController
 * @file controller_theapplication.php 
 * @version 1.1.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Controllers;

use TheFramework\Main\TheFrameworkController;
use TheApplication\Components\ComponentLog;

class TheApplicationController extends TheFrameworkController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function log_visit($sResult)
    {
        //bugpg();
        $oLog = new ComponentLog();
        $oLog->set_subfolder("session");
        $oLog->set_filename("app_visit_".date("Ymd"));
        $oLog->save("uri: {$_SERVER["REQUEST_URI"]}, result: $sResult","session_id: ".session_id());
    }
    
    protected function log_debug($sContent,$sTitle="")
    {
        if(!is_string($sContent)) 
            $sContent = var_export($sContent,1);
        $this->oLog->set_subfolder("debug");
        $this->oLog->save($sContent,$sTitle);
    }
    
    protected function log_error($sContent,$sTitle="")
    {
        if(!is_string($sContent))
            $sContent = var_export($sContent,1);
        $this->oLog->set_subfolder("error");
        $this->oLog->save($sContent,$sTitle);
    }
    
    protected function log_custom($sContent,$sTitle="")
    {
        if(!is_string($sContent))
            $sContent = var_export($sContent,1);
        $this->oLog->set_subfolder("custom");
        $this->oLog->save($sContent,$sTitle);
    }    
    
    public function status_404()
    {
        header("HTTP/1.0 404 Not Found");
        include("views/status/404.php");
    }
}//TheApplicationController