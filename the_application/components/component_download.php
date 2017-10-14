<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentDownload
 * @file component_download.php 
 * @version 1.1.0
 * @date 23-06-2017 08:41 (SPAIN)
 * @observations:
 * @requires
 */
namespace TheApplication\Components;

use TheApplication\Components\ComponentPagedata;
use TheApplication\Components\ComponentMailing;

class ComponentDownload
{
    private $sPathRoot;
    private $oAppMain;
    private $sPathJson;
    
    public function __construct(ComponentPagedata $oAppMain)
    {
        $this->sPathRoot = TFW_PATH_PUBLIC;
        //pr($this->sPathRoot);pr(__DIR__);pr(__FILE__);
        $this->sPathJson = $this->sPathRoot."/../the_application/models/counter.json";
        $this->oAppMain = $oAppMain;
    }//__construct
    
    private function send($arContent)
    {
        $oComponentMail = new ComponentMailing();
        $oComponentMail->set_title_from("helpers.theframework.es Donwnload");
        $oComponentMail->set_subject("helpers.theframework.es Donwnload");
        $oComponentMail->set_content($arContent);
        $arEmails[] = "tfwtrack@gmail.com";
        $oComponentMail->set_emails_to($arEmails);
        $oComponentMail->send();
    }
    
    public function update_count($sVersion)
    {
        $arVersions = $this->get_versions();
        //bug($arVersions,"arVersions");
        if(isset($arVersions["version"][$sVersion]["counter"]))
        {
            $arVersions["version"][$sVersion]["counter"]++;
            $arVersions["version"][$sVersion]["updated"] = date("Y-m-d H:i:s");
            $arVersions["version"][$sVersion]["remote_ip"] = $_SERVER["REMOTE_ADDR"];
            $sJson = json_encode($arVersions);
            file_put_contents($this->sPathJson,$sJson);
            $this->send($sJson);
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
            //bug($arVersions);
            //krsort($arVersions,SORT_NUMERIC); no lo hace bien
            krsort($arVersions);
            //bug($arVersions,"despues de sort");
            reset($arVersions);//se mueve al primer elemento
        }
        return $arVersions;
    }//get_versions
    
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
