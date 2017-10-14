<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.3.1
 * @name AppBootstrap
 * @file app_bootstrap.php 
 * @date 19-06-2017 08:41 (SPAIN)
 * @observations: Includes
 *  load:4
 * @requires
 */
namespace ThePulic;

class AppBootstrap
{
    private $sRootPathDS;
    private $arPaths;
    private $arHelpers;
    
    public function __construct()
    {
        $this->sRootPathDS = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $this->arPaths = [];
        $this->arHelpers = [];
    }//__construct

    private function add_paths()
    {
        $this->arPaths[] = "{$this->sRootPathDS}../helpers";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/behaviours";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/components";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/controllers";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/elements";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/functions";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/models";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/views";
        $this->arPaths[] = "{$this->sRootPathDS}../the_application/views/helpers";
    }//add_paths

    private function as_included()
    {
        $arExists = explode(PATH_SEPARATOR,get_include_path());
        $arExists = array_merge($arExists,$this->arPaths);
        $arExists = array_unique($arExists);
        //self::pr($arExists);
        set_include_path(implode(PATH_SEPARATOR,$arExists));        
    }

    public function load_paths()
    {
        $this->add_paths();
        $this->as_included();
        //self::pr($this->sRootPathDS);
    }

    public static function pr($var="",$sTitle=NULL)
    {
        if($sTitle)
            $sTitle=" $sTitle: ";

        if(!is_string($var))
            $var = var_export($var,TRUE);
        #F1E087
        $sTagPre = "<pre function=\"AppBootstrap.pr\" style=\"border:1px solid black;background:#cc0066; padding:0px; color:#fff; font-size:12px;\">\n";
        $sTagFinPre = "</pre>\n";    
        echo $sTagPre.$sTitle.$var.$sTagFinPre;
    }//function pr

    public function load_files()
    {
        $arFiles = [
            "functions_debug.php" //helpers/functions_debug
            ,"functions_string.php"
            ,"autoload.php" //helpers/autoload.php
            ,"array_helpers.php"
            ,"component_download.php"
        ];
        
        foreach($arFiles as $sFileName)
            include_once($sFileName);
        
        if(isset($arHelpers)) $this->arHelpers = $arHelpers;
    }//load_files
    
    public function autoload()
    {
        spl_autoload_register(function($sNSClassName)
        {
            $arPieces = explode("\\",$sNSClassName);
            $sClassName = end($arPieces);
            $sFileName = camel_to_sep($sClassName).".php";
            if(stream_resolve_include_path($sFileName))
                include_once($sFileName);
        });//spl_autoload_register
    }
    
    public function load_file($sFileName){include_once($sFileName);}
    public function get_helpers_list(){return $this->arHelpers;}
}//AppBootstrap