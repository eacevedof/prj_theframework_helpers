<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Models\TheApplicationModel
 * @file model_theapplication.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Models;

use TheFramework\Main\TheFrameworkModel;

class TheApplicationModel extends TheFrameworkModel
{
    protected $arData;
    protected $sPath;
    
    public function __construct()
    {

    }

    public function load()
    {
        $this->arData = $this->json_read($this->sPath);
    }
    
    public function update($arDataNew=[])
    {
        $this->json_write($arDataNew,$this->sPath);
    }   

    public function delete(){}
    
    public function insert(){}
        
    protected function json_write($arData,$sPath)
    {
        $sJson = json_encode($arData);
        file_put_contents($sPath,$sJson);
    }//json_write
    
    protected function json_read($sPath=NULL)
    {
        if($sPath)
        {
            $sContent = file_get_contents($sPath);
            $arJson = json_decode($sContent,TRUE);
            return $arJson;
        }
        return [];
    }//json_read  
    
    public function get_by_props($sFieldname,$sValue)
    {
        $arTmp = [];
        foreach($this->arData as $i=>$arRow)
            if(isset($arRow[$sFieldname]) && $arRow[$sFieldname]==$sValue)
                $arTmp[$i] = $arRow;
        return $arTmp;
    }//get_by_props    
    
    public function get_data(){return $this->arData;}
    
}//TheApplicationModel