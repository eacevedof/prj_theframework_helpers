<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentHelpers 
 * @file component_helpers.php 1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace TheApplication\Components;

class ComponentHelpers 
{
    private $sPathViews;
    
    public function __construct() 
    {
        $this->sPathViews = TFW_PATH_APPLICATIONDS."views/helpers/";        
    }

    public function add_exists($arHelpers)
    {
        foreach($arHelpers as $i=>$arHelper)
        {
            $arHelpers[$i]["has_example"] = 0;
            $sPath = $this->sPathViews.$arHelper["view"];
            if(is_file($sPath))
            {
                $arHelpers[$i]["has_example"] = 1;
            }
        }
        return $arHelpers;
    }//add_exists
    
}//ComponentHelpers