<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\ComponentDatabase
 * @file component_database.php
 * @version 1.0.0
 * @date 08-10-2017 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Components;

class ComponentDatabase //Singleton
{
    private $sServer;
    private $sDBName;
    private $sUserName;
    private $sPassword;
    private $sDBType;
   
    private $oLink;
    private $arMessages;
    private $isError;
   
    private $iAffectedRows;
    /**
     * @var ComponentFile;
     */
    private $oLog;
    /**
    * @var ComponentDatabase
    */
    private static $oSelf = null;
   
    private $isTimeCapture = FALSE;
    private $fStartTime;
    private $fEndTime;
    private $fQueryTime;
    
    /**
     * @param string $sServer IP or DNS: ie: 192.168.1.22 or srv_001
     * @param string $sDbName ie: db_payments
     * @param string $sDbUser ie: imroot
     * @param string $sDbPassw ie: ItIsMyAccess
     * @param string $sDbType ie: mssql | mysql
     */
    public function __construct($sServer="",$sDbName="",$sDbUser="",$sDbPassw="",$sDbType="mysql")
    {
        $this->sServer = $sServer;
        $this->sDBName = $sDbName;
        $this->sUserName = $sDbUser;
        $this->sPassword = $sDbPassw;
        if(!$sServer){$this->sServer = TFW_DB_SERVER;}
        if(!$sDbName){$this->sDBName = TFW_DB_NAME;}
        if(!$sDbUser){$this->sUserName = TFW_DB_USER;}
        if(!$sDbPassw){$this->sPassword = TFW_DB_PASSWORD;}
        $this->sDBType = strtolower(trim($sDbType));
        $this->oLink = null; //objeto Id de Conexión
        $this->arMessages = array();
        $this->isError = FALSE;
        //TODO Component file hacerlo multisistema
        if(class_exists("ComponentFile"))
        {
            //Solo para logs de errores
            $this->oLog = new ComponentFile("windows");
            $this->oLog->set_path_folder_target(TFW_PATH_FOLDER_LOGDS."errors");
            $sFileName = "db_$sDbName";
            if(isset($_SESSION["tfw_user_identificator"]) && $_SESSION["tfw_user_identificator"]) 
                $sFileName .= $_SESSION["tfw_user_identificator"]."_";
            $sFileName .= date("Ymd").".log";
            $this->oLog->set_filename_target($sFileName);
        }
    }
    
    private function is_cofigured()
    {
        $isConfigured = ($this->sServer && $this->sDBName);
        $isConfigured &= ($this->sUserName && ($this->sPassword || $this->sPassword===""));
        return $isConfigured;
    }//is_cofigured
   
    /**
    * Este es el pseudo constructor singleton
    * Comprueba si la variable privada $_oSelf tiene un objeto
    * de esta misma clase, sino lo tiene lo crea y lo guarda
    * @return ComponentDatabase
    */
    public static function get_instance($sServer="",$sDbName="",$sDbUser="",$sDbPassw="",$sDbType="mysql")
    {
        //bug(self::$oSelf);die;
        if(!self::$oSelf instanceof self)
        {    
            self::$oSelf = new self($sServer,$sDbName,$sDbUser,$sDbPassw,$sDbType);
            //bug(self::$oSelf,"self database");
            //self::$oSelf->querytimer_on();
        }    
        return self::$oSelf;
    }

    //=================== CONECTAR ===========================
    private function connect_mysql()
    {
        //comprueba que todos los parametros de conexión se hayan configurado correctamente
        if(!$this->is_cofigured())
        {
            $this->add_error("No db configured properly");
            return FALSE;
        }        
        
//        pr($this->oLink->thread_id,"this.olink");
//        if(!$this->oLink->thread_id)
        $this->oLink = mysqli_connect
        (
            $this->sServer,
            $this->sUserName,
            $this->sPassword
        );
        //pr(mysqli_stat($this->oLink),"this.olinkopen.stat?");
        
        if(mysqli_connect_errno())
        {
            $this->oLink = NULL;
            $sMessage = "ERROR 0001: No se pudo conectar con la base de datos \"$this->sDBName\",errno".mysqli_connect_errno();
            $this->add_error($sMessage);
            return FALSE;
        }

        $isExisteBD = mysqli_select_db($this->oLink,$this->sDBName);
        //si no se pudo encontrar esa BD lanza un error
        if(!$isExisteBD)
        {
            //mysqli_close($this->oLink);
            $sMessage = "ERROR 0002: La base de datos \"$this->sDBName\" ";
            $this->add_error($sMessage);
            return FALSE;
        }
        //Hay base de datos y se conectó
        else
        {
            //$this->arMessages["linkid:{$this->oLink->thread_id}"] = "Conexión realizada con la bd: \"$this->sDBName\"";  
            mysqli_set_charset($this->oLink,"utf8");
        }
        //bug($this,"this database");
        return TRUE;
    }
   
    private function connect_mssql()
    {
        //comprueba que todos los parametros de conexión se hayan configurado correctamente
        if(!$this->is_cofigured())
        {
            $this->add_error("No db configured properly");
            return FALSE;
        }
        
        $this->oLink = mssql_connect
        (
            $this->sServer
            ,$this->sUserName
            ,$this->sPassword
            //,TRUE
        );

        //bug($this->oLinkId,"connect_mssql");
        if(!is_resource($this->oLink))
        {
            $this->oLink = NULL;
            $sMessage = "ERROR 0003: DB not found! db: $this->sDBName in server: $this->sServer";
            $this->add_error($sMessage);
            return FALSE;
        }

        $isExisteBD  = mssql_select_db($this->sDBName,$this->oLink);
        if(!$isExisteBD)
        {
            mssql_close($this->oLink);
            $sMessage = "ERROR 0004: DB \"$this->sDBName\" does not exist! ";
            $this->add_error($sMessage);
            return FALSE;
        }
        //Hay base de datos y se conectó
        else
        {
            $this->arMessages[] = "DB connection \"($this->sDBType) $this->sDBName linkid: $this->oLink \" ";//.var_export($oConnect,TRUE);  
        }
        return TRUE;
    }
   
    public function connect()
    {
        $isConnected = FALSE;
        switch($this->sDBType)
        {
            case "mysql":
                //bug("mysql");die;
                $isConnected = $this->connect_mysql();
            break;
        
            case "mssql":
                $isConnected = $this->connect_mssql();
            break;
        
            default:
            break;
        }
        return $isConnected;
    }
    //=================== FIN CONECTAR ===========================
   
    //==================== QUERY==================================
    private function query_mysql($sSQL)
    {
        //siempre se abre ya que con cada consulta se cierra
        if($this->connect())
        {
            try
            {
                $arRows = array();
                //$oResult: lectura ok=>object,error=>FALSE,escritura ok=>TRUE
                $oResult = mysqli_query($this->oLink,$sSQL);

                if($oResult!=FALSE)
                {  
                    $this->iAffectedRows = mysqli_affected_rows($this->oLink); 
                    if($oResult!==TRUE)
                    {
                        while($arRow_i = mysqli_fetch_array($oResult,MYSQLI_ASSOC))
                            $arRows[] = $arRow_i;
                        mysqli_free_result($oResult);
                    }
                }
                else
                {
                    $sMessage = "ERROR IN SQL: $sSQL";
                    $this->add_error($sMessage);
                    $arRows = -1;
                }
                return $arRows;
            }
            catch(Exception $e)
            {
                $sMessage = "ERROR 0005 SQL: $sSQL, $e ";
                $this->add_error($sMessage);
                return -1;
            }
        }
        else
            $this->add_error("mysql linkid: $this->oLinkId DB conection failed!");
    }//query_mysql
    
    private function query_mssql($sSQL)
    {
        //bug($this->oLinkId,"linkid");
        if($this->connect())
        {
            $arRows = array();
            try
            {
                //errorson();
                $oQuery = mssql_query($sSQL,$this->oLink);
                if($oQuery!=FALSE)
                {
                    $this->iAffectedRows = mssql_rows_affected($this->oLink); 
                    while($arRow_i = mssql_fetch_array($oQuery, MSSQL_ASSOC))
                    {   
                        //$this->log_error($arRow_i);
                        //codificacion bd: Modern_Spanish_CI_AS  SELECT DATABASEPROPERTYEX('theframework', 'collation') 
                        //var_dump(mb_detect_encoding($arRow_i["field_name"]),$arRow_i["field_name"]);//die; //esto devuelve ASCII                        
                        foreach($arRow_i as $sFieldName=>$sValue)
                            $arRow_i[$sFieldName] = $this->get_utf8_encoded($sValue);
                        
                        $arRows[] = $arRow_i;
                    }
                    mssql_free_result($oQuery);
                    mssql_close($this->oLink);                    
                }
                else
                {
                    $sMessage  = "SQL instruction with errors! ".mssql_get_last_message()."\n";
                    $sMessage .= "SQL = $sSQL";
                    $this->add_error($sMessage);
                    return FALSE;
                }            
                return $arRows;
            }
            catch(Exception $e)
            {
                $sMessage = "ERROR 0006 SQL: $sSQL, $e ";
                $this->add_error($sMessage);
                return -1;
            }
        }
        else
            $this->add_error("mysql linkid: $this->oLinkId DB conection failed!");
    }//query_mssql
   
    public function query($sSQL)
    {
        //$this->isTimeCapture = 1;
        if($this->isTimeCapture) $this->querytimer_on();
        $arRows = array();
        switch( $this->sDBType)
        {
            case "mysql":
                $arRows = $this->query_mysql($sSQL);
            break;
            case "mssql":
                $arRows = $this->query_mssql($sSQL);
            default:
            break;
        }        
        if($this->isTimeCapture) $this->querytimer_off();
        //bug($this->fQueryTime,"$sSQL");
        if((TFW_DEBUG_ISON || TFW_DEBUG_ISREMOTE) && class_exists("ComponentDebug"))
        {
            $sSQL = str_replace("\n"," ",$sSQL);
            if(strstr($sSQL,"UPDATE ")||strstr($sSQL,"DELETE FROM ")||strstr($sSQL,"INSERT INTO "))
            {
                if(!isset($_SESSION["componentdebug"]))
                    $_SESSION["componentdebug"] = array();
                $_SESSION["componentdebug"][]["sql"] = $sSQL;
                $iLastKey = array_keys($_SESSION["componentdebug"]);
                $iLastKey = end($iLastKey);
                $_SESSION["componentdebug"][$iLastKey]["count"] = $this->iAffectedRows;
                $_SESSION["componentdebug"][$iLastKey]["time"] = $this->fQueryTime;
            }
            $iThread = "";
            if(is_object($this->oLink))
                $iThread = $this->oLink->thread_id;
            ComponentDebug::set_sql($sSQL,$this->iAffectedRows,$this->fQueryTime." link:{$iThread}, db:$this->sDBName, dbtype:$this->sDBType");
        }//if TFW_DEBUG_x && classexists componentdebug
        $this->disconnect();
        return $arRows;
    }
    //==================== FIN QUERY ================================
   
    public function disconnect()
    {
        if($this->oLink)
        {
            if($this->sDBType=="mssql")
                mssql_close($this->oLink);
            elseif($this->sDBType=="mysql")
            {
                mysqli_close($this->oLink);
                $this->oLink = NULL;
            }
        }
    }
   
// <editor-fold defaultstate="collapsed" desc="QUERY OBJECT">
    private function query_object_mysql($sSQL)
    {
        //bug($sSQL,"query_object_mysql");
        try
        {
            $arRows = array();
            $oQuery = mysqli_query($this->oLink,$sSQL);
            while($arRow_i = mysqli_fetch_object($oQuery))
                $arRows[] = $arRow_i;

            return $arRows;
        }
        catch(Exception $e)
        {
            $this->add_error("ERROR 0011 SQL: $sSQL, $e ");
            return -1;
        }
    }  
    private function query_object_mssql($sSQL)
    {
        try
        {
            $arRows = array();
            //TODO comprobar lo que devuelve _query
            $oQuery = mssql_query($sSQL, $this->oLink);
            while($arRow_i = mssql_fetch_object($oQuery))
                $arRows[] = $arRow_i;

            return $arRows;
        }
        catch(Exception $e)
        {
            $this->add_error("ERROR 0012 SQL: $sSQL, $e ");
            return -1;
        }
    }  
    public function query_object($sSQL)
    {
        $arRows = array();
        switch ($this->sDBType)
        {
            case "mysql":
                $arRows = $this->query_object_mysql($sSQL);
            break;
            case "mssql":
                $arRows = $this->query_object_mssql($sSQL);
            default:
            break;
        }
        return $arRows;    
    }    
// </editor-fold>    

    private function querytimer_on()
    {
        list($fMiliSec, $fSec) = explode(" ", microtime());
        $this->fStartTime = ((float)$fSec + (float)$fMiliSec);
    }
    
    private function querytimer_off()
    {
        list($fMiliSec, $fSec) = explode(" ", microtime());
        $this->fEndTime = ((float)$fSec + (float)$fMiliSec);
        $this->fQueryTime = $this->fEndTime-$this->fStartTime;
    }
    
    private function log_error($sContent)
    {
        if(is_object($this->oLog))
        {
            if(!is_string($sContent))
                $sContent = var_export($sContent,1);
            $sContent = "[".date("H:i:s")."] $sContent";
            //$sContent .= var_export($this,TRUE);
            $this->oLog->add_content($sContent);
        }
    }
    
    //=======================================================
    //http://www.joelonsoftware.com/articles/Unicode.html
    //  19/04/2014
    //Resumen: 
    //  1 - ASCII codificación 2^7  [0 - 127] válido para idioma ingles. Tiene más caracteres que ANSI. Los puntos de codigo (ejemplo:10FFF(hex)) son fijos
    //  2 - ANSI codificacion 2^8 mantiene la codificación como ASCII de [0-127] de [128-255] Se definen páginas de códigos ejemplo Arabe,Griego. Los puntos de código varian
    //  3 - DBCS parche para ANSI para idiomas con mas caracteres que los 255, ej: chino Hace que algunos caracteres se hagan con dos bits
    //  4 - UTF-16 2^16 65536 caracteres
    //  5 - UTF-8 Es una codificacion estandard reducida que ahorra en procesador y cubre casi todos los idiomas
    //      -variantes: UTF-7, UCS-4
    //      -variantes menores por internacionalizacion: windows-1252,iso-8859-1=Latin-1. 
    //          En estas no podras guardar letras hebreas o rusas por ejemplo
    //      
    //  El problema surge si se han guardado caracteres que existén en UTF y no tienen equivalente en una codificación de menor juego. Entonces ahí aparece
    //  la marca ?
    //  Ejemplo actual: 
    //      Tengo la codificacion de la bd en Modern_Spanish_CI_AS (ASCII) si he guardado caracteres no ingleses ñ,ó..
    //      Cuando sube a php espero una codificación UTF8. Para los caracteres anglos no hay problema porque el "code point U+n1n2n3n4" es el mismo en las
    //      dos codificaciones. 
    //      Los castellanos hay que traducirlos a su equivalente UTF8 este es el motivo de los metodos abajo expuestos
    //=======================================================
    
    protected function get_utf8_encoded($string) 
    {
        $sCodingType = mb_detect_encoding($string);
        //$sCodingType = mb_detect_encoding($string,"UTF-8,ISO-8859-1,ISO-8859-15,ASCII",TRUE);
        if($sCodingType!="UTF-8")
            $string = utf8_encode($string);
            //mb_convert_encoding($string,"UTF-8",$sCodingType);
        //pr($sCodingType);
        //mb_convert_encoding($string,"UTF-8",$sCodingType);
        return $string; 
    }

    protected function get_iso_encoded($string) 
    {
        //$sCodingType = mb_detect_encoding($string,"UTF-8,ISO-8859-1,ISO-8859-15",TRUE);
        $sCodingType = mb_detect_encoding($string,"UTF-8,ISO-8859,ISO-8859-15,ASCII",TRUE);
        return mb_convert_encoding($string,"ISO-8859-1",$sCodingType);
    }    

    //==================================
    //             GETS
    //==================================
    //private function get_server_name(){return $this->sServer;}
    public function get_user_name(){return $this->sUserName;}
    //private function get_password(){return $this->sPassword;}
    public function get_error_message(){return implode(". ",$this->arMessages);}
    public function get_dbname(){return $this->sDBName;}
    //private function get_link_id(){return $this->oLinkId;}        
    public function get_type(){return $this->sDBType;}
    public function is_error(){return $this->isError;}
    public function get_affected_rows(){ return $this->iAffectedRows;}    
    public function get_query_time(){return $this->fQueryTime;}
    
    //==================================
    //             SETS
    //==================================
    private function add_message($sMessage,$sCode=NULL)
    {
        if($sCode)
            $this->arMessages[$sCode] = $sMessage;
        else
            $this->arMessages[] = $sMessage;
    }
    
    private function add_error($sMessage,$sCode=NULL)
    {
        $this->iAffectedRows = -1;
        $this->isError = TRUE;
        if($sCode)
            $this->arMessages[$sCode] = $sMessage;
        else
            $this->arMessages[] = $sMessage;
        $this->log_error($sMessage);        
    }
    
    public function set_timecapture($isOn=TRUE){$this->isTimeCapture=$isOn;}
}//ComponentDatabase