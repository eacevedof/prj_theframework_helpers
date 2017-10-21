<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentLog 
 * @file component_log.php 1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheApplication\Components;

class ComponentLog 
{
    private $sPathFolder;
    private $sSubfType;
    private $sFileName;
    
    public function __construct($sSubfType="",$sPathFolder="") 
    {
        $this->sSubfType = $sSubfType;        
        $this->sPathFolder = $sPathFolder;        
        $this->sFileName = "app_".date("Ymd").".log";
        if(!$sPathFolder)$this->sPathFolder = TFW_PATH_PROJECTDS."logs";
        if(!$sSubfType) $this->sSubfType = "debug";
    }
    
    private function merge($sContent,$sTitle)
    {
        $sReturn = "::".date("Ymd-His")."::\n";
        if($sTitle) $sReturn .= $sTitle.":\n";
        if($sContent) $sReturn .= $sContent."\n";
        return $sReturn;
    }
    
    public function write($sContent,$sTitle=NULL)
    {
        $sPathFile = $this->sPathFolder."/$this->sSubfType/$this->sFileName";
        //soruce file
        //x: Creación y apertura para sónlo escritura; coloca el puntero al principio del archivo.
        $oCursor = fopen($sPathFile,"x");
        //bug($this->_target_content,"content");
        if($oCursor !== FALSE)
        {
            $sToSave = $this->merge($sContent,$sTitle);
            fwrite($oCursor,""); //Grabo el caracter vacio
            if(!empty($sToSave)) fwrite($oCursor,$sToSave);
            fclose($oCursor); //cierro el archivo.
        }
        else
        {
            return FALSE;
        }
        return TRUE;        
    }  

    public function set_filename($sValue){$this->sFileName="$sValue.log";}
    public function set_subfolder($sValue){$this->sSubfType="$sValue";}
    
}//ComponentLog