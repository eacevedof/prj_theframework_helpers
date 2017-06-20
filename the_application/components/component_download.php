<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name ComponentDownload
 * @file component_download.php 
 * @date 29-04-20170426 08:41 (SPAIN)
 * @observations:
 * @requires
 */
namespace TheApplication\Components;

use TheApplication\Controllers\ControllerAppMain;

class ComponentDownload
{
    private $sPathRoot;
    private $oAppMain;
    private $sPathJson;
    
    public function __construct(ControllerAppMain $oAppMain)
    {
        $this->sPathRoot = $_SERVER["DOCUMENT_ROOT"];
        $this->sPathJson = $this->sPathRoot."/download/counter.json";
        $this->oAppMain = $oAppMain;
    }//__construct
    
    public function update_count($sVersion)
    {
        $arVersions = $this->get_versions();
        //bug($arVersions,"arVersions");
        if(isset($arVersions["version"][$sVersion]["counter"]))
        {
            $arVersions["version"][$sVersion]["counter"]++;
            $arVersions["version"][$sVersion]["updated"] = date("Y-m-d H:i:s");
            $sJson = json_encode($arVersions);
            file_put_contents($this->sPathJson,$sJson);
        }
        else
        {
            pr("no version found $sVersion");
        }
    }//update_count
    
    public function get_versions($isLatest=0)
    {
        $sJson = file_get_contents($this->sPathJson);
        $arVersions = json_decode($sJson,1);
        if($isLatest)
        {
            $arVersions = $arVersions["version"];
            krsort($arVersions,SORT_NUMERIC);
            reset($arVersions);//se mueve al primer elemento
        }
        return $arVersions;
    }
    
    private function get_parsed($sUrlVersion)
    {
        $sVersion = str_replace("-",".",$sUrlVersion);
        $sVersion = str_replace("v.","",$sVersion);
        return $sVersion;
    }//get_parsed
    
    public function returnfile($sFileName)
    {
        $sVersion = $this->get_parsed($sFileName);
        $sPathFilezip = $this->sPathRoot."/download/helpers_{$sVersion}.zip";
        if(is_file($sPathFilezip))
        {
            $this->update_count($sVersion);
            ignore_user_abort(true);
            set_time_limit(0); // disable the time limit for this script
            header("Content-type: application/zip"); 
            header("Content-Disposition: attachment; filename=helpers_{$sVersion}.zip"); 
            header("Pragma: no-cache"); 
            header("Expires: 0"); 
            readfile($sPathFilezip);
            exit;
        }
        else
            pr(" :( file not found!");
    }//download
    
}//ComponentDownload
