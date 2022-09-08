<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name TheApplication\Components\ComponentLog 
 * @file ComponentLog.php 1.2.0
 * @date 30-11-2017 19:26 SPAIN
 * @observations
 */
namespace TheFramework\Components;

class ComponentLog 
{
    const DS = DIRECTORY_SEPARATOR;
    
    private $sPathFolder;
    private $sSubfType;
    private $sFileName;
        
    public function __construct($sSubfType="",$sPathFolder="") 
    {
        $this->sPathFolder = $sPathFolder; 
        $this->sSubfType = $sSubfType;        
        $this->sFileName = "app_".date("Ymd").".log";
        if(!$sPathFolder) $this->sPathFolder = __DIR__;
        if(!$sSubfType) $this->sSubfType = "debug";
        //intenta crear la carpeta de logs
        $this->fix_folder();
    }
    
    private function fix_folder()
    {
        $sLogFolder = $this->sPathFolder.self::DS
                        .$this->sSubfType.self::DS;
        if(!is_dir($sLogFolder)) @mkdir($sLogFolder);
    }
    
    private function merge($sContent,$sTitle)
    {
        $ip = $_SERVER["REMOTE_ADDR"] ?? "127.0.0.1";
        $sReturn = "-- [".date("Ymd-His")." ip:$ip]\n";
        if($sTitle) $sReturn .= $sTitle.":\n";
        if($sContent) $sReturn .= $sContent."\n\n";
        return $sReturn;
    }
    
    public function save($mxVar,$sTitle=NULL)
    {
        if(!is_string($mxVar)) 
            $mxVar = var_export($mxVar,1);
        
        $sPathFile = $this->sPathFolder.self::DS
                        .$this->sSubfType.self::DS
                        .$this->sFileName;
        
        if(is_file($sPathFile))
            $oCursor = fopen($sPathFile,"a");
        else
            $oCursor = fopen($sPathFile,"x");

        if($oCursor !== false)
        {
            $sToSave = $this->merge($mxVar,$sTitle);
            fwrite($oCursor,""); //Grabo el caracter vacio
            if(!empty($sToSave)) fwrite($oCursor,$sToSave);
            fclose($oCursor); //cierro el archivo.
        }
        else
        {
            return false;
        }
        return true;        
    }//save

    public function set_filename($sValue){$this->sFileName="$sValue.log";}
    public function set_subfolder($sValue){$this->sSubfType="$sValue";}
    
}//ComponentLog