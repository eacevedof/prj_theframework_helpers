<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name BehaviourSeo
 * @file behaviour_seo.php 
 * @version 1.2.0
 * @date 29-04-20170426 08:41 (SPAIN)
 * @observations:
 * @requires
 */
namespace TheApplication\Behaviours;

class BehaviourSeo
{
    private $sReqUrl;
    private $arData = [];
    private $arScrumbs = [];
    private $arReplace = [];
    private $arUrlFound = [];
    private $arScrumbFound = [];
    
    public function __construct()
    {
        $this->sReqUrl = $_SERVER["REQUEST_URI"];
        pr($this->sReqUrl);
        $this->load_data();
        $this->load_scrumbs();
    }//__construct
    
    private function load_data()
    {
        $arData = [
            ["url"=>"/"
                ,"title"=>"The Framework PHP Helpers Library"
                ,"description"=>"Open source php view helpers library. Classes that help you to render html elements using OOP"
                ,"keywords"=>"PHP helpers oop classes html"
                ,"h1"=>"<a href=\"/\">The Framework</a> PHP helpers Library",
                "resume"=>"
                This PHP library tries to simplify the way of creating html elements in any php project.
                You are able to apply any html attribute by its methods.
                <br/>
                <code>
                    Eg. \$oObject->set_{html property}(value)
                </code>
                "
            ],
            
            ["url"=>"/index.php?view=versions"
                ,"title"=>"The Framework PHP Helpers library Versions"
                ,"description"=>"The Framework PHP Helpers library Versions"
                ,"keywords"=>"PHP helpers oop classes html versions"
                ,"h1"=>"<a href=\"/\">The Framework</a> PHP helpers Library Versions",
                "resume"=>""
             ],
        ];
        $this->arData = $arData;
    }
    
    private function load_scrumbs()
    {
        $arScrumbs = [
            ["url"=>"/"
                ,"scrumbs"=>[
                    ["href"=>"/","text"=>"Start"]
                ]
            ],
            ["url"=>"/index.php?view=versions"
                ,"scrumbs"=>[
                    ["href"=>"/","text"=>"Start"],
                    ["href"=>"/index.php?view=versions","text"=>"Versiones"]
                ]                
            ],
        ];
        $this->arScrumbs = $arScrumbs;
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
            if(!$arUrl["url"])continue;
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
            
            $iConf = 0; $iReq = 0;
            if(isset($arUrlInConf["url"])) $iConf = $arUrlInConf["url"];
            if(isset($arUrlInReq["url"])) $iReq = $arUrlInReq["url"];
            //si se ha encontrado una url configurada
            //y se ha encontrado una configurada en la de peticion
            if($iConf>$iReq)
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
        $this->arUrlFound = $arUrl;
        return $arUrl;
    }
    
    public function get_scrumbs()
    {
        if($this->arUrlFound)
        {
            $sUrl = $this->arUrlFound["url"];
            foreach($this->arScrumbs as $arScrumb)
                if($arScrumb["url"]==$sUrl)
                {
                    $this->arScrumbFound = $arScrumb["scrumb"];
                    return $arScrumb["scrumb"];
                }
        }
        return [];
    }
    
    public function add_replace($sTag,$sVal){$this->arReplace["%%$sTag%%"] = $sVal;}
    public function get_found_url(){return $this->arUrlFound;}
    public function get_found_scrumb(){return $this->arScrumbFound;}
    
}//BehaviourSeo
