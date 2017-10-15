<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Models\ModelHelper
 * @file model_helper.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Models;

use TheApplication\Models\TheApplicationModel;

class ModelHelper extends TheApplicationModel
{

    public function __construct($arData=[])
    {
        $this->arData = $arData;
        $this->sPath = TFW_PATH_APPLICATIONDS."models/json/helper.json";
    }

    public function get_keyname()
    {
        $arData = [];
        foreach($this->arData as $arEmp)
            $arData[$arEmp["id"]] = $arEmp["classname"];
        asort($arData);
        return $arData;
    }

}//ModelHelper