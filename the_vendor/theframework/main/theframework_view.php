<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.7.0
 * @name TheFrameworkView
 * @file theframework_view.php 
 * @date 29-12-2016 23:29 (SPAIN)
 * @observations: The Framework Main View
 *  load:23
 */
/*Cache-Control	no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Content-Length	18363
Content-Type	text/html
Date	Sat, 27 Apr 2013 11:20:27 GMT
Expires	Thu, 19 Nov 1981 08:52:00 GMT
Pragma	no-cache
Server	Microsoft-IIS/5.1
Set-Cookie	PHPSESSID=p9duf0d3a5otaf65tmhvd3l8n7; path=/
X-Powered-By	ASP.NET, PHP/5.2.17*/
class TheFrameworkView extends TheFramework
{
    protected $sThemeFolder;
    protected $sThemeFolderDs;
    protected $sLayout;
    protected $sViewFolder;
    protected $sViewFileName;
    protected $arVars = array();
    protected $arJs;
    protected $arJsExclude;
    protected $isJsRewrite;
    protected $sPathView = ""; //ruta de la plantilla que se cargara
    //protected $sPathLanguage = "english";
    
    protected $showLeftcolumn = TRUE;
    protected $sBodyClass = "";
    protected $isPage404 = FALSE;
    protected $isPage401 = FALSE;
    protected $isPopup = FALSE;//indica si la vista se esta mostrando en popup. Necesario para mostrar botones de retorno
    protected $sPathPage404;
    protected $sPathPage401;
    protected $sPathLayout;
    protected $sPathLayoutDs;
    
    protected $sWarningMessage; //NO SE HAN ENCONTRADO RESULTADOS    
    protected $isUnset = TRUE;
    protected $isJustView = FALSE;//indica si se utilizará solo la vista sin el layout

    protected $hideElementTopForm = TRUE;
    
    protected $sController;
    protected $sPartial;
    protected $sMethod;
    
    protected $sUrlReferer;
    protected $sUriModule;
    protected $sUriMvc;
    
    protected $sPageTitle;
    protected $sPageDescription;
    protected $sPageKeywords;
    
    public function __construct()
    {
        //inicia sesion, carga dispositivo,si es de consola, si se usa permalink
        parent::__construct();
        $this->arJs[0] = array();//Framework js
        $this->arJs[1] = array();//Application js
        $this->arJsExclude[0] = [];
        $this->arJsExclude[1] = [];
        $this->sController = $_GET["tfw_controller"]; //module
        if(isset($_GET["tfw_partial"])) $this->sPartial = $_GET["tfw_partial"]; //tab
        $this->sMethod = $_GET["tfw_method"]; //view
        if(isset($_SERVER["HTTP_REFERER"])) $_SESSION["viewreferer"] = $_SERVER["HTTP_REFERER"];
        //bug($this->get_last_url_referer(),"last url referer");
        //uriModule,uriMvc
        //bug($this->sPathView);bugg();die;
        $this->load_uris();       
    }
  
    public function add_var(&$mxVar,$sVarName){$this->arVars[$sVarName]=$mxVar;if($this->isUnset)unset($mxVar);}
    
    private function show_enviroment_div()
    {
        $sHtmlDiv = "";
        if(TFW_DEBUG_ISON)
        {
            switch(TFW_ENVIROMENT)
            {
                case "local"://cyan
                    $sHtmlDiv = "<div tip=\"view.show_enviroment_div\" style=\"margin:0;padding:0;height:4px;width:100%;background-color:#35FFFF;position:fixed;z-index:999;\">"
                                .TFW_ENVIROMENT
                                ."</div>";
                break;
                case "development"://magenta
                    $sHtmlDiv = "<div tip=\"view.show_enviroment_div\" style=\"margin:0;padding:0;height:4px;width:100%;background-color:#FF00FF;position:fixed;z-index:999;\">"
                                .TFW_ENVIROMENT
                                ."</div>";
                break;      
                case "preproduction"://green
                    $sHtmlDiv = "<div tip=\"view.show_enviroment_div\" style=\"margin:0;padding:0;height:4px;width:100%;background-color:#5EFE38;position:fixed;z-index:999;\">"
                                .TFW_ENVIROMENT
                                ."</div>";
                break;        
            }
        }
        echo $sHtmlDiv;
    }//show_enviroment_div()
    
    public function show_page()
    {     
        //bug($this->is_page401());die;
        //bug($this->sPathView);die;
        //$sPathLayoutPage = $this->sThemeFolder.TFW_DS
        //        .$this->sLayout.TFW_DS
        //        ."page.php";
        header("Access-Control-Allow-Origin: *");
        //header("Access-Control-Allow-Headers","Origin,X-Requested-With,Content-Type,Accept");
        $this->show_enviroment_div();
        $sPathLayoutPage = $this->sPathLayoutDs."page.php";
        if($this->isJustView) $sPathLayoutPage = $this->sPathView;
        //cargar variables
        //bug($sPathLayoutPage,"spath_layout_page");die;//huraga\layout_onecolumn\page.php
        foreach($this->arVars as $mxKey => $valor)
            ${$mxKey}=$valor;
        //bugfileipath($sPathLayoutPage);
        include_once($sPathLayoutPage);
        if(isset($this->oSessionUser) && is_object($this->oSessionUser))
            echo "<!-- usr:{$this->oSessionUser->get_id()} -->";
        //bugif();die;
    }//show_page

    public function build_html_table($arTable=array(),$arHeaders=array(),$sTableId="table")
    {
        $sHtmlTable = "";
 
        $sHtmlTable .= "<table id=\"$sTableId\" class=\"table table-striped table-bordered table-condensed\">\n";
        $sHtmlTable .= "<thead>";
        if(!empty($arHeaders))
        {
            $sHtmlTable .= "<tr>\n";
            foreach($arHeaders as $sHeaderName)
                $sHtmlTable .= "<th>$sHeaderName</th>";
            $sHtmlTable .= "</tr>\n";
        }
        $sHtmlTable .= "</thead>";

        $sHtmlTable .= "<tbody>";
        foreach($arTable as $iRow=>$arRow)
        {
            //$sTdStyle = self::get_style_td_background($iRow);
            $sHtmlTable .= "<tr>\n";
            //$sHtmlTable .= "<td class=\"$sTdStyle\">$iRow</td>\n";
            foreach($arRow as $iFieldName => $sFieldValue)
                $sHtmlTable .= "<td>$sFieldValue</td>\n";
            $sHtmlTable .= "</tr>\n";
        }
        $sHtmlTable .= "</tbody>";
        $sHtmlTable .= "</table>\n";
        return $sHtmlTable;
    }//build_html_table

    protected function load_uris()
    {
        $arUriModule = array(); $arUriMvc=array();
        if($this->sController) 
        {
            $arUriModule[] = "module=$this->sController";
            $arUriMvc[] = "controller=$this->sController";
        }
        if($this->sPartial)
        { 
            $arUriModule[] = "tab=$this->sPartial";
            $arUriMvc[] = "partial=$this->sPartial";
        }
        
        if($this->sMethod)
        { 
            $arUriModule[] = "view=$this->sMethod";
            $arUriMvc[] = "method=$this->sMethod";
        }
        if($this->isPermaLink)
        {
            $this->sUriModule=implode("&",$arUriModule);
            $this->sUriMvc=implode("&",$arUriMvc);            
        }
        else
        {
            $this->sUriModule=implode("/",$arUriModule)."/";
            $this->sUriMvc=implode("/",$arUriMvc)."/";
        }
    }//load_uris
    
    protected function is_firstchar_ds($value){return (is_firstchar($value,"/") || is_firstchar($value,"\\"));}
    
    private function get_path_previous($arFolders,$iCurrent)
    {
        $sPathTemp = "";
        for($i=0;$i<$iCurrent;$i++)
            $sPathTemp .= $arFolders[$i].DS;
        return $sPathTemp;
    }//get_path_previous
    
    protected function build_js_folders($sPathFileName,$sPathTarget)
    {
        $sPathFileName = $this->get_fixed_syspath($sPathFileName);
        if(strstr($sPathFileName,DS))
        {
            $arSubFolders = explode(DS,$sPathFileName);
            array_pop($arSubFolders);

            //bug($arSubFolders);
            foreach($arSubFolders as $i=>$sFolder)
            {    
                //recupera las carpetas previas en forma de subruta
                $sPathPrev = $this->get_path_previous($arSubFolders,$i);
                $sPathCheck = $sPathTarget.$sPathPrev.$sFolder; 
                //bug($sPathCheck);
                if(!is_dir($sPathCheck))
                {
                    if(!mkdir($sPathCheck))
                    {
                        $sMessage = "build_js_folder: $sPathCheck no directory created!";
                        $this->add_error($sMessage);
                        $this->add_alert($sMessage);
                    }
                }
            }
         }//if (ds in spathfilename)
    }//build_js_folders

    public function js_load()
    {
        //limpio los posibles repetidos
        $this->arJs[0] = array_unique($this->arJs[0]);
        $this->arJs[1] = array_unique($this->arJs[1]);
        //theframework paths
        $sPathSoruceDs = TFW_PATH_FOLDER_PROJECTDS."the_framework/html/js/";
        $sPathTargetDs = TFW_PATH_FOLDER_PROJECTDS."the_public/js/the_framework/";
        $sPathPublicDs = "/js/the_framework/";
        
        //bug($this->arJs);
        foreach($this->arJs as $isApp=>$arJs)
        {
            if($isApp)
            {
                $sPathSoruceDs = TFW_PATH_FOLDER_PROJECTDS."the_application/views/_js/";
                $sPathTargetDs = TFW_PATH_FOLDER_PROJECTDS."the_public/js/the_application/";
                $sPathPublicDs = "/js/the_application/";
            }
            //pr($arJs,"arjs");
            //bug($isApp,"isapp");
            foreach($arJs as $i=>$sFileName)
            {
                //si se ha añadido para no cargarse se salta al siguiente
                if($this->is_js_excluded($sFileName,$isApp))
                    continue;
                
                //si es un link en nube file://, http://, https://
                if(strstr($sFileName,"://"))
                    echo "<script src=\"$sFileName\" lib=\"TheFrameworkView.js_load $i\" type=\"text/javascript\"></script>\n";
                //archivo js
                else
                {
                    //Si es una libreria del framework se tienen que crear las subcarpetas
                    if(!$isApp)
                        $this->build_js_folders($sFileName,$sPathTargetDs);

                    $sFileNameJs = $sFileName.".js";
                    //bug(realpath($sFileName),"real");
                    $sTmpPathSource = $sPathSoruceDs.$sFileNameJs;
                    $sTmpPathTarget = $sPathTargetDs.$sFileNameJs;
                    //Limpia las barras de directorios
                    $sTmpPathSource = $this->get_fixed_syspath($sTmpPathSource);
                    $sTmpPathTarget = $this->get_fixed_syspath($sTmpPathTarget);
                    //pr($sTmpPathSource,"source"); pr($sTmpPathTarget,"target");
                    //pr(is_file($sTmpPathSource),"isfile($sTmpPathSource)");
                    if(is_file($sTmpPathSource))
                    {
                        //pr(is_file($sTmpPathTarget));
                        if(!is_file($sTmpPathTarget))
                            copy($sTmpPathSource,$sTmpPathTarget);
                        //si ya existe en destino, se elminina y se crea nuevamente
                        elseif($this->isJsRewrite)
                        {
                            unlink($sTmpPathTarget);
                            copy($sTmpPathSource,$sTmpPathTarget);
                        }

                        //else
                            //$sMessage = "TheFrameworkView.js_load(): file already exists $sTmpPathTarget";
                            //$this->add_error($sMessage);
                        //bug($sPathPublic.$sFileNameJs);
                        echo "<script src=\"$sPathPublicDs$sFileNameJs\" lib=\"TheFrameworkView.js_load $i\" type=\"text/javascript\"></script>\n";
                    }
                    else
                    {
                        $sMessage = "TheFrameworkView.js_load(): file not found $sTmpPathSource";
                        //pr($sMessage);
                        $this->add_error($sMessage);
                        //bug($sMessage);die;
                    }                    
                }
                                
            }//foreach $arJsFiles 
        }//foreach $this->arJs 
    }//js_load()
    
    //**********************************
    //             SETS
    //**********************************    
    public function set_session_user($oUser){$this->oSessionUser=$oUser;}
    /**
     * Creates sLayout, sPathLayout y sPathLayoutDs
     * @param string $value Suffix layout folder name
     */
    public function set_layout($value)
    {
        $this->sLayout = "layout_$value";
        $this->sPathLayout = $this->sThemeFolderDs.$this->sLayout;
        $this->sPathLayoutDs = $this->sPathLayout.TFW_DS;
    }//set_layout
    
    public function set_bodyclass($value){$this->sBodyClass = $value;}
    
    private function has_twoparts($value)
    {
        $arParts = explode("/",$value);
        if(!is_array($arParts))
            $arParts = explode("\\",$value);
        if(count($arParts)==2 && $arParts[0]=="")
            return TRUE;
        return FALSE;
    }//has_twoparts
    
    private function build_default_view()
    {
        $arFixedViews = array
        (
            "insert"=>"_base/view_insert"
            ,"update"=>"_base/view_update"
            ,"delete"=>"_base/view_delete"
            ,"quarantine"=>"_base/view_quarantine"
            ,"singleassign"=>"_base/view_assign"
            ,"multiassign"=>"_base/view_assign"
            ,"get_list"=>"_base/view_index"
            ,"pictures"=>"_base/view_pictures"
            ,"error_401"=>"status/401"
            ,"error_403"=>"status/403"
            ,"error_404"=>"status/404"
            ,"error_500"=>"status/500"
            ,"error_503"=>"status/503"
        );
        
        $arKeys = array_keys($arFixedViews);
        
        $sView = $_GET["tfw_view"];
        if(!$sView) 
            $sView = $_GET["function"];
        
        if(in_array($sView,$arKeys))
            return $arFixedViews[$sView];
        else
            return "view_index";
    }//build_default_view
    
    public function set_path_view($value)
    {
        if(!$value)
        {
            //bugpg();
            $sPack = $_GET["tfw_package"];
            $value = $this->build_default_view();
            $value = "$sPack/$value";
        }   
        $this->sPathView = $this->get_fixed_syspath("$value.php");
        //bug($this->sPathView);
        //if(is_file($this->sPathView)) echo "existe";
    }//set_path_view
    
    public function hide_leftcolumn($isOn=FALSE){$this->showLeftcolumn =$isOn;}
    public function use_page404($isOn=TRUE){$this->isPage404 = $isOn;}
    public function set_page404($sPath){$this->sPathPage404 = $sPath;}
    public function use_page401($isOn=TRUE){$this->isPage401 = $isOn;}
    public function set_page401($sPath){$this->sPathPage401 = $sPath;}
    public function set_popup($isOn=TRUE){$this->isPopup = $isOn;}
    public function set_theme_folder($value=""){$this->sThemeFolder=$value; $this->sThemeFolderDs=$this->sThemeFolder.TFW_DS;}
    public function set_warning_message($sMessage){$this->sWarningMessage = $sMessage;}
    public function hide_element_topform($isOn=TRUE){$this->hideElementTopForm=$isOn;}
    public function set_page_title($sValue){$this->sPageTitle=$sValue;}
    public function set_page_description($sValue){$this->sPageDescription=$sValue;}
    public function set_page_keywords($sValue){$this->sPageKeywords=$sValue;}
    public function disable_unset($isOn=FALSE){$this->isUnset=$isOn;}
    
    /**
     * Add js files to be loaded
     * @param string|csvstring $mxFileName
     * @param boolean $isApp 0:Theframework 1:Theapplication
     */
    public function add_js($mxFileName,$isApp=1)
    {
        if(strstr($mxFileName,","))
        {
            $mxFileName = explode(",",$mxFileName);
            foreach($mxFileName as $sFileName)
                $this->arJs[$isApp][] = trim($sFileName);
        }        
        elseif($mxFileName)
            $this->arJs[$isApp][] = trim($mxFileName);
    }
    
    public function remove_js($mxFileName,$isApp=1)
    {
        if(strstr($mxFileName,","))
        {
            $mxFileName = explode(",",$mxFileName);
            foreach($mxFileName as $sFileName)
                $this->arJsExclude[$isApp][] = trim($sFileName);
        }        
        elseif($mxFileName)
            $this->arJsExclude[$isApp][] = trim($mxFileName);
    }
 
    private function is_js_excluded($sFileName,$isApp){return (in_array($sFileName,$this->arJsExclude[$isApp]));}
    
    /**
     * Resetea $this->arJs[$isApp]
     * Asigna $mxValue si procede
     * @param string|csvstring|array $mxValue
     * @param boolean $isApp 1|0
     */
    public function set_js($mxValue,$isApp=1)
    {
        $this->arJs[$isApp] = array();
        if(is_array($mxValue))
            $this->arJs[$isApp] = $mxValue;
        elseif(strstr($mxValue,",")) 
            $this->arJs[$isApp] = explode(",",$mxValue);
        elseif($mxValue)
            $this->arJs[$isApp][] = $mxValue;
    }
    
    public function set_js_rewrite($isOn=TRUE){$this->isJsRewrite=$isOn;}
    public function set_is_justview($isOn=TRUE){$this->isJustView=$isOn;}
    //**********************************
    //             GETS
    //**********************************    
    public function get_session_user(){return $this->oSessionUser;}
    public function get_bodyclass(){return $this->sBodyClass;}
    public function is_leftcolumn(){return $this->showLeftcolumn;}    
    public function get_path_view(){return $this->sPathView;}
    public function is_page404(){return $this->isPage404;}
    public function is_page401(){return $this->isPage401;}
    public function is_popup(){return $this->isPopup;}
    public function get_theme_folder(){return $this->sThemeFolder;}
    public function get_layout(){return $this->sLayout;}

    protected function show_url_referer(){echo $_SERVER["HTTP_REFERER"];}
    public function get_page_title(){return $this->sPageTitle;}
    public function get_page_description(){return $this->sPageDescription;}
    public function get_page_keywords(){return $this->sPageKeywords;}
    public function show_page_title(){echo $this->get_page_title();}
    public function show_page_description(){echo $this->get_page_description();}
    public function show_page_keywords(){echo $this->get_page_keywords();}
    public function get_last_url_referer(){if(isset($_SESSION["viewreferer"]))return $_SESSION["viewreferer"];return "/";}
    public function show_last_url_referer(){echo $this->get_last_url_referer();}
}//TheFrameworkView
