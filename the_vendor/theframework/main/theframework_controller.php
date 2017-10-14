<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Main\TheFrameworkController
 * @file theframework_controller.php
 * @version 1.0.0
 * @date 08-10-2017 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Main;

use TheFramework\Main\TheFramework;

class TheFrameworkController extends TheFramework
{ 
    /**
     * @var ComponentPermission
     */
    protected $oPermission;
    protected $sModuleGroup;
    //Name in table base_module
    protected $sModuleName;

    protected $arFilters = array();
    //Que se realizará despues de CREATE, UPDATE, DELETE
    protected $arAfterSuccessCUD; 
    protected $sCurrentOperation;

    protected $iItemsPerPage;
    protected $sTrLabelPrefix;
    
    /**
     * @var TheApplicationView 
     */
    protected $oView;
    
    public function __construct()
    {
        //clientbrowser,isMobileDevice,isconsolecalled,ispermalink
        parent::__construct();
        $this->arAfterSuccessCUD["insert"] = "insert";
        $this->arAfterSuccessCUD["update"] = "update";
        $this->arAfterSuccessCUD["quarantine"] = "get_list";
        $this->arAfterSuccessCUD["delete"] = "get_list";
        $this->sCurrentOperation = $this->get_get("tfw_view");
        $this->iItemsPerPage = 45;
    }
    
    /**CUD: CREATE: insert, UPDATE: update, quarantine DELETE: delete
     * Utiliza $this->sCurrentOperation = $this->get_get("tfw_view");
     * Utiliza variables $this->sCurrentOperation["operation"]="view_to_go";
     * @param array|string in csv $mxGetParamExclude Params not to use in redirection
     */
    protected function goto_after_successcud($mxGetParamExclude=NULL)
    {
        //TODO Falta hacerlo compatible con mvc
        if(is_string($mxGetParamExclude)) 
            $mxGetParamExclude = explode(",",$mxGetParamExclude);
        
        if($mxGetParamExclude==NULL) 
            $mxGetParamExclude = array();
        
        $arExclude = array("tfw_package","tfw_controller","tfw_partial","tfw_method");
        $arExclude = array_merge($arExclude,$mxGetParamExclude);
        //bug($arExclude);DIE;
        $arParams = array();
       
        $sGoView = $this->arAfterSuccessCUD[$this->sCurrentOperation];
        if($this->isPermaLink)
        {
            foreach($_GET as $sKey=>$sValue)
                if(!in_array($sKey,$arExclude))
                    $arParams[$sKey] = $sValue;
            //bugg();
            $arParams["tfw_view"] = $sGoView;
            
            //si se ha borrado y se ha configurado ir al detalle se cambia para ir al listado
            if($this->get_get("tfw_view")=="delete" && $sGoView=="update")
                $arParams["tfw_view"] = "get_list";

            //si se va a ir al listado o al formulario de inserción se quita el parametro id
            if($arParams["tfw_view"]=="get_list" || $arParams["tfw_view"]=="insert")
                unset($arParams["id"]);

            $sUrl = "/".implode("/",$arParams)."/";
            //bug($arParams,"arParams: $sUrl");die;
        }
        else 
        {
            foreach($_GET as $sKey=>$sValue)
                if(!in_array($sKey,$arExclude))
                    $arParams[$sKey] = "$sKey=$sValue";

            $arParams["tfw_view"] = "tfw_view=$sGoView";

            if($this->get_get("tfw_view")=="delete" && $sGoView=="update")
                $arParams["tfw_view"] = "tfw_view=get_list";

            if($arParams["tfw_view"]=="tfw_view=get_list" || $arParams["view"]=="tfw_view=insert")
                unset($arParams["id"]);

            $sUrl = "?".implode("&",$arParams);
        }
        //bug($sUrl,"url"); die;
        $this->go_to_url($sUrl);
    }//goto_after_successcud

    public function load_pagetitle()
    {
        //bugpg();
        $sMethod = $this->get_get("tfw_method");
        $sPageTitle = $this->get_trlabel("entities");        
        
        switch($sMethod)
        {
            case "get_list":
                $sPageTitle .= " - ";
                $sPageTitle .= $this->get_trlabel("tr_main_title_list",0);
            break;
        
            case "insert":
                $sPageTitle .= " - ";
                $sPageTitle .= $this->get_trlabel("tr_main_title_insert",0);                
            break;
        
            case "update":
                $sPageTitle .= " - ";
                $sPageTitle .= $this->get_trlabel("tr_main_title_update",0);                
            break;
        
            default:             
            break;
        }
        $this->oView->set_page_title($sPageTitle);
    }
    
    protected function save_newsession()
    {
        //pr(ComponentGlobal::$arSecurity,"save_newsession ".get_class($this));
        if(!ComponentGlobal::$arSecurity["newsession"])
        {
            //bug("savesession ran");
            ComponentGlobal::$arSecurity["newsession"] = 1;
            $oModelSess = new ModelSecuritySession();
            $oModelSess->set_remote_ip($this->get_remote_ip());
            $oModelSess->set_sessionid(session_id());
            $oModelSess->set_insert_platform(3);
            if($this->isMobileDevice)
                $oModelSess->set_insert_platform(4);
            $oModelSess->insert_newonly();
        }
    }//save_newsession
    
    protected function check_remoteip()
    {
        //pr(ComponentGlobal::$arSecurity,"check_remoteip ".get_class($this));
        if(!ComponentGlobal::$arSecurity["remoteip"])
        {
            //bug("savesession ran");
            ComponentGlobal::$arSecurity["remoteip"] = 1;
            if($this->is_ip_blocked())
            {
                pr("Whoops! Sorry but for some reason your ip {$this->get_remote_ip()} is blocked. Please contact the site admin: tfwdevelop@gmail.com for more information.");
                exit();
            }
        }
    }//check_remoteip
    
    protected function is_ip_blocked($sIp="")
    {
        if(!$sIp)
            $sIp = $this->get_remote_ip();
        $oSecIp = new ModelSecurityIp();
        return $oSecIp->is_ip_blocked($sIp);
    }//is_ip_banned
    
    //**********************************
    //             SETS
    //**********************************
    protected function reset_filter(){$this->arFilters=array();}
    
    protected function set_filter($sFieldName,$sControlId=NULL,$arSearchConfig=NULL)
    {
        $arTemp = array();
        if($sControlId) $arTemp["controlid"] = $sControlId;
        if($arSearchConfig) $arTemp["searchconfig"] = $arSearchConfig;
        $this->arFilters[$sFieldName] = $arTemp;
    }
    
    protected function set_filter_value($sFieldName,$sFieldValue)
    {
        $this->arFilters[$sFieldName]["searchconfig"]["value"] = $sFieldValue;
    }
    
    protected function remove_filter($sFieldName){unset($this->arFilters[$sFieldName]);}
    
    /**
     * @param string $value el prefijo de traduccion <tr_mod_>
     */
    protected function set_trlabel_prefix($value){$this->sTrLabelPrefix = $value;}

    protected function set_after_successcud($sType,$goView){$this->arAfterSuccessCUD[$sType]=$goView;}
    
    protected function set_file_content($sContent,$sPathFile)
    {
        $oCursor = fopen($sPathFile,"x");
        //bug($this->_target_content,"content");
        if($oCursor !== false)
        {
            fwrite($oCursor,""); //Grabo el caracter vacio
            if(!empty($sContent)) 
                fwrite($oCursor,$sContent);
            fclose($oCursor); //cierro el archivo.
            return true;
        }
        else 
        {    
            $sMessage = "set_file_content: File: $sPathFile not a file";
            $this->add_error($sMessage);
        }
        return false;
    }    
    //**********************************
    //             GETS
    //********************************** 
    protected function get_filter_fieldnames(){return array_keys($this->arFilters);}
    protected function get_filter_controls_id()
    {
        $arIds = array();
        foreach($this->arFilters as $arFilter)
        {
            if(isset($arFilter["controlid"]) && $arFilter["controlid"])
                $arIds[] = $arFilter["controlid"];
        }
        return $arIds;
    }
    
    /**
     * Transforma un array de configuracion de formato de campo en otro 
     * array que es entendido por el modelo para aplicar filtros
     * @param array $arFormats array(fieldname=>format) 
     * @param array $arMapping array(fieldname=>fieldnamereplace) Para remplazo 
     * @return array i=>array(fieldname=>array(operator=>op,value=>val))
     */
    protected function get_filter_searchconfig($arFormats=array())
    {
        //bug($this->arFilters);
        $arSearchConfig = array();
        foreach($this->arFilters as $sFieldName => $arFilter)
        {
            //bug($arFilter);
            if(isset($arFilter["searchconfig"]))
            {    
                if($arFormats)
                {
                    $sValue = $arFilter["searchconfig"]["value"];
                    $arFilter["searchconfig"]["value"] = $this->format_value($arFormats,$sFieldName,$sValue);
                }
                $arSearchConfig[$sFieldName] = $arFilter["searchconfig"];
            }
        }
        //bug($arSearchConfig);die; 
        //return array tipo: (fieldname=>array(operator=>op,value=>val))
        return $arSearchConfig;        
    }
    
    protected function get_trlabel($sName,$usePrefix=TRUE)
    {
        $sTrLabel = $sName;
        if($usePrefix)
            $sTrLabel = $this->sTrLabelPrefix.$sName;
        
        $sTrLabel = get_tr($sTrLabel);
        //$sTrLabel = utf8_decode($sTrLabel);
        return $sTrLabel;
    }    
    
    protected function get_file_content($sPathFile)
    { 
        if(is_file($sPathFile))
        { 
            $oReader = fopen($sPathFile,"r");
            $iFileSize = filesize($sPathFile);
            //pr($iFileSize);
            $sContent = fread($oReader,$iFileSize);
            fclose($oReader);
        }
        else 
        {    
            $sMessage = "get_file_content: File: $sPathFile not a file";
            $this->add_error($sMessage);
        }
        return $sContent;
    }      
    //**********************************
    // OVERRIDE TO PUBLIC IF NECESSARY
    //**********************************
    /**
     * using str_repalce search arkey and replaces it with arvalue
     * @param array $arReplace array("search1"=>"newval1","search2"=>"newval2"...)
     * @param string $sToChange by reference changed.
     */
    protected function replace($arReplace,&$sToChange)
    {
        foreach($arReplace as $sSearch=>$sNewValue)
            $sToChange = str_replace($sSearch,$sNewValue,$sToChange);
    }//replace
    
}//TheFrameworkController
