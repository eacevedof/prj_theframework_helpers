<?php
/**
* @author Eduardo Acevedo Farje.
* @link www.eduardoaf.com
* @version 1.0.0
* @name ComponentRouter 
* @file component_router.php
* @date 07-10-2017 11:23 (SPAIN)
* @observations: 
* @requires:
*/
namespace TheApplication\Components;

class ComponentRouter
{

    private static $sReqUri;
    private static $iReqParts;
    private static $arReqParts;
    
    private static $arMessages = [];
    private static $arUrls = [];
    public static $arRun = [];

    public function __construct()
    {
        ;
    }

    public static function add($sUrl="/",$sController="Homes",$sMethod="index")
    {
        $sNSClass = "\TheApplication\Controllers\\Controller$sController";
        self::$arUrls[]=["url"=>$sUrl,"controller"=>$sController,"nscontroller"=>$sNSClass,"method"=>$sMethod];
    }
   
    private static function check_exact()
    {
        //bug(self::$arUrls,self::$sReqUri);die;
        foreach(self::$arUrls as $arUrl)
        {
            if($arUrl["url"]==self::$sReqUri)
            {
                self::$arRun = $arUrl;
                return self::$arRun;
            }
        }
        return [];        
    }
    
    private static function check_pattern()
    {
        $sReqUri = self::$sReqUri;
        $arUrls = self::$arUrls;
        $iReqParts = self::$iReqParts;
        $arReqUri = self::$arReqParts;
        
        //bug($arReqUri,"arReqUri: $sReqUri");
        
        $arExploded = [];
        foreach($arUrls as $i=>$arUrl)
            $arExploded[$i] = explode("/",$arUrl["url"]);
        
        //bug($arExploded);
        foreach($arExploded as $iUrl=>$arPattParts)
        {
            //tienen los mismos trozos
            if(count($arPattParts)==$iReqParts)
            {
                //pr("count ok");
                $isOk = TRUE;
                $arGet = [];
                foreach($arPattParts as $iPart=>$sPattPart)
                {
                    //pr($arReqUri[$iPart],"$iPart: $sPattPart");
                    if(strstr($sPattPart,":"))
                    {
                        $arGet[$sPattPart] = $arReqUri[$iPart];
                        $isOk = (TRUE && $isOk);
                    }
                    else
                    {
                        $isOk = ($isOk && ($arReqUri[$iPart]==$sPattPart));
                    }
                }//foreach($arUrlParts)
                
                //bug($isOk,"isok");
                if($isOk)
                {
                    foreach($arGet as $sK=>$sValue)
                    {
                        $sK = str_replace(":","",$sK);
                        $_GET[$sK] = $sValue;
                    }
                    return self::$arUrls[$iUrl];
                }
            }//if(count)
        }//foreach($arExploded)
        
        return [];
    }//check_pattern
    
    public static function run()
    {
        self::add();
        self::$sReqUri = $_SERVER["REQUEST_URI"];
        self::$arReqParts = explode("/",self::$sReqUri);
        self::$iReqParts = count(self::$arReqParts);
        $_GET["REQUEST_URI"]["uri"] = self::$sReqUri;
        $_GET["REQUEST_URI"]["parts"] = self::$arReqParts;
        
        if(self::check_exact())
            return self::check_exact();
        else
            return self::check_pattern();
        
        return [];
    }
   
}//ComponentRouter