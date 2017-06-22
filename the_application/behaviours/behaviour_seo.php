<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name BehaviourSeo
 * @file behaviour_seo.php 
 * @version 1.3.1
 * @date 22-06-2017 20:41 (SPAIN)
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
        //filter_input(INPUT_SERVER,"SERVER_NAME",FILTER_SANITIZE_STRING)
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
            ["url"=>"/index.php?view=%%classname%%"
                ,"scrumbs"=>[
                    ["href"=>"/","text"=>"Start"],
                    ["href"=>"/index.php?view=%%classname%%","text"=>"%%class%%"]
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
    
    /**
     * Busca solo en los valores y los remplaza
     * Ejemplo: ["url"=>"some-text-with-%%tag%%","another-text-and-%%tag2%%"]
     * @param array $arValues
     */
    private function replace(&$arValues)
    {
        foreach($arValues as $k=>$sValue)
        {
            foreach($this->arReplace as $sTag=>$sRep)
                $sValue = str_replace($sTag,$sRep,$sValue);

            $arValues[$k] = $sValue;
        }        
    }//replace
    
    private function replace_seo()
    {
        $arDataSEO = $this->arData;
        //urls seo configuradas
        foreach($arDataSEO as $i=>$arSEO)
        {
            $this->replace($arSEO);
            $arDataSEO[$i] = $arSEO;
        }
        $this->arData = $arDataSEO;
    }//replace_seo
    
    private function replace_scrumbs()
    {
        $arScrumbsCfg = $this->arScrumbs;
        foreach($arScrumbsCfg as $i=>$arConfig)
        {
            $arScrumbs = $arConfig["scrumbs"];
            foreach($arScrumbs as $j=>$arScrumb)
            {
                $this->replace($arScrumb);
                $arScrumbs[$j] = $arScrumb;
            }
            $arScrumbsCfg[$i]["scrumbs"] = $arScrumbs;
        }
        $this->arScrumbs = $arScrumbsCfg;
    }//replace_scrumbs
    
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
        $this->replace_seo();
        $arUrl = $this->find_url();
        if($arUrl)
            $this->arUrlFound = $arUrl;
        return $this->arUrlFound;
    }
    
    public function get_scrumbs()
    {
        $this->replace_scrumbs();
        if($this->arUrlFound)
        {
            $sUrl = $this->arUrlFound["url"];
            foreach($this->arScrumbs as $arScrumb)
                if($arScrumb["url"]==$sUrl)
                {
                    $this->arScrumbFound = $arScrumb["scrumbs"];
                    return $this->arScrumbFound;
                }
        }
        return [];
    }
    
    public function add_replace($sTag,$sVal){$this->arReplace["%%$sTag%%"] = $sVal;}
    public function get_found_url(){return $this->arUrlFound;}
    public function get_found_scrumb(){return $this->arScrumbFound;}
    
}//BehaviourSeo
