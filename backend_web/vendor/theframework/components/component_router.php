<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name TheApplication\Components\ComponentRouter 
 * @file ComponentRouter.php 1.0.0
 * @date 30-07-2022 08:19 SPAIN
 * @observations
 */
namespace TheFramework\Components;

final class ComponentRouter
{   
    private string $requesturi;
    private string $pathroutes;
    private array $arroutes;
    private array $arrequest;
    private array $arArgs;

    private static array $routes;

    public function __construct(array $arroutes=[], string $pathroutes="") 
    {
        $this->requesturi = $_SERVER["REQUEST_URI"];
        $this->pathroutes = $pathroutes;
        $this->arroutes = $arroutes;
        self::$routes = $arroutes;

        $this->arrequest = [
            "url" => "",
            "url_pieces" => [],
            "get_params" => []
        ];
        $this->_load_routes();
        $this->_load_pieces();
    }
    
    private function _load_routes(): void
    {
        if($this->arroutes || !$this->pathroutes)
            return;
        $this->arroutes = include($this->pathroutes);
        self::$routes = $this->arroutes;
    }

    private function _load_pieces(): void
    {
        $arGet = $this->_get_get_params($this->requesturi);
        $arUrlsep = $this->_get_url_pieces($this->requesturi);
        $this->arrequest["url"] = "/".implode("/",$arUrlsep);
        $this->arrequest["url_pieces"] = $arUrlsep;
        $this->arrequest["get_params"] = $arGet;
    }

    private function _search_exact(): array
    {
        $requri = $this->arrequest["url"];
        $routes = array_filter($this->arroutes, function ($route) use ($requri) {
            return $route["url"] === $requri;
        });
        return reset($routes) ?: [];
    }

    private function _search_by_pieces(): array
    {
        $isFound = false;
        foreach($this->arroutes as $i=>$arRoute)
        {
            $sUrl = $arRoute["url"];
            $arroutesep = $this->_get_url_pieces($sUrl, true);
            $this->arArgs = [];
            //compare pieces comprueba todo, tammaño y tags
            $isFound = $this->_compare_pieces_and_load_args($this->arrequest["url_pieces"], $arroutesep);
            if($isFound)
                break;
        }
        
        if($isFound)
            $this->_add_to_get($this->arrequest["url_pieces"], $arroutesep);

        $r = array_merge(
            $this->arroutes[$i],
            $this->arArgs ? ["_args" => $this->arArgs] : []
        );
        return $r;
    }
    
    public function get_rundata(): array
    {
        return $this->_search_exact() ?: $this->_search_by_pieces();
    }

    private function _is_nullable(array $route): bool
    {
        $null = array_filter(
            array_values($route),
            function ($string) {
                return (strstr($string, "?:") || strstr($string, "?int:"));
            }
        );
        return (bool) count($null);
    }

    private function _is_probable(array $request, array $route): bool
    {
        if (($ireq = count($request))===($iroute = count($route)))
            return true;

        //esto no está del todo fino ya que no se permitiria varios ?: como partes de la ruta
        if($this->_is_nullable($route) && $ireq===($iroute-1))
            return true;

        return false;
    }

    private function _compare_pieces_and_load_args(array $arrequest,array $arRoute): bool
    {
        //true si casan todas las partes y de paso carga los args
        if(!$this->_is_probable($arrequest, $arRoute))
            return false;
        
        foreach($arRoute as $i=>$sPiece) {
            if ($this->_is_tag($sPiece)) {
                $tag = $this->_get_taginfo($sPiece);
                $value = $arrequest[$i] ?? null;
                if(!$this->_match_type($value, $tag["types"]))
                    return false;

                $this->arArgs[$tag["key"]] = trim(urldecode($value));
                continue;
            }
            $sReqval = $arrequest[$i];
            if($sReqval != $sPiece)
                return false;
        }
        return true;
    }
    
    private function _add_to_get(array $arrequest,array $arRoute): void
    {
        foreach($arRoute as $i=>$sPiece)
        {
            if(!$this->_is_tag($sPiece))
                continue;
            $tag = $this->_get_taginfo($sPiece);
            $_GET[$tag["key"]] = $arrequest[$i] ?? "";
        }
    }
    
    private function _is_tag(string $sPiece): bool
    {
        return (
            (strstr($sPiece,"{") && strstr($sPiece,"}")) ||
            strstr($sPiece,":") ||
            strstr($sPiece,"?:")
        );
    }

    private function _match_type($mxvalue, array $types):bool
    {
        foreach ($types as $type) {
            if($type==="int" && is_numeric($mxvalue)) return true;
            if($type==="string" && is_string($mxvalue)) return true;
            if($type==="null" && $mxvalue===null) return true;
        }
        return false;
    }

    private function _get_taginfo(string $sPiece): array
    {
        //restrict/users/:page
        //restrict/users/int:page
        //restrict/users/?:page
        //restrict/users/?int:page

        $parts = explode(":",$sPiece);
        $r = [
            "types" => ["string"],
            "key" => $parts[1]
        ];
        $before = $parts[0];
        switch ($before)
        {
            case "": return $r;
            case "?":
                $r["types"][] = "null";
            break;
            case "?int":
                $r["types"] = ["null","int"];
            break;
            case "int":
                $r["types"] = ["int"];
        }
        return $r;
    }
    
    private function _explode_and(string $sAndstring): array
    {
        $arRet = [];
        $arTmp = explode("&",$sAndstring);
        foreach($arTmp as $sEq)
        {
            $arParamVal = explode("=",$sEq);
            $arRet[$arParamVal[0]] = isset($arParamVal[1])?$arParamVal[1]:"";
        }
        return $arRet;
    }
    
    private function _get_get_params($sUrl): array
    {
        $arTmp = explode("?",$sUrl);
        if(!isset($arTmp[1])) return [];
        $arParams = $this->_explode_and($arTmp[1]);
        return $arParams;
    }
    
    private function _unset_empties(&$arrequest): void
    {
        $arNew = [];
        foreach($arrequest as $i=>$sValue)
            if($sValue)
                $arNew[] = $sValue;
        
        $arrequest = $arNew;
    }
    
    private function _get_url_pieces(string $sUrl, bool $haspattern=false): array
    {
        if (!$haspattern) {
            $arTmp = explode("?",$sUrl);
            if(isset($arTmp[1])) $sUrl = $arTmp[0];
        }

        $arrequest = explode("/",$sUrl);
        //pr($arrequest);
        $this->_unset_empties($arrequest);
        return $arrequest;
    }    

    public static function get_url(string $name, array $args=[]): string
    {
        $route = array_filter(self::$routes, function (array $route) use ($name) {
            if (!$alias = ($route["name"] ?? "")) return false;
            return trim($alias) === $name;
        });
        if (!$route) return "";
        $route = array_values($route);
        $url = $route[0]["url"];
        if (!$args) return $url;
        $tags = array_keys($args);
        $tags = array_map(function (string $tag){
            return str_starts_with($tag, ":") ? $tag : ":$tag";
        }, $tags);

        $values = array_values($args);
        return str_replace($tags, $values, $url);
    }

}