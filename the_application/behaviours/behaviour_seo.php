<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name BehaviourSeo
 * @file behaviour_seo.php 
 * @version 1.0.0
 * @date 29-04-20170426 08:41 (SPAIN)
 * @observations:
 * @requires
 */
namespace TheApplication\Behaviours;

class BehaviourSeo
{
    private $sReqUrl;
    private $arData = [];
    private $arReplace = [];
    
    public function __construct()
    {
        $this->sReqUrl = $_SERVER["REQUEST_URI"];
        $this->load_data();
    }//__construct
    
    private function load_data()
    {
        $arData = [
            ["url"=>"","title"=>"","description"=>"","keywords"=>"","h1"=>"","resume"=>""],
            ["url"=>"","title"=>"","description"=>"","keywords"=>"","h1"=>"","resume"=>""],
        ];
        $this->arData = $arData;
    }
    
    private function get_equal()
    {
        foreach($this->arData as $arUrl)
            if($arUrl["url"]== $this->sReqUrl)
                return $arUrl;
        return [];
    }
    
    /**
     * Inidica si se busca en la url de llamada o en la url configurada
     * intercambia strstr
     * 
     * @param int $isInv 0:busca en configuracion,1:busca en la url de llamada
     * @return type
     */
    private function get_like($isInv=0)
    {
        foreach($this->arData as $arUrl)
        {
            if($isInv)
            {
                if(strstr($this->sReqUrl,$arUrl["url"]))
                    return $arUrl;
            }
            else
                if(strstr($arUrl["url"],$this->sReqUrl))
                    return $arUrl;
        }
        return [];
    }
    
    private function replace(&$arUrl)
    {
        foreach($arUrl as $k=>$sValue)
        {
            foreach($this->arReplace as $sTag=>$sRep)
                $sValue = str_replace($sTag,$sRep,$sValue);

            $arUrl[$k] = $sValue;
        }        
    }//replace
    
    private function find_url()
    {
        $arUrl = $this->get_equal();
        if(!$arUrl)
        {
            $arUrlInConf = $this->get_like();
            $arUrlInReq = $this->get_like(1);
            //si se ha encontrado una url configurada
            //y se ha encontrado una configurada en la de peticion
            if(strlen($arUrlInConf["url"])>strlen($arUrlInReq["url"]))
                return $arUrlInConf;
            return $arUrlInReq;
        }
        return $arUrl;
    }    
    
    public function get_data()
    {
        $arUrl = $this->find_url();
        if($arUrl)
            $this->replace($arUrl);
        return $arUrl;
    }
    
    public function add_replace($sTag,$sVal){$this->arReplace["%%$sTag%%"] = $sVal;}
    
}//BehaviourSeo
