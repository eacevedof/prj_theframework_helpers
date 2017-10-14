<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Main\TheFramework
 * @file theframework.php
 * @version 1.0.0
 * @date 08-10-2017 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Main;

use TheFramework\Components\ComponentUri;

class TheFramework
{
    protected $sCurrentUrl;    
    /**
     * @var ComponentFile
     */
    protected $oLog;
    /**
     * @var ComponentSession
     */    
    protected $oSession;
    /**
     * @var ModelUser
     */    
    protected $oSessionUser;

    protected $sModuleName;
    protected $sClientBrowser;
    protected $isMobileDevice;
    protected $isConsoleCalled;

    protected $isAjax;
 
    //ERRORS HANDLERS
    protected $isError = FALSE;
    protected $arErrorMessages = [];
  
    protected $arDebug = [];
    protected $isPermaLink = FALSE;
    protected $sIsoLang;
    protected $sIdLang;
    protected $sSessionId;

    public function __construct()
    {
        
//        if(session_status()==PHP_SESSION_NONE)
//            session_start();
//        //sets clientbrowser, isMobileDevice
//        $this->load_client_device();        
//        if(defined("STDIN"))$this->isConsoleCalled=TRUE;
//        if(defined("TFW_IS_PERMALINK"))$this->isPermaLink = TFW_IS_PERMALINK;
//        if(defined("TFW_DEFAULT_LANGUAGE_ISO")) 
//            $this->sIsoLang = (TFW_DEFAULT_LANGUAGE_ISO!==""?$_GET["tfw_iso_language"]:NULL);
//        //bug($this->sIsoLang,"isolang");
//        $this->sSessionId = $this->get_session_id();
//        //bug($this->isPermaLink,"permalink");
    }

    public function js_selfclose($fSeconds=0,$sMessage="")
    {
        $fMiliSeconds = $fSeconds * 1000;
        $sJs = "<script type=\"text/javascript\" base=\"theframework.js_selfclose\">\n";
        $sJs .= "function selfclose(){self.close();}\n";
        $sJs .= "window.setTimeout(selfclose,$fMiliSeconds);\n";
        $sJs .= "</script>\n";
        if($sMessage && $fSeconds) $sJs .= "<div style=\"text-align:center;\">$sMessage</div>";
        echo $sJs;        
    }
   
    public function js_parent_refresh()
    {
        $sJs = "<script type=\"text/javascript\" base=\"theframework.js_parent_refresh\">\n";
        $sJs .= "(
                    function()
                    {
                        //el padre es el que hizo la llamada directa
                        var eParentWindow = top.opener;
                        eParentWindow.location.replace(eParentWindow.location);
                    }\n";
        $sJs .= ")();\n";
        $sJs .= "</script>\n";
        echo $sJs;        
    }    

    public function js_colseme_and_parent_refresh($fSeconds=0,$sMessage="")
    {
        $this->js_parent_refresh();
        $this->js_selfclose($fSeconds,$sMessage);
    }
   
    public function js_go_to($sUrl,$fSeconds=0,$sMessage="")
    {
        //window.setTimeout('runMoreCode()',timeInMilliseconds);
        $fMiliSeconds = $fSeconds * 1000;
        $sJs = "<script type=\"text/javascript\" base=\"theframework.js_go_to\">\n";
        $sJs .= "function go_to(sUrl){window.location=sUrl;}\n";
        $sJs .= "window.setTimeout(go_to,$fMiliSeconds,'$sUrl');\n";
        $sJs .= "</script>\n";
        if($sMessage && $fMiliSeconds) $sJs .= "<div style=\"text-align:center;\">$sMessage</div>";        
        echo $sJs;
    }
   
    protected function get_url_language($sUrl)
    {
        if(isset($_GET["tfw_iso_language"]) && $sUrl)
        {
            if(!(strstr($sUrl,"http")||strstr($sUrl,"javascript:")))
            {
                $sLang = $_GET["tfw_iso_language"];
                $sC = $sUrl[0];
                if($sC=="/")
                    $sUrl = "/$sLang$sUrl";
                else
                    $sUrl = "$sLang/$sUrl";
            }
        }
        return $sUrl;
    }//fix_url_language
    
    protected function go_to_url($sUrl,$isExit=1)
    {
        //$sUrl=$this->get_url_language($sUrl);
        header("Location:$sUrl");
        if($isExit) exit();
    }//go_to_url
    
    protected function is_inrequesturi($mxSearch,$isRegex=0)
    {
        $sReqUri = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
        if(is_array($mxSearch))
        {
            foreach($mxSearch as $sSearch)
            {
                if($this->in_string($sSearch,$sReqUri,$isRegex))
                    return true;
            }
            return false;
        }
        else
        {
            return $this->in_string($mxSearch,$sReqUri,$isRegex);
        }
    }//is_inrequesturi
   
    /**
     * Limpia los separadores de directorios al entendido por DIRECTORY_SEPARATOR
     * @param string $sPathSystem Ruta con cualquier tipo de separador de directorios
     * @return string Ruta con separadores de directorios validos
     */
    protected function get_fixed_syspath($sPathSystem="")
    {
        $sPathSystem = trim($sPathSystem);
        //http://websvn.eduardoaf.com/filedetails.php?repname=proy_tasks&path=%2Ftrunk%2Fproy_tasks%2Fthe_framework%2Fmvc%2Fmain%2Ftheframework_view.php&rev=293
        if($sPathSystem)
        {
            //todas las rutas se llevan a un tipo de separador de directorio
            $sPathSystem = str_replace("\\/","/",$sPathSystem);
            $sPathSystem = str_replace("/\\","/",$sPathSystem);
            $sPathSystem = str_replace("\\","/",$sPathSystem);
            $sPathSystem = str_replace("//","/",$sPathSystem);
            $sPathSystem = str_replace("\\\\","/",$sPathSystem);
            //se repmplaza el tipo de separador por el del sistema
            $sPathSystem = str_replace("/",DIRECTORY_SEPARATOR,$sPathSystem);
            $sPathSystem = str_replace("\\",DIRECTORY_SEPARATOR,$sPathSystem);
        }
        return $sPathSystem;
    }  
   
    /**
     * Genera una url segun el tipo. Si es permalink usa / 
     * sino usa &
     * @param string $sPackage Nombre del paquete de controladores
     * @param string $sController Nombre del controlador del módulo 
     * @param string $sPartial Nombre de clase parcial
     * @param string $sMethod Metodo que dibujará los datos procesados sobre la vista
     * @param string $sExtra  
     * @return string Cadena con la url formada
     */
    protected function build_url($sPackage=NULL,$sController=NULL,$sPartial=NULL,$sMethod=NULL,$sExtra=NULL)
    {
        $oUrl = new ComponentUri();
        $oUrl->set_permalink($this->isPermaLink);
        if(!$sPackage && $this->sModuleGroup)
            $sPackage = $this->sModuleGroup;
        elseif($sPackage=="public")
            $sPackage = "";
        $oUrl->set_package($sPackage);
        if(!$sController && $this->sModuleName)
            $sController = $this->sModuleName;
        $oUrl->set_controller($sController);
        $oUrl->set_partial($sPartial);
        $oUrl->set_method($sMethod);
        $oUrl->set_extra($sExtra);
        return $oUrl->get_built();
    }
    
    protected function pr_url($sPackage=NULL,$sController=NULL,$sPartial=NULL,$sMethod=NULL,$sExtra=NULL)
    {
        echo $this->build_url($sPackage,$sController,$sPartial,$sMethod,$sExtra);   
    }

    protected function go_to_module($sPackage=NULL,$sController=NULL,$sPartial=NULL,$sMethod=NULL,$sExtra=NULL)
    {
        $sUrl = $this->build_url($sPackage,$sController,$sPartial,$sMethod,$sExtra);
        //bug($sUrl,"url in go_to_module");die;
        $this->go_to_url($sUrl);
    }

    //Para los parciales no van bien pq es necesario pasar el parametro del módulo padre. Por ejemplo las lineas de una 
    //cabecera de pedido. Al borrar una linea si se va al listado hay que pasar el id de la cabecera
    protected function go_to_list($sExtra=NULL){$this->go_to_module($_GET["tfw_group"],$_GET["tfw_module"],$_GET["tfw_section"],"get_list",$sExtra);}
   
    protected function go_to_insert(){$this->go_to_module($_GET["tfw_group"],$_GET["tfw_module"],$_GET["tfw_section"],"insert");}
   
    protected function go_to_update($sExtra){$this->go_to_module($_GET["tfw_group"],$_GET["tfw_module"],$_GET["tfw_section"],"update",$sExtra);}    
   
    /**
     * Rescrito en theframework_model añadiendo el nombre de tabla
     * @return string tablename_|idusuario_yyyymmdd.log
     */
    private function get_log_name()
    {
        $sLogName = "controller_";
        if(isset($_SESSION["tfw_user_identificator"])) 
            $sLogName .= $_SESSION["tfw_user_identificator"]."_";
        $sLogName .= date("Ymd").".log";
        return $sLogName;
    }//get_log_name
   
    protected function log_error($mxContent,$sTitle="")
    {
        $sAuxPathFolder = $this->oLog->get_path_folder_target();
        $sAuxFilename = $this->oLog->get_target_file_name();
        $sPathFolder = TFW_PATH_FOLDER_LOGDS."errors";
        
        if(!is_string($mxContent))
            $mxContent = var_export($mxContent,TRUE);
        
        $sHour = "[".date("H:i:s")."]";
        if($sTitle!=="") $sTitle = "\n$sTitle:\n";
        $mxContent = $sHour.$sTitle.$mxContent;
        $this->oLog->set_path_folder_target($sPathFolder);
        //nombre tipo: controller_userid_yyyymmdd.log
        $this->oLog->set_filename_target($this->get_log_name());
        $this->oLog->add_content($mxContent);
        //Restauro la carpeta y archivo configurado
        $this->oLog->set_path_folder_target($sAuxPathFolder);
        $this->oLog->set_filename_target($sAuxFilename);        
    }
   
    /**
     * Uses var_export $mxContent is not a string
     * @param type $mxContent
     */
    protected function log_custom($mxContent,$sTitle="")
    {
        $sLogFilename = $this->get_log_name();
        if(!is_string($mxContent))
            $mxContent = var_export($mxContent,TRUE);
        
        if($sTitle!=="") 
            $sTitle = "\n$sTitle:\n";
        
        $mxContent = $sTitle.$mxContent;
        //guarda en custom
        $sLogFilename = str_replace(".log","",$sLogFilename);
        $this->oLog->writelog($mxContent,$sLogFilename,"trace");
    }
    
    protected function log_email($mxContent,$sTitle="")
    {
        $sAuxPathFolder = $this->oLog->get_path_folder_target();
        $sAuxFilename = $this->oLog->get_target_file_name();
        $sPathFolder = TFW_PATH_FOLDER_LOGDS."emails";
        
        if(!is_string($mxContent))
            $mxContent = var_export($mxContent,TRUE);
        
        $sHour = "[".date("H:i:s")."]";
        if($sTitle!=="") $sTitle = "\n$sTitle:\n";
        $mxContent = $sHour.$sTitle.$mxContent;
        $this->oLog->set_path_folder_target($sPathFolder);
        //nombre tipo: controller_userid_yyyymmdd.log
        $this->oLog->set_filename_target($this->get_log_name());
        $this->oLog->add_content($mxContent);
        //Restauro la carpeta y archivo configurado
        $this->oLog->set_path_folder_target($sAuxPathFolder);
        $this->oLog->set_filename_target($sAuxFilename);        
    }//log_email
    
    /**
     * Escribe en nombre de archivo: session_user_<user_identificator>|_<attempt>_yyyymmdd.log
     * el contenido [hh:mm:ss] - [ip:xxx.xxx.xxx.xxx] - [goto:urlrequested] $sContent
     * @param string $sContent
     */
    protected function log_session($sContent="")
    {
        $sAuxPathFolder = $this->oLog->get_path_folder_target();
        $sAuxFilename = $this->oLog->get_target_file_name();
        $sPathFolder = TFW_PATH_FOLDER_LOGDS."session";
       
        $sRemoteIp = $this->get_remote_ip();
        $sUrl = $this->get_request_uri();
        
        $sFileName = "session_user";
        if(isset($_SESSION["tfw_user_identificator"]))
            $sFileName .= "_".$_SESSION["tfw_user_identificator"];
        else 
            $sFileName .= "_attempt";
        $sFileName.="_".date("Ymd").".log";
        $sContent = "[".date("H:i:s")."] - [ip:$sRemoteIp] - [goto:$sUrl] $sContent";
        $sContent = trim($sContent);
        
        $this->oLog->set_path_folder_target($sPathFolder);
        //nombre tipo: controller_userid_yyyymmdd.log
        $this->oLog->set_filename_target($sFileName);
        $this->oLog->add_content($sContent);
        
        //Restauro la carpeta y archivo configurado
        $this->oLog->set_path_folder_target($sAuxPathFolder);
        $this->oLog->set_filename_target($sAuxFilename);
    }    
   
    protected function get_fields_from_post($arFormats=[])
    {
        $arPrefix = "txt,pas,hid,sel,chk,rad,dat,txa";
        $arPrefix = explode(",",$arPrefix);
        $arFieldNames = [];
        foreach($arPrefix as $sPrefix)
        {
            foreach($_POST as $sPostFieldName=>$mxValue)
            {
                $sPostPrefix = $this->extract_prefix($sPostFieldName);
                if($sPrefix == $sPostPrefix)
                {
                    $sFieldName = $this->extract_fieldname($sPostFieldName);
                    $sFieldName = camel_to_sep($sFieldName);
                   
                    $mxValue = $this->format_value($arFormats,$sFieldName,$mxValue);
                    $arFieldNames[$sFieldName] = $mxValue;
                }
//                else
//                    $arFieldNames[$sPostFieldName] = $mxValue;
            }
        }
        return $arFieldNames;
    }
   
    private function extract_prefix($sFieldName){return substr($sFieldName,0,3);}
    private function extract_fieldname($sPostKey){return substr($sPostKey,3);}
    
    protected function get_encrypted($sToEncrypt,$sKey="")
    {
        $sEncrypted = "";
        if($sToEncrypt)
        {
            //la clave debe tener 64 caracteres
            $iLen = strlen($sKey);
            if($iLen<64)
            {
                $iLen = 64-$iLen;
                for($i=0; $i<$iLen; $i++)
                    $sKey .= "1";
            }
            
            # la clave debería ser binaria aleatoria, use scrypt, bcrypt o PBKDF2 para
            # convertir un string en una clave
            # la clave se especifica en formato hexadecimal
            $sKey = pack("H*",$sKey);
            # crear una aleatoria IV para utilizarla co condificación CBC
            $iSizeIv = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $sInitVector = mcrypt_create_iv($iSizeIv,MCRYPT_RAND);
            # crea un texto cifrado compatible con AES (tamaño de bloque Rijndael = 128)
            # para hacer el texto confidencial 
            # solamente disponible para entradas codificadas que nunca finalizan con el
            # el valor  00h (debido al relleno con ceros)
            $sEncrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$sKey,$sToEncrypt,MCRYPT_MODE_CBC,$sInitVector);
            # anteponer la IV para que esté disponible para el descifrado
            $sEncrypted = $sInitVector.$sEncrypted;
            # codificar el texto cifrado resultante para que pueda ser representado por un string
            $sEncrypted = base64_encode($sEncrypted);
        }
        return $sEncrypted;
    }//get_encrypted
    
    protected function get_decrypted($sToDecrypt,$sKey="")
    {
        $sDecrypted = "";
        if($sToDecrypt)
        {
            $iLen = strlen($sKey);
            if($iLen<64)
            {
                $iLen = 64-$iLen;
                for($i=0; $i<$iLen; $i++)
                    $sKey .= "1";
            }
            $sKey = pack("H*",$sKey);
            $sDecrypted = base64_decode($sToDecrypt);
            $iSizeIv = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC);
            # recupera la IV, iv_size debería crearse usando mcrypt_get_iv_size()
            $sInitVector = substr($sDecrypted,0,$iSizeIv);
            # recupera el texto cifrado (todo excepto el $iv_size en el frente)
            $sDecrypted = substr($sDecrypted,$iSizeIv);
            # podrían eliminarse los caracteres con valor 00h del final del texto puro
            $sDecrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$sKey,$sDecrypted,MCRYPT_MODE_CBC,$sInitVector);        
        }
        return $sDecrypted;
    }//get_decrypted
    
    protected function get_csrf()
    {
        $oEncdec = new ComponentEncdecrypt();
        return $oEncdec->get_csrf();
    }//get_csrf
    
    protected function is_csrf_ok($sCsrf=NULL)
    {
        if(!$sCsrf)
            $sCsrf = $this->get_post("hidCsrf");
        $oEncdec = new ComponentEncdecrypt();
        return $oEncdec->check_hashpassword(session_id(),$sCsrf);
    }//is_csrf_ok
    
    protected function save_csrf($sCk=NULL)
    {
        if(class_exists("ModelSecurityCsrf"))
        {
            $oModelCsrf = new ModelSecurityCsrf();
            $sCsrf = $this->get_post("hidCsrf");
            if($sCk===NULL)
                $sCk = $this->get_post("hidBot");

            $oModelCsrf->set_csrf($sCsrf);
            $oModelCsrf->set_remote_ip($this->get_remote_ip());
            $oModelCsrf->set_sessionid(session_id());
            $oModelCsrf->set_sessionck($sCk);
            $oModelCsrf->set_url($this->get_request_uri());
            $sReq = var_export($this->get_get(),true);
            $arClean = ["\t"=>"","\n"=>""
                ,"' => '"=>"'=>'","',  '"=>"','","array (  '"=>"array("];
            $this->replace($arClean,$sReq);
            $oModelCsrf->set_req_get($sReq);
            $sReq = var_export($this->get_post(),true);
            $this->replace($arClean,$sReq);
            $oModelCsrf->set_req_post($sReq);
            $oModelCsrf->autoinsert();
        }
        else
            $this->log_error("class not found: ModelSecurityCsrf","save_csrf()");
    }//save_csrf

        
    //=======================
    //        SETS
    //=======================
    /**
     * Resetea $arReference y aplica el/los valores pasados en $mxValue
     * Los falsi values se omitirán: NULL,0,"0",FALSE,""
     * @param array $arReference Array a modificar
     * @param string|csvstring|array $mxValue valor o valores a asignar 
     */
    protected function set_array(&$arReference,$mxValue)
    {
        $arReference = []; 
        if($mxValue!==NULL)
        {
            if(is_array($mxValue)) 
                $arReference = $mxValue;
            elseif(strstr($mxValue,","))
                $arReference = explode(",",$arReference);
            elseif($mxValue)
                $arReference[] = $mxValue; 
        }
    }  
    
    protected function add_error($sMessage)
    {
        $this->log_error($sMessage,__CLASS__);
        $this->isError = TRUE;
        if($sMessage)
            $this->arErrorMessages[] = $sMessage;        
    }
    protected function set_error($sMessage="")
    {
        $this->isError = FALSE;
        $this->set_array($this->arErrorMessages,$sMessage);
    }
    
    protected function set_post($sKey,$mxValue){$_POST[$sKey] = $mxValue;}
    protected function set_get($sKey,$mxValue){$_GET[$sKey] = $mxValue;}

    private function load_client_device()
    {
        $this->sClientBrowser = $_SERVER["HTTP_USER_AGENT"];        
        $this->isMobileDevice = TRUE;
        
        $sPattern1 = "/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine"
                . "|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i"
                . "|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)"
                . "|vodafone|wap|windows (ce|phone)|xda|xiino/i";
        $sPattern2 = "/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|"
                . "amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)"
                . "|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw"
                . "|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8"
                . "|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit"
                . "|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)"
                . "|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)"
                . "|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/"
                . "|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)"
                . "|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)"
                . "|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)"
                . "|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9"
                . "|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar"
                . "|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)"
                . "|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)"
                . "|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)"
                . "|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i";
        
        if(preg_match($sPattern1,$this->sClientBrowser)
           || preg_match($sPattern2,substr($this->sClientBrowser,0,4)))
            $this->isMobileDevice = TRUE;
    }//load_client_device
   
    /**
     *
     * @param string $sMessage
     * @param string $sType i:info(blue),s:success(green),w:warning(yellow),e:error(red)
     */
    protected function set_session_message($sMessage,$sType="s"){$_SESSION["tfw_message"][$sType] = $sMessage;}
   
    /*NIU*/
    protected function post_to_get($sKey){$_GET[$sKey] = $_POST[$sKey];}
    /*NIU*/
    protected function get_to_post($sKey){$_POST[$sKey] = $_GET[$sKey];}  
    /*NIU*/
    protected function even_post_to_get()
    {
        $arKeys = array_keys($_POST);
        foreach($arKeys as $sKey)
            $_GET[$sKey] = $_POST[$sKey];
    }
   
    /*NIU*/
    protected function even_get_to_post()
    {
        $arKeys = array_keys($_GET);
        foreach($arKeys as $sKey)
            $_POST[$sKey] = $_GET[$sKey];
    }
   
    protected function set_post_get_page()
    {
        //bugpg();
        if(isset($_POST["selPage"]))$_GET["page"] = $_POST["selPage"];
        if(isset($_GET["page"]))$_POST["selPage"] = $_GET["page"];
        //bugpg();die;
        //bugg("page");bugp("selPage");
    }
   
    protected function clear_post(){$_POST = NULL;}
    protected function clear_get(){$_GET = NULL;}    
    protected function reset_post(){$_POST = NULL;}
    protected function reset_get(){$_GET = NULL;}
    protected function reset_files(){$_FILES = NULL;}
    protected function reset_session(){$_SESSION = NULL;}

    public function set_ajax($isOn=TRUE){$this->isAjax=$isOn;}
   
    protected function go_to_401($isForbidden=FALSE)
    {
        if($isForbidden) 
        {
            $sUrlFrom = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
            setcookie("tfw_error401",$sUrlFrom,time()+(86400 * 30),"/"); // 86400 = 1 day
            $this->go_to_url($this->get_url_language("/error-401/"));
        }
    }//go_to_401
    
    protected function go_to_404($isNotExist=TRUE)
    {
        if($isNotExist) 
        {
            $sUrlFrom = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
            setcookie("tfw_error404",$sUrlFrom,time()+(86400 * 30),"/"); // 86400 = 1 day
            $this->go_to_url($this->get_url_language("/error-404/"));
        }
    }//go_to_404
    
    protected function build_session_filterkey()
    {
        $sSessionKey = "";
        $arKeys = array("tfw_iso_language","tfw_group","tfw_module","tfw_partial","tfw_view");
        foreach($arKeys as $sKey)
            if($this->is_inget($sKey))
                $sSessionKey .= $this->get_get($sKey);
        return $sSessionKey;
    }

    protected function set_debug($mxVar){$this->arDebug=[]; $this->arDebug[] = $mxVar;}
    protected function add_debug($mxVar){$this->arDebug[] = $mxVar;}
    protected function add_alert($sMessage){$_SESSION["tfw_message"]["a"][]=$sMessage;}
    protected function add_alert_obj($oHelper){$_SESSION["tfw_message"]["helper_object"]=$oHelper;}
    public function clear_alert_obj(){unset($_SESSION["tfw_message"]["helper_object"]);}
    
    protected function is_enviroment($sEnv)
    {
        if(defined("TFW_ENVIROMENT"))return (TFW_ENVIROMENT===$sEnv);
        return FALSE;
    }
    
    protected function is_env_local(){return $this->is_enviroment("local");}
    protected function is_env_development(){return $this->is_enviroment("development");}
    protected function is_env_preproduction(){return $this->is_enviroment("preproduction");}
    protected function is_env_production(){return $this->is_enviroment("production");}
    
    //=======================
    //         GETS
    //=======================
    public function is_error(){return $this->isError;}
   
    protected function get_error_message($isHtmlNl=0)
    {
        $sMessage = implode("\n",$this->arErrorMessages);
        if($isHtmlNl)
            $sMessage = implode("<br/>",$this->arErrorMessages);
        return $sMessage;
    }
    public function get_alert_obj(){return(isset($_SESSION["tfw_message"]["helper_object"])?$_SESSION["tfw_message"]["helper_object"]:null);}
    
    /**
     * Comprueba recorriendo todas las claves de arCheck hasta encontrar una parecida
     * a sKeyLike. Una vez encontrada comprueba si coincide con sAction
     * 
     * El fin es encontrar hidAction_i==sAction. is_inserting, is_updating... etc 
     * @param string $sKeyLike
     * @param array $arCheck
     * @param string $sAction
     * @return boolean
     */
    private function is_multi($sKeyLike,$arCheck,$sAction="")
    {
        if(is_array($arCheck))
        {
            $arKeys = array_keys($arCheck);
            foreach($arKeys as $sKey)
            {
                //hidAction0,hidAction1... campos por formulario en el post solo llegará uno asi que
                //con el con buscar hidAction es suficiente para entender que existe ese campo
                if(strstr($sKey,$sKeyLike))
                {
                    if($sAction)
                        return ($arCheck[$sKey]==$sAction);
                    return TRUE;
                }   
            }
        }
        return FALSE;
    }
    
    /**
     * @return boolean Indica si la accion en post es de actualizacion o insercion
     */
    //protected function is_updating(){return ($_POST["hidAction"]=="update");}
    protected function is_updating(){return $this->is_multi("hidAction",$_POST,"update");}
    //protected function is_updatinglist(){return ($_POST["hidAction"]=="updatelist");}
    protected function is_updatinglist(){return $this->is_multi("hidAction",$_POST,"updatelist");}
    //protected function is_inserting(){return ($_POST["hidAction"]=="insert");}
    protected function is_inserting(){return $this->is_multi("hidAction",$_POST,"insert");}
    //protected function is_insertinglist(){return ($_POST["hidAction"]=="insertlist");}
    protected function is_insertinglist(){return $this->is_multi("hidAction",$_POST,"insertlist");}
    protected function is_postback($sFieldName="")
    {
        if($this->is_multi("hidAction",$_POST,"postback"))
        {
            if($sFieldName)
            {
                //$_POST["hidPostback*"]==fieldname
                return ($this->is_multi("hidPostback",$_POST,$sFieldName));
            }
            else
                return TRUE;
        }
        return FALSE;
    }
    
    protected function is_action($sAction)
    {
        if($sAction)
            return $this->is_multi("hidAction",$_POST,$sAction);
        else //si no se indica una accion se comprueba lo que trae hidAction
            return $this->is_multi("hidAction",$_POST);
    }
    
    protected function is_multidelete(){return $this->is_multi("hidAction",$_POST,"multidelete");}
    protected function is_multiselect(){return $this->is_multi("hidAction",$_POST,"multiselect");}
    protected function is_multiquarantine(){return $this->is_multi("hidAction",$_POST,"multiquarantine");}
    
    protected function is_form($sForm){return $this->is_multi("hidForm",$_POST,$sForm);}
    
    /**
     * @param string $sKey El indice en el array $_POST
     * @return mixed el valor que se guarde en $_POST
     */    
    //protected function get_post($sKey="",$iIndex=NULL){return (($sKey=="")? $_POST : ($iIndex!==NULL)?$_POST[$sKey][$iIndex]:$_POST[$sKey]);}
    protected function get_post($sKey=NULL,$iIndex=NULL)
    {
        if($sKey===NULL) 
            return $_POST;
        elseif($iIndex!==NULL && isset($_POST[$sKey][$iIndex]))
            return $_POST[$sKey][$iIndex];
        elseif(isset($_POST[$sKey]))
            return $_POST[$sKey];
        return NULL;
    }
   
    /**
     * @param string $sKey El indice en el array $_GET
     * @return mixed el valor que se guarde en $_GET
     */
    protected function get_get($sKey="")
    {
        if($sKey && isset($_GET[$sKey]))
            return $_GET[$sKey];
        elseif($sKey)
            return NULL;
        return $_GET;
    }
    
    protected function is_post(){return (boolean)count($_POST);}
    protected function is_get(){return (boolean)count($_GET);}
    protected function is_files(){return (boolean)count($_FILES);}
    
    protected function is_inpost($mxKey){return in_array($mxKey,array_keys($_POST));}
    protected function is_inget($mxKey){return in_array($mxKey,array_keys($_GET));}
    protected function is_infiles($sKey)
    {
        $arFilNames = array_keys($_FILES);
        foreach($arFilNames as $sFilName)
            if($sKey==$sFilName)
                return ($_FILES[$sKey]["name"]);
        return FALSE;
    }
    protected function is_insession($mxKey){return isset($_SESSION[$mxKey]);}
    protected function is_insession_filter($sFilterName)
    {
        $arSessFilter = [];
        $sSessionKey = $this->build_session_filterkey();
        if(isset($_SESSION[$sSessionKey]["filters"]))
            $arSessFilter = array_keys($_SESSION[$sSessionKey]["filters"]);
        return in_array($sFilterName,$arSessFilter);
    }
    
    protected function get_current_url()
    { 
        $sUrl="";
        $sPiece = $this->get_get("tfw_iso_language");
        if($sPiece)$sUrl .= $sPiece;        
        $sPiece = $this->get_get("tfw_group");
        if($sPiece)$sUrl .= $sPiece;
        $sPiece = $this->get_get("tfw_module");
        if($sPiece)$sUrl .= $sPiece;
        $sPiece = $this->get_get("tfw_section");
        if($sPiece)$sUrl .= $sPiece;
        $sPiece = $this->get_get("tfw_view");
        if($sPiece)$sUrl .= $sPiece;
        //bug($sUrl);die;
        return $sUrl;
    }//get_current_url

    protected function get_current_section(){return ($_GET["tfw_section"])?$_GET["tfw_section"]:$_GET["tfw_partial"];}
    protected function get_current_view(){return ($_GET["tfw_view"])?$_GET["tfw_view"]:NULL;}
    protected function get_current_module(){return($_GET["tfw_controller"]?$_GET["tfw_controller"]:$_GET["tfw_module"]);}
    protected function get_current_group(){return($_GET["tfw_package"]?$_GET["tfw_package"]:$_GET["tfw_group"]);}
    protected function get_var_export($mxVar){return var_export($mxVar,true);}

    protected function get_session_message($sType="s",$clear=1)
    {
        $sMessage = "";
        if(isset($_SESSION["tfw_message"][$sType]))
            $sMessage = $_SESSION["tfw_message"][$sType];
        if($clear && $sMessage) unset($_SESSION["tfw_message"][$sType]);
        return $sMessage;
    }
 
    protected function get_session_filter($sFilterName)
    {
        $sSessionKey = $this->build_session_filterkey();
        return $_SESSION[$sSessionKey]["filters"][$sFilterName];
    }
   
    // ["hidOrderBy"]=> ["hidOrderType"]=>
    protected function get_orderby($sDelimiter=",")
    {
        if(isset($_POST["hidOrderBy"]))
        {
            if($_POST["hidOrderBy"])
                return explode($sDelimiter,$_POST["hidOrderBy"]);
        }
        return NULL;
        //return ($_POST["hidOrderBy"]) ? explode($sDelimiter,$_POST["hidOrderBy"]) : NULL;
        
    }//hidOrderType
    
    protected function get_ordertype($sDelimiter=",")
    {
        if(isset($_POST["hidOrderType"]))
        {
            if($_POST["hidOrderType"])
                return explode($sDelimiter,$_POST["hidOrderType"]);
        }
        return NULL;        
        //return ($_POST["hidOrderType"]) ? explode($sDelimiter,$_POST["hidOrderType"]) : NULL;
    }
    
    protected function get_audit_info($sInsertUser="",$sInsertDate=""
            ,$sUpdateUser="",$sUpdateDate=""
            ,$sDeleteUser="",$sDeleteDate="")
    {
        $sAuditInfo = NULL;
        
        if(class_exists("ModelUser"))
        {    
            $oModelUser = new ModelUser();
            if($sInsertUser)
            {
                $oModelUser->set_id($sInsertUser);
                $oModelUser->load_by_id();
                $sAuditInfo = tr_main_insert_user.$oModelUser->get_description();
                $sAuditInfo .= " - ";
            }
            //if($sCreateDate) $sAuditInfo .= tr_main_insert_date.crmdate_to_userdate($sCreateDate);
            if($sInsertDate) $sAuditInfo .= " ".crmdate_to_userdate($sInsertDate,12);
            //MODIFY
            if($sInsertUser || $sInsertDate) $sAuditInfo .= "&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;";
            if($sUpdateUser)
            {      
                $oModelUser->set_id($sUpdateUser);
                $oModelUser->load_by_id();
                $sAuditInfo .= tr_main_update_user.$oModelUser->get_description();
                $sAuditInfo .= " - ";
            }
            //if($sModifyDate) $sAuditInfo .= tr_main_update_date.crmdate_to_userdate($sModifyDate);
            if($sUpdateDate) $sAuditInfo .= " ".crmdate_to_userdate($sUpdateDate,12);
            //DELETE
            if($sDeleteUser || $sDeleteDate) $sAuditInfo .= "&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;";

            if($sDeleteDate)
            {  
                $oModelUser->set_id($sDeleteUser);
                $oModelUser->load_by_id();
                $sAuditInfo .= tr_main_delete_user.$oModelUser->get_description();
                $sAuditInfo .= " - ";
            }        
            //if($sDeleteDate) $sAuditInfo .= tr_main_delete_date.crmdate_to_userdate($sDeleteDate);
            if($sDeleteDate) $sAuditInfo .= " ".crmdate_to_userdate($sDeleteDate,12);
        }
        else
        {
            $sMessage = "get_audit_info(): Class ModelUser not found!";
            $this->add_error($sMessage);
        }
        return $sAuditInfo;
    }
   
    protected function get_assign_backurl($arKeys=[])
    {
        $arUrl = [];
        if($this->isPermaLink)
        {
            $sParam = $this->get_post("hidDataModule");
            if($sParam)$arUrl["mod"]=$sParam;
            $sParam = $this->get_post("hidDataSection");
            if($sParam) $arUrl["sec"]=$sParam;
            $sParam = $this->get_post("hidDataView");
            if($sParam)$arUrl["view"]=$sParam;

            $sParam = $this->get_get("tfw_parentmodule");
            if($sParam) $arUrl["pmod"]=$sParam;
            $sParam = $this->get_get("tfw_parentsection");
            if($sParam)$arUrl["psec"]=$sParam;
            $sParam = $this->get_get("tfw_parentview");
            if($sParam)$arUrl["pview"]=$sParam;
            
            $sParam = $this->get_get("tfw_iso_language");
            if($sParam)$arUrl["rlng"]=$sParam;            
            $sParam = $this->get_get("tfw_group");
            if($sParam)$arUrl["rgrp"]=$sParam;
            $sParam = $this->get_get("tfw_module");
            if($sParam)$arUrl["rmod"]=$sParam;
            $sParam = $this->get_get("tfw_section");
            if($sParam)$arUrl["rsec"]=$sParam;
            $sParam = $this->get_get("tfw_view");
            if($sParam)$arUrl["rview"]=$sParam;
            $sParam = (int)$this->get_get("close");
            $arUrl["close"]=$sParam;
            
            foreach($arKeys as $sKey)
            {
                $sParam = $this->get_get($sKey);
                if($sParam) $arUrl[$sKey] = $sParam;
            }
             //if($sParam)$arUrl["keys"]="k=";this->get_get("k")."&k2=";this->get_get("k2");
            return "/".implode("/",$arUrl)."/";
        }
        else
        {
            $sParam = $this->get_post("hidDataModule");
            if($sParam)$arUrl["mod"]="module=$sParam";
            $sParam = $this->get_post("hidDataSection");
            if($sParam) $arUrl["sec"]="section=$sParam";
            $sParam = $this->get_post("hidDataView");
            if($sParam)$arUrl["view"]="view=$sParam";

            $sParam = $this->get_get("parentmodule");
            if($sParam) $arUrl["pmod"]="parentmodule=$sParam";
            $sParam = $this->get_get("parentsection");
            if($sParam)$arUrl["psec"]="parentsection=$sParam";
            $sParam = $this->get_get("parentview");
            if($sParam)$arUrl["pview"]="parentview=$sParam";

            $sParam = $this->get_get("module");
            if($sParam)$arUrl["rmod"]="returnmodule=$sParam";
            $sParam = $this->get_get("section");
            if($sParam)$arUrl["rsec"]="returnsection=$sParam";
            $sParam = $this->get_get("view");
            if($sParam)$arUrl["rview"]="returnview=$sParam";
            $sParam = (int)$this->get_get("close");
            $arUrl["close"]="close=$sParam";            
                
            foreach($arKeys as $sKey)
            {
                $sParam = $this->get_get($sKey);
                if($sParam) $arUrl[$sKey] = "$sKey=$sParam";
            }
             //if($sParam)$arUrl["keys"]="k=";this->get_get("k")."&k2=";this->get_get("k2");
            return "?".implode("&",$arUrl);
        }
    }
   
    protected function get_listkeys($sKey="")
    {
        /*        $arKeys = $this->get_post("pkeys");
        if(!$arKeys) $arKeys = $this->get_post("id");
        $arKeyFields = $this->get_post("hidKeyFields");
        $arKeyFields = explode(",",$arKeyFields);
*/
        //si son multiples
        $arKeyValue = [];
        if($_POST["pkeys"])
        {
            //$arKeysNames = explode(",",$_POST["hidKeyFields"]);//id,Code_Erp
            $arKeyFields = $_POST["pkeys"];//id=24,Code_Erp=
            foreach($arKeyFields as $i=>$sKeysValues)
            {    
                $arKeysValues = explode(",",$sKeysValues);
                foreach($arKeysValues as $sKeyValue)
                {    
                    $arKV = explode("=",$sKeyValue);
                    $arKeyValue[$i][$arKV[0]] = $arKV[1];
                }
            }
        }
        elseif($_POST["id"])
            $arKeyValue = $_POST["id"];
        elseif($_POST[$sKey])
            $arKeyValue = $_POST[$sKey];
        return $arKeyValue;
    }
   
    /**
     * Este metodo devuelve todas las claves del grid. No los seleccionados, sino todos.
     * @return array tipo array(0=>array(pk1=>val1,pk2=>val2...),1..)
     */
    protected function get_rowkeys()
    {
        $arKeyFields = $this->get_post("hidKeyFields");
        $arPkNames = explode(",",$arKeyFields);
        //para cada clave existe un campo oculto hid<fieldname>_i
        $arRowKeys = [];
        foreach($_POST as $sKey=>$mxValue)
        {
            foreach($arPkNames as $sPkName)
            {
                $sHidPrefix = "hid$sPkName"."_";
                $iPos = str_replace($sHidPrefix,"",$sKey);
                if(strstr($sKey,$sHidPrefix))
                    $arRowKeys[$iPos][$sPkName]=$mxValue;
            }
        }
        return $arRowKeys;
    }
    
    /**
     * Convierte valores de interface a base de datos. Lo opuesto que se hace en table_basic
     * Se rescribe en the table_basic. 
     * @param array $arFormats array(fieldname1=>format1,fieldname2=>format2...)
     * @param string $sFieldName 
     * @param string $sFieldValue
     * @return mixed 
     */
    protected function format_value($arFormats,$sFieldName,$sFieldValue)
    {
        $sValue = "";
        $sFormat = NULL;
        if(isset($arFormats[$sFieldName]))
            $sFormat = $arFormats[$sFieldName];
        
        switch($sFormat) 
        {
            case "date":
                $sValue = bodb_date($sFieldValue);
            break;
        
            case "datetime4":
                $sValue = bodb_datetime4($sFieldValue);
            break;

            case "datetime6":
                $sValue = bodb_datetime6($sFieldValue);
            break;

            case "time4":
                $sValue = bodb_time4($sFieldValue);
            break;

            case "time6":
                $sValue = bodb_time6($sFieldValue);
            break;

            case "int":
                $sValue = bodb_int($sFieldValue);
            break;
        
            case "numeric2":
                $sValue = bodb_numeric2($sFieldValue);
            break;
        
            default:
                $sValue = $sFieldValue;
            break;
        }
        //bug($sValue,$sFieldName);
        return $sValue;
    }

    protected function get_todaydb($iSize=14)
    {
        switch($iSize)
        {
            case 14: return date("YdmHis");
            case 12: return date("YdmHi");
            default: return date("Ydm");
        }
    }
   
    //d-m-a h:m:s  d-m-a h:m
    protected function get_todaybo($iSize=14)
    {
        switch ($iSize)
        {
            case 14:return date("d/m/Y H:i:s");
            case 12:return date("d/m/Y H:i");
            default:return date("d/m/Y");
        }
    }
   
    public function is_ajax(){return $this->isAjax;}
   
    protected function get_post_numrow()
    {
        foreach($_POST as $sKey=>$mxValue)
            if(strstr($sKey,"hidRow_"))
                return $mxValue;
        return NULL;
    }
   
    protected function get_session($sKey=NULL){ return ($sKey)? $_SESSION[$sKey]:$_SESSION;}
    protected function is_session($sKey=""){return ($sKey)?in_array($sKey,array_keys($_SESSION)):(boolean)count($_SESSION);}
   
    protected function get_post_max_size()
    {
        //ini_get: obtiene el valor de un parametro de configuracion de apache
        return size_inbytes(ini_get("post_max_size"));      
//echo 'display_errors = ' . ini_get('display_errors') . "\n";
//echo 'register_globals = ' . ini_get('register_globals') . "\n";
//echo 'post_max_size = ' . ini_get('post_max_size') . "\n";
//echo 'post_max_size+1 = ' . (ini_get('post_max_size')+1) . "\n";
//echo 'post_max_size in bytes = ' . size_inbytes(ini_get("post_max_size"));        
    }
    
    /**
     *
     * @param string $sInputFileName
     * @param int $iFile
     * @return array
     */
    protected function get_upload_data($sInputFileName,$iFile=NULL)
    {
        $arFile = [];
        if(is_array($_FILES[$sInputFileName]["name"]))
        {    
            if($iFile!==NULL)
            {    
                $arFile["name"] = $_FILES[$sInputFileName]["name"][$iFile];
                $arFile["type"] = $_FILES[$sInputFileName]["type"][$iFile];
                $arFile["tmp_name"] = $_FILES[$sInputFileName]["tmp_name"][$iFile];
                $arFile["error"] = $_FILES[$sInputFileName]["error"][$iFile];
                $arFile["size"] = $_FILES[$sInputFileName]["size"][$iFile];
            }
            else
            {
                $arFile = $_FILES[$sInputFileName];
            }
        }
        else
        {            
            $arFile["name"] = $_FILES[$sInputFileName]["name"];
            $arFile["type"] = $_FILES[$sInputFileName]["type"];
            $arFile["tmp_name"] = $_FILES[$sInputFileName]["tmp_name"];
            $arFile["error"] = $_FILES[$sInputFileName]["error"];
            $arFile["size"] = $_FILES[$sInputFileName]["size"];                
        }  
        return $arFile;
    }
       
    protected function get_upload_count($sInputFileName)
    {
        $iCount = 0;
        foreach($_FILES[$sInputFileName]["name"] as $sName)
            if($sName!=="") $iCount++;
        return $iCount;
    }
   
    protected function get_upload_indexes($sInputFileName)
    {
        $arIndex = [];
        foreach($_FILES[$sInputFileName]["name"] as $i=>$sName)
            if($sName!=="") $arIndex[] = $i;
        return $arIndex;
    }
   
    protected function get_url_from(){return $this->get_post("hidUrlCurrent");}
    //=======================
    // OVERRIDE TO PUBLIC IF NECESSARY
    //=======================
    protected function set_session($sKey,$sValue){$_SESSION[$sKey]=$sValue;}
    protected function set_insession($sKey,$mxValue){$_SESSION[$sKey]=$mxValue;}
    protected function add_session($sKey,$mxValue){$_SESSION[$sKey]=$mxValue;}
    public function set_id_lang($value){$this->sIdLang=$value;}
    public function set_iso_lang($value){$this->sIsoLang=$value;}
    
    protected function get_server_lanip()
    {
        if($_SERVER["SERVER_ADDR"])
            return $_SERVER["SERVER_ADDR"];
        else
            return $_SERVER["LOCAL_ADDR"];
    }
   
    protected function get_url_referer(){return (isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"");}
   
    protected function get_request_uri($sType=0)
    {
        $sReqUri = (isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
        //sin get
        if($sType==1)
        {
            if(strstr($sReqUri,"?"))
            {
                $sReqUri = explode("?",$sReqUri);
                $sReqUri=$sReqUri[0];
            }
            remove_firstchar($sReqUri);
            remove_lastchar($sReqUri);            
        }        
        elseif($sType==2)
        {
            remove_firstchar($sReqUri);
            remove_lastchar($sReqUri);
        }
        return $sReqUri;
    }//get_request_uri
   
    protected function is_ipad(){return strstr($_SERVER["HTTP_USER_AGENT"],"iPad");}
    protected function is_iphone(){return strstr($_SERVER["HTTP_USER_AGENT"],"iPhone");}
    protected function get_remote_ip(){return $_SERVER["REMOTE_ADDR"];}
    protected function get_session_id(){return session_id();} 

    /**
     * Emula las tres operaciones básicas tipo join existentes en SQL
     * @param array $arLeft 
     * @param array $arRight
     * @param string $sType all|leftouter|inner|rightouter
     * @return array tipo array("leftouter"=>[],"inner"=>[],"rightouter"=>[])
     */
    protected function get_array_joins($arLeft,$arRight,$sType="all")
    {
        $arTmpLeft = [];
        $arTmpRight = [];
        $arTmpInner = [];
        
        $arAll = [];
        if($sType=="leftouter" || $sType=="all")
        {
            foreach($arLeft as $mxValue)
                if(!in_array($mxValue,$arRight))
                    $arTmpLeft[] = $mxValue;
            $arAll["leftouter"] = $arTmpLeft;
        }
        
        if($sType=="inner" || $sType=="all")
        {
            foreach($arLeft as $mxValue)
                if(in_array($mxValue,$arRight))
                    $arTmpInner[] = $mxValue;
            $arAll["inner"] = $arTmpInner;
        }
        
        if($sType=="rightouter" || $sType=="all")
        {
            foreach($arRight as $mxValue)
                if(!in_array($mxValue,$arLeft))
                    $arTmpRight[] = $mxValue;
            $arAll["rightouter"] = $arTmpRight;
        }
        return $arAll;
    }
    
    protected function get_slug_cleaned($sString,$sSpChar="-")
    {
        $sCleaned = trim($sString);
        $arBadChars = array
        (
            //caracter valido => caracteres invalidos
            "" => array
                (
                    "\'", "\"", "'", "|", "@", "#", "·", "$", "%", "&", "¬", "(", ")", "=", "?", "¿", 
                    "[", "]", "*", "+",  "\\", "/", "ª", "º", "{", "}", "<", ">", ";", ",", ":",
                    "¡", "!", "^","¨","º","ª","·","~","€","`","¨"
                ),
            "a" => array("á", "Á", "ä", "Ä", "â", "Â" ),
            "e" => array("é", "É", "ë", "Ë", "ê", "Ê" ),
            "i" => array("í", "Í", "ï", "Ï", "î", "Î" ),
            "o" => array("ó", "Ó", "ö", "Ö", "ô", "Ô" ),
            "u" => array("ú", "Ú", "ü", "Ü", "û", "Ü" ),
            "n" => array("ñ", "Ñ")
        );
        
        //Lo pasamos todo a minusculas
        $sCleaned = strtolower($sCleaned);
        
        //Relizamos la sustitucion de los caracteres extraños
        foreach($arBadChars as $cGood => $arWrongs)
        {
            foreach($arWrongs as $cWrong)
            { 
                $sCleaned = str_replace($cWrong,$cGood,$sCleaned);
            }
        } 
        //Los espacios se cambian por el char en el argumento
        $sCleaned = str_replace(" ",$sSpChar,$sCleaned);
        return $sCleaned;
    }
    
    protected function to_utf8($sValue)
    {
        $sCoding = mb_detect_encoding($sValue);
        if($sCoding!="UTF-8")
            return utf8_encode($sValue); //devuelve UTF8
            //return utf8_decode($sValue); //devuelve ISO
        return $sValue;
    }
   
    protected function has_childs($arParentChild,$idTest)
    {
        foreach($arParentChild as $arNode)
            if($idTest==$arNode["id_parent"] && $arNode["id"]!=NULL)
                return TRUE;
        return FALSE;
    }

    protected function has_parents($arParentChild,$idTest)
    {
         foreach($arParentChild as $arNode)
            if($idTest==$arNode["id"] && $arNode["id_parent"]!=NULL)
                return TRUE;
        return FALSE;
    }
    
    protected function get_childs($arParentChild,$idTest)
    {
        $arChilds = NULL;
        if($arParentChild) 
        {    
            $arChilds = [];
            foreach($arParentChild as $arNode)
                if($idTest==$arNode["id_parent"])
                    $arChilds[] = $arNode["id"];
        }
        return $arChilds;
    }
    
    protected function get_parents($arParentChild,$idTest)
    {
        $arParents = NULL;
        if($arParentChild) 
        {    
            $arParents = [];
            foreach($arParentChild as $arNode)
                if($idTest==$arNode["id"] && $arNode["id_parent"]!=NULL)
                    $arParents[] = $arNode["id_parent"];
        }
        return $arParents;        
    }
    
    /**
     * Recursive function
     * Before calling this, ensure $arParentChild has a NULL parent for the highest hierarchy id to avoid infinite recursion
     * @param string $idTest
     * @param array $arParentChild Full hierarchy  
     *  $arData[] = array("id"=>"1","id_parent"=>NULL);
     *  $arData[] = array("id"=>"2","id_parent"=>"1");
     *  $arData[] = array("id"=>"3","id_parent"=>"1");
     * @param int $toUp 0:gets childs hierarchy 1:gets parents hierarchy
     * @param array $arHierarchy All parents|childs of $idTest
     * @return 
     */
    protected function get_vhierarchy($idTest,$arParentChild,&$arHierarchy,$toUp=0)
    {
        //si el id a comprobar no es nulo y no existe en el array
        //el id a comprobar siempre debe estar incluido
        if($idTest!=NULL && !in_array($idTest,$arHierarchy))
            $arHierarchy[] = $idTest;
        
        if($toUp==0)
        {
             //si el id a comprobar es de un nivel superior
            if($this->has_childs($arParentChild,$idTest))
            {
                //obtenemos todos sus hijos 
                $arTmpChilds = $this->get_childs($arParentChild,$idTest);
                //con cada hijo lo guardamos en el array de hijos y al mismo tiempo
                //comprobamos si tienen hijos
                foreach($arTmpChilds as $idChild)
                {
                    if(!in_array($idChild, $arHierarchy) && $idChild!=NULL)
                        $arHierarchy[]=$idChild;
                    $this->get_vhierarchy($idChild,$arParentChild,$arHierarchy,0);
                }
            }
            //No es un superior
            else 
            {
                return;
            }
        }
        //$toUp=1 Jerarquia hacia arriba
        else
        {
             //si el id a comprobar es de un nivel inferior
            if($this->has_parents($arParentChild,$idTest))
            {
                //obtenemos todos sus padres 
                $arTmpParents = $this->get_parents($arParentChild,$idTest);
                //a cada padre lo guardamos en el array al mismo tiempo
                //comprobamos si tienen padres
                foreach($arTmpParents as $idParent)
                {
                    if(!in_array($idParent, $arHierarchy) && $idParent!=NULL)
                        $arHierarchy[]=$idParent;
                    $this->get_vhierarchy($idParent,$arParentChild,$arHierarchy,1);
                }
            }
            //No es un inferior, tiene id_parent NULL
            else 
            {
                return;
            }
        }
    }//get_vhierarchy
    
    protected function mixed_to_array($mxVariable,$sEplode=",")
    {
        //Casi siempre vendra a null
        if($mxVariable===NULL)
            return [];
        elseif(is_string($mxVariable))
            return explode($sEplode,$mxVariable);
        elseif(is_array($mxVariable))
            return $mxVariable;
        else
            return [];
    }

    /**
    * Elimina del $string el primer caracter si es igual a $c
    * @param string $sString La cadena sobre la que se operara
    * @param char $cLastChar El caracter que se desea eliminar
    * @return string String sin el primer caracter
    */
    public function remove_first_char(&$sString,$cLastChar="/")
    {
        $cFirstChar = $sString{0};
        if($cFirstChar == $cLastChar)
            $sString = substr($sString,1);
    }
    
    public function remove_last_char(&$sString,$cLastChar="/")
    {
        $iStrLen = strlen($sString);
        $cLast = $sString{$iStrLen-1};
        
        if($cLast == $cLastChar)
            $sString = substr($sString,0,$iStrLen-1);
    }
    
    public function is_lastchar_slash($sURL)
    {
        $iLen = strlen($sURL);
        if($iLen>0)
            $cLastChar = $sURL{$iLen-1};
        return ($cLastChar == "/");
    }
            
    public function is_even($iNumber)
    {
        return ($iNumber%2==0);
    }
    
    public function is_session_user()
    {
        if(is_object($this->oSessionUser))
            return ($this->oSessionUser->get_id());
        return FALSE;
    }
    
    public function in_string($sSearch,$sString,$isRegex=0){return in_string($sSearch,$sString,$isRegex);}
    
    public function get_id_lang(){return $this->sIdLang;}
    public function get_iso_lang(){return $this->sIsoLang;}

}//TheFramework
