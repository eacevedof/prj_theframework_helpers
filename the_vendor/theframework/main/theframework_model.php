<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Main\TheFrameworkModel
 * @file theframework_model.php
 * @version 1.0.0
 * @date 08-10-2017 (SPAIN)
 * @observations:
 * @requires:
 */
namespace TheFramework\Main;

use TheFramework\Components\ComponentFile;

class TheFrameworkModel extends TheFramework
{
    protected static $arDbs = array();
    /**
     * @var ComponentDatabase
     */
    protected $oDB;

    /**
     *
     * @var ComponentQuery 
     */
    protected $oQuery;
    
    protected $_top;
    protected $_table_name;
    protected $_table_name_lang;
    //Plataforma desde donde se ha iniciado la sesion
    /*
    1 - BY USER ON DB (1)
    2 - DTS (2)
    3 - BACKOFFICE (3)
    4 - MOVIL DEVICE (4)
    */
    protected $_platform;
        
    //DEFINITION SYSTEM FIELDS
    protected $_processflag; //varchar(5)
    protected $_insert_platform; //varchar(3)
    protected $_insert_user; //varchar(15)
    protected $_insert_date; //varchar(14)
    
    protected $_update_platform; //varchar(3)
    protected $_update_user; //varchar(15)
    protected $_update_date; //varchar(14)
    
    protected $_delete_platform; //varchar(3)
    protected $_delete_user; //varchar(15)
    protected $_delete_date; //varchar(14)
    
    protected $_cru_csvnote; //varchar(500)
    protected $_is_enabled; //varchar(3)
    protected $_is_erpsent; //varchar(3) 
    protected $_code_erp; //varchar(15)
    protected $_description; //varchar(200)
    //END DEFINITION SYSTEM FIELDS
    
    protected $_i;  //int(4)
    protected $_id; //int(4) | numeric(18,0)
    //fin campos fisicos
    
    //Opcionales. Existen en tablas de traduccion
    protected $_id_language;
    protected $_id_source;
    protected $_description_lang;
    
    protected $iLastInsertId;
    protected $iSessionUserId; //Id por defecto del usuario en session. Usa $_SESSION["tfw_user_identificator"];
    protected $arFieldsDefinition;//array tipo (nombre=>array(tipo=>,length=>),nombre2=>array(top=>val2,length=>len2),...
    protected $arFieldsDb; //array existing fields in db.
    protected $isLanguage; //Si se habilita hace join con la tabla de traducción
    
    /**
     * @var array array(thistable.fieldname_alias=>join_table.field)
     */
    protected $arFieldsMappingExtra = array();
    
    /**
     * String con dampos personalizados que se utilizarán para obtener los datos finales a mostrar en un listado
     * @var string Lista de pares table.fieldname... separados por coma. 
     */
    protected $sSELECTfields;
    protected $sSELECTfieldsId;
    
    //private $_sysdates = array("insert_date","update_date","delete_date");
    private $arNumericTypes = array("int","real","float","numeric","decimal","smallint");
    private $arReservedWord = array("mssql"=>array(),"mysql"=>array("show","date","type"));
    
    protected $arPkDb = array("id");
    protected $arPkApp = array();
    protected $arPkFields = array("id");
    protected $isPkAuto = TRUE;
    protected $isInTable;
    
    protected $arFieldsDateTime = array();//14
    protected $arFieldsDate = array();//8
    protected $arFieldsTime4 = array();
    protected $arFieldsTime6 = array();
    protected $arExtras = array();

    //ERROR CAPTURE
    protected $isDebug;
    protected $isError;
    protected $arErrorMessages = array();
    protected $arMessage = array();
    protected $arErrorValtypes = array();

    //PAGINACION
    protected $_list_url = "";
    protected $_num_items_per_page = 25;
    protected $_list_page = 0;
    protected $_list_num_pages = 0;
    protected $_list_arPages = array();
    protected $_list_total_regs = 0;
    
    //LOGS
    protected $_log_insert = FALSE;
    protected $_log_select = FALSE;
    protected $_log_update = FALSE;
    protected $_log_delete = FALSE;
    
    protected $_path_log_insert;
    protected $_path_log_select;
    protected $_path_log_update;
    protected $_path_log_delete;

    //ORDERBY
    protected $_order_fields;
    protected $_order_types;
    protected $_order_by;
    
    //FILTERS
    protected $_select_user;
    protected $arFilters;
    protected $arDescConfig;
    protected $arHierarchyViews;
    
    protected $arInsUpdExclude = array();
    protected $isFieldsDefSession = TRUE;
    
    //SQL PRINCIPAL. En caso de tener que personalizar las queries del listado
    //por joins con otras tablas se puede usar esta variable.
    protected $sSQL;
    
    public function __construct($table_name=NULL,$iDb=0)
    {
        //carga la información del navegador. isConsoleCalled, sClientBrowser y oLog,isPermaLink
        parent::__construct();        
//        $this->oDB = self::$arDbs[$iDb];
//        //bug($this->oDB);die;
//        if($table_name!==NULL) $this->_table_name = $table_name;
//        $this->_table_name_lang = $this->_table_name."_lang";
//        //Si se va a mostrar un listado
//        //si se va a escribir. Update, Insert, Delete
//        $this->oQuery = new ComponentQuery($table_name);
//        $this->oQuery->set_db_type($this->oDB->get_type());
//        
//        //Para que haga un select *
//        //$this->sSELECTfields = "*";  En cada funcion select se renombra
//        $this->arHierarchyViews["seller"] = array("view"=>"vbase_hieruser_seller","fieldname"=>"id_seller");//id_user,id_seller
//        $this->arHierarchyViews["customer"] = array("view"=>"vbase_hieruser_customer","fieldname"=>"id_customer");//id_user,id_customer
//        $this->arHierarchyViews["userchild"] = array("view"=>"vbase_hieruser_userchild","fieldname"=>"id_user_child");//id_user, id_user_child
//        if($this->is_db_mysql())
//        {
//            $this->arHierarchyViews["seller"] = array("view"=>"get_vbase_hieruser_seller","fieldname"=>"id_seller");//id_user,id_seller
//            $this->arHierarchyViews["customer"] = array("view"=>"get_vbase_hieruser_customer","fieldname"=>"id_customer");//id_user,id_customer
//            $this->arHierarchyViews["userchild"] = array("view"=>"get_vbase_hieruser_userchild","fieldname"=>"id_user_child");//id_user, id_user_child            
//        }
//        
//        if(isset($_SESSION["tfw_user_identificator"])) $this->iSessionUserId = $_SESSION["tfw_user_identificator"];
//        if(isset($_SESSION["tfw_user_idlanguage"])) $this->_id_language = $_SESSION["tfw_user_idlanguage"];
//        $this->_path_log_insert = TFW_PATH_FOLDER_LOGDS."queries/insert";
//        $this->_path_log_select = TFW_PATH_FOLDER_LOGDS."queries/select";
//        $this->_path_log_update = TFW_PATH_FOLDER_LOGDS."queries/update";
//        $this->_path_log_delete = TFW_PATH_FOLDER_LOGDS."queries/delete";
//        
//        //bug($this->isFieldsDefSession,"tfwmodel");
//        //antes de llamar a fields_definition se necesita definir los path_logs
//        //$this->arFieldsDefinition se carga con su load desde base de datos
//        $this->load_fields_definition();
    }//__construct
    
    private function load_fields_definition()
    {
        $this->arFieldsDb = [];
        $this->arFieldsDefinition = [];
        //bug($this->oDB,"odb load_fields_definition");
        if($this->is_db_mssql())
            $sSQL = "/*mssql.load_fields_definition*/
            SELECT LOWER(cols.name) AS field_name
            ,types.name AS field_type
            ,CASE types.name
                WHEN 'text' THEN 1000000
                ELSE cols.Length
            END AS field_length
            FROM syscolumns AS cols
            INNER JOIN systypes AS types
            ON cols.xtype=types.xtype
            INNER JOIN sysobjects AS tables
            ON tables.id=cols.id
            AND tables.name = '$this->_table_name'
            ";
        else//mysql
            $sSQL = 
            "/*mysql.load_fields_definition*/
            SELECT LOWER(column_name) AS field_name
            ,LOWER(DATA_TYPE) AS field_type
            ,CASE LOWER(DATA_TYPE) 
            WHEN 'datetime' THEN
                19
            ELSE
                character_maximum_length 
            END AS field_length 
            FROM information_schema.columns 
            WHERE table_name='$this->_table_name'
            AND table_schema='".TFW_DB_NAME."'
            ORDER BY ORDINAL_POSITION ASC";
        
        //recupera de cache según isFieldsDefSession
        $arRows = $this->handle_fieldsdefinition($this->_table_name,$sSQL);
        
        foreach($arRows as $arRow)
        {
            $this->arFieldsDb[] = $arRow["field_name"];
            $this->arFieldsDefinition[$arRow["field_name"]]=array($arRow["field_type"]=>$arRow["field_length"]);
        }
        //bug($this->arFieldsDefinition);
    }//load_fields_definition
    
    private function handle_fieldsdefinition($sTableName,$sSQL)
    {
        $arFields = [];
        if($this->isFieldsDefSession)
        {
            //comprobar si existe en session
            if(isset($_SESSION["tfw_fieldsdefinition"][$sTableName]))
            {
                //pr("tfw_fields $sTableName");
                $arFields = $_SESSION["tfw_fieldsdefinition"][$sTableName];
                if(!(is_array($arFields) && $arFields))
                    $arFields = [];
            }
        }
        else
        {
            unset($_SESSION["tfw_fieldsdefinition"][$sTableName]);
        }
        
        //si no se ha recuperado de session
        if(!$arFields)
        {
            $arFields = $this->query($sSQL);
            $_SESSION["tfw_fieldsdefinition"][$sTableName] = $arFields;
        }
        return $arFields;
    }//handle_fieldsdefinition
    
    protected function is_table($sTableName)
    {
        $sSQL = "/*mssql.is_table*/
        SELECT sysobjects.id 
        FROM sysobjects 
        WHERE name = '$sTableName'";
        
        if($this->is_db_mysql())
        {    
            $sDB = $this->oDB->get_type();
            $sSQL = "/*mysql.is_table*/
            SELECT table_name
            FROM information_schema.columns
            WHERE table_schema='$sDB'
            AND table_name='$sTableName'
            ";
        }
        $arRow = $this->query($sSQL,1,1);
        return (boolean)$arRow;
    }

    /**
     * 
     * @param int $idUser if Null then $this->_select_user is used
     * @param string $sType NULL SQL Final, oquery,array,sqlin 
     * @param int $iToUp Direccion de jerarquia 0:Childs, 1:Parents
     * @return ComponentQuery|array|string oQuery,arIds,sSQLIn,sSQL Final
     */
    protected function get_vbase_hiergroup($idUser=NULL,$sType=NULL,$iToUp=0)
    {
        if(!$idUser) $idUser=$this->_select_user;
        //JERARQUIA PARA MYSQL equivalente a la vista recursiva vbase_hiergroup de MSSQL
        //puede que no exista idUser para los módulos que son publicos

            //recupero todos los grupos de usuarios con sus padres
            $oQuery = new ComponentQuery("base_user_group");
            $oQuery->set_comment("get_vbase_hiergroup(1) - Recupero todos los grupos");
            $oQuery->add_fields("id");
            $oQuery->add_fields("id_group_parent AS id_parent");
            $oQuery->add_and("delete_date IS NULL");
            $oQuery->add_and("is_enabled=1");
            $oQuery->add_orderby("1,2");
            $sSQL = $oQuery->get_select();
            //bug($sSQL);
            $arGroupsAll = $this->query($sSQL);
            //bug($arGroupsAll);

            //recupero los grupos que le pertenecen al usuario
            $oQuery = new ComponentQuery("base_users_groups");
            $oQuery->set_comment("get_vbase_hiergroup(2) - Recupero los grupos directos del usuario $idUser");
            $oQuery->add_fields("id_user_group");
            $oQuery->add_and("delete_date IS NULL");
            $oQuery->add_and("is_enabled=1");
            $oQuery->add_and("id_user=$idUser");
            $oQuery->add_orderby("1");
            $sSQL = $oQuery->get_select();
            //bug($sSQL);
            $arUserGroup = $this->query($sSQL);
            $arUserGroup = $this->get_column_values($arUserGroup,"id_user_group");

            //bug($arUserGroup);
            //Grupos a los que pertenecera por jerarquia vertical
            $arHierGroup = array();
            //para cada grupo al que pertenece recupero sus hijos
            foreach($arUserGroup as $idGroup)
                $this->get_vhierarchy($idGroup,$arGroupsAll,$arHierGroup,$iToUp);

            //bug($arUserGroup);die;
            //si se desea la jerarquia en un array
            if($sType=="array") return $arHierGroup;

            $sSQLIn = $this->build_sqlin($arHierGroup,1);
            //si se desea en formato en sqlin
            if($sType=="sqlin") return $sSQLIn;

            //SQL FINAL Los grupos sobre los que tiene visibilidad el usuario
            $oQuery = new ComponentQuery("base_user_group");
            $oQuery->set_comment("-- get_vbase_hiergroup(3) - Los grupos finales a los que pertenece el usuario por jerarquia vertical");
            $oQuery->add_fields("DISTINCT id AS id_user_group");
            $oQuery->add_and("id IN $sSQLIn");
            //si se desea en un objeto
            if($sType=="oquery") return $oQuery;

            //SELECT id AS id_user_group FROM base_user_group WHERE id in ..
            return $oQuery->get_select();

    }//get_vbase_hiergroup
    
    /**
     * 
     * @param int $idUser if Null then $this->_select_user is used
     * @param string $sType NULL SQL Final, oquery,array,sqlin 
     * @return ComponentQuery|array|string oQuery,arIds,sSQLIn,sSQL Final
     */
    protected function get_vbase_hieruser_userchild($idUser=NULL,$sType=NULL)
    {
        if(!$idUser) $idUser=$this->_select_user;
        //JERARQUIA PARA MYSQL equivalente a la vista recursiva vbase_hieruser_userchild de MSSQL
        $sSQLHierGroups = $this->get_vbase_hiergroup($idUser);
        
        //recupero todos los usuarios que están en los grupos sobre los que tiene visibilidad el usuario
        $oQuery = new ComponentQuery("base_users_groups AS usrgrp");
        $oQuery->set_comment("get_vbase_hieruser_userchild(1) - Recupero los usuarios de los grupos");
        $oQuery->add_fields("usrgrp.id_user");
        $oQuery->add_joins("INNER JOIN ($sSQLHierGroups)AS grp ON grp.id_user_group = usrgrp.id_user_group");
        $oQuery->add_and("usrgrp.delete_date IS NULL");
        $oQuery->add_and("usrgrp.is_enabled=1");
        $sSQL = $oQuery->get_select();
        $arUsersChild = $this->query($sSQL);
        $arUsersChild = $this->get_column_values($arUsersChild,"id_user");
        if($sType=="array") return $arUsersChild;
        
        $sSQLIn = $this->build_sqlin($arUsersChild,1);
        if($sType=="sqlin") return $sSQLIn;
        
        $oQuery = new ComponentQuery("base_user");
        $oQuery->set_comment("get_vbase_hieruser_userchild(2) - Recupero los usuarios");
        $oQuery->add_fields("id AS id_user_child");
        $oQuery->add_and("base_user.delete_date IS NULL");
        $oQuery->add_and("base_user.is_enabled=1");        
        $oQuery->add_and("id IN $sSQLIn");
        if($sType=="oquery") return $oQuery;
        
        //SELECT id AS id_user_child FROM base_user WHERE id IN ..
        return $oQuery->get_select();
    }//get_vbase_hieruser_userchild
    
    /**
     * 
     * @param int $idUser if NULL then $this->id is used
     * @param string $sType NULL SQL Final, oquery,array,sqlin 
     * @return ComponentQuery|array|string oQuery,arIds,sSQLIn,sSQL Final
     */
    protected function get_vbase_hieruser_seller($idUser=NULL,$sType=NULL)
    {
        //JERARQUIA PARA MYSQL equivalente a la vista recursiva vbase_hieruser_seller de MSSQL
        if(!$idUser) $idUser=$this->_select_user;
        
        $oQuery = new ComponentQuery("app_seller");
        $oQuery->set_comment("get_vbase_hieruser_seller(1)");
        $oQuery->add_fields("id");
        $oQuery->add_fields("id_superior AS id_parent");
        $oQuery->add_and("delete_date IS NULL");
        $oQuery->add_and("is_enabled=1");
        $oQuery->add_orderby("1,2");
        
        $sSQL = $oQuery->get_select();
        $arSellerAll = $this->query($sSQL);
        
        //recupero todos los grupos hijo del usuario
        //tabla base_user_group con alias id AS id_user_group
        $sSQLHierGroup = $this->get_vbase_hiergroup($idUser);
        
        //Recupero todos los vendedores de los usuarios que estan en los grupos anteriores
        $sSQL = "-- get_vbase_hieruser_seller(2)
                SELECT usrsel.id_seller
                FROM base_users_sellers AS usrsel
                INNER JOIN
                (
                    SELECT DISTINCT usrgrp.id_user
                    FROM base_users_groups AS usrgrp
                    INNER JOIN 
                    (
                        $sSQLHierGroup
                    ) AS grps
                    ON usrgrp.id_user_group = grps.id_user_group
                ) AS usr
                ON usrsel.id_user=usr.id_user
                ORDER BY 1 ASC
                ";
        $arSellers = $this->query($sSQL);
        
        //Vendedores a los que tendrá acceso por jerarquia vertical
        $arSellerChild = array();
        //para cada vendedor se extraen sus hijos
        foreach($arSellers as $idSeller)
            $this->get_vhierarchy($idSeller,$arSellerAll,$arSellerChild);
        
        //bug($arSellerChild);die;
        $arSellerChild = $this->get_column_values($arSellerChild,"id_seller");
        
        if($sType=="array") return $arSellerChild;
        
        $sSQLIn = $this->build_sqlin($arSellerChild,1);
        if($sType=="sqlin") return $sSQLIn;

        //SQL FINAL Los grupos sobre los que tiene visibilidad el usuario
        $oQuery = new ComponentQuery("app_seller");
        $oQuery->set_comment("get_vbase_hieruser_seller(3) - Los vendedores finales a los que se tendrá acceso");
        $oQuery->add_fields("id AS id_seller");
        $oQuery->add_and("id IN $sSQLIn");
        //si se desea en un objeto
        if($sType=="oquery") return $oQuery;

        //SELET id as id_seler FROM app_seller WHERE id IN ...
        return $oQuery->get_select();
    }//get_vbase_hieruser_seller

    /**
     * 
     * @param int $idUser if NULL then $this->_select_user is used
     * @param string $sType NULL SQL Final, oquery,array,sqlin 
     * @return ComponentQuery|array|string oQuery,arIds,sSQLIn,sSQL Final
     */
    protected function get_vbase_hieruser_customer($idUser=NULL,$sType=NULL)
    {
        //JERARQUIA PARA MYSQL equivalente a la vista recursiva vbase_hieruser_customer de MSSQL
        if(!$idUser) $idUser=$this->_select_user;
        
        //vendedores del usuario en subconsulta
        $sSQLUserSeller = $this->get_vbase_hieruser_seller($idUser);
        //SQL FINAL Los clientes de los vendedores de los usuarios
        $oQuery = new ComponentQuery("app_customer AS cus");
        $oQuery->set_comment("get_vbase_hieruser_customer(1) - Los clientes de los vendedores del usuario");
        $oQuery->add_fields("cus.id AS id_customer ");
        //id AS id_seller
        $oQuery->add_joins("INNER JOIN ($sSQLUserSeller) AS sel 
                            ON cus.id_seller=sel.id_seller");
        $oQuery->add_and("cus.delete_date IS NULL");
        $oQuery->add_and("cus.is_enabled=1");
        if($sType=="oquery") return $oQuery;
        $sSQL = $oQuery->get_select();
        
        $arCustomers = $this->query($sSQL);
        $arCustomers = $this->get_column_values($arCustomers,"id_customer");
        if($sType=="array") return $arCustomers;
        
        $sSQLIn = $this->build_sqlin($arCustomers,1);
        if($sType=="sqlin") return $sSQLIn;
        
        //si se desea en un objeto
        if($sType=="oquery") return $oQuery;

        //Aqui podría haber hecho lo mismo que en las otras jerarquias. SELECT FROM app_customer WHERE id IN.. pero ese "in" al ser la tabla
        //de clientes seria muy grande y podría ralentizar notablemente la consulta
        
        //SELECT cus.id AS id_customer FROM app_customer AS cus INNER JOIN (..) AS sel ON cus.id_seller=sel.id_seller WHERE cus.delete_date IS NULL
        //AND cus.is_enabled=1
        return $sSQL;
    }//get_vbase_hieruser_customer
        
    public function get_picklist($useBlank=1,$notDeleted=1)
    {
        $arPicklist = array();
        if($useBlank) $arPicklist[""] = tr_main_none;
  
        $oQuery = new ComponentQuery($this->_table_name);
        $oQuery->set_comment("tfwmodel.get_picklist(useBlank=1,notDeleted=1)");
        $oQuery->set_fields("$this->_table_name.id");
        $oQuery->add_fields("$this->_table_name.description");
        $oQuery->set_where("($this->_table_name.is_enabled IS NULL OR $this->_table_name.is_enabled='1')");
        
        if($notDeleted) $oQuery->add_and("$this->_table_name.delete_date IS NULL");
        
        //recupero los atributos que tengan valores
        $arFilled = $this->get_filled_attribs();
        if($arFilled)
            $oQuery->add_and($this->build_and_condition($arFilled));
            
        if($this->is_defined_field("order_by"))
            $oQuery->add_orderby("$this->_table_name.order_by ASC");
        
        $oQuery->add_orderby("2 ASC");
        //bug($this->_table_name);bug($this->isLanguage,"islanguage"); bug($this->_id_language,"idlanguage");
        if($this->isLanguage && $this->_id_language)
        {
            $oQuery->set_fields("$this->_table_name.id");
            $oQuery->add_fields("lang.description AS description");
            $oQuery->add_joins("LEFT JOIN $this->_table_name_lang AS lang 
                                ON $this->_table_name.id = lang.id_source 
                                AND lang.id_language=$this->_id_language");
            if($this->is_defined_field("order_by"))
                $oQuery->set_orderby("$this->_table_name.order_by ASC");
            $oQuery->add_orderby("lang.description ASC");            
        }        
        $sSQL = $oQuery->get_select();
        //bug($sSQL);
        $arRows = $this->query($sSQL);
        foreach($arRows as $arRow)
            $arPicklist[$arRow["id"]] = $arRow["description"];

        return $arPicklist;
    }//get_picklist
    
    public function get_picklist_custom
    ($id="id",$description="description",$sSQLAnd="1=1",$sOrderBy=NULL,$useBlank=true)
    {
        $arPicklist = array();
        if($useBlank) $arPicklist[""] = tr_main_none;
        
        $oQuery = new ComponentQuery($this->_table_name);
        $oQuery->set_comment("tfwmodel.get_picklist_custom(id=id,description=description,sqland=1=1,orderby=description asc,useblank=true)");
        $oQuery->set_fields("$this->_table_name.$id AS id, $this->_table_name.$description AS description"); 
        //Tablas de otras bd
        if($this->is_defined_field("is_enabled"))
            $oQuery->add_and("($this->_table_name.is_enabled IS NULL OR $this->_table_name.is_enabled='1')");
        if($this->is_defined_field("delete_date"))
            $oQuery->add_and("$this->_table_name.delete_date IS NULL");
        
        //recupero los atributos que tengan valores
        $arFilled = $this->get_filled_attribs();
        if($arFilled)
            $oQuery->add_and($this->build_and_condition($arFilled));
        
        //TODO FURTHER if($notDeleted) $oQuery->add_and("delete_date IS NULL");
        if($sSQLAnd) $oQuery->add_and($sSQLAnd);

        if($sOrderBy)
        {
            $oQuery->add_orderby($sOrderBy);
        }    
        elseif($sOrderBy===NULL) 
        {
            if($this->is_defined_field("order_by"))
            {    
                $oQuery->add_orderby("$this->_table_name.order_by ASC");            
                $oQuery->add_orderby("$this->_table_name.description ASC"); 
            }
        }
        //else si viene vacio "" no aplica ningún order
        
        if($this->isLanguage && $this->_id_language)
        {
            $oQuery->set_fields("$this->_table_name.$id AS id");
            $oQuery->add_fields("lang.description AS description");
            $oQuery->add_joins("LEFT JOIN $this->_table_name_lang AS lang 
                                ON $this->_table_name.id = lang.id_source 
                                AND lang.id_language=$this->_id_language");
        }           
        
        $sSQL = $oQuery->get_select();
        //bug($sSQL,"get_picklist_custom");
        $arRows = $this->query($sSQL);
        foreach($arRows as $arRow)
            $arPicklist[$arRow["id"]] = $arRow["description"];

        return $arPicklist;
    }//get_picklist_custom    
    
    /**
     * Antes de llamar a este metodo se debe hacer un set de select_user
     * @param string $sView nombre de la vista a utilizar. "seller", "customer", "userchild"
     * @param string $sTableField Nombre del campo foreign en la tabla de la picklist
     * @param boolean $useBlank si se usa el primer item en blanco
     * @param boolean $notDeleted si solo se recupera los no borrados
     * @return array 
     */
    public function get_picklist_hierarchy($sView,$sTableField,$useBlank=1,$notDeleted=1)
    {
        $arPicklist = array();
        if($useBlank) $arPicklist[""] = tr_main_none;
        
        $oQuery = new ComponentQuery($this->_table_name);
        $oQuery->set_comment("tfwmodel.get_picklist_hierarchy(view,tablefield,useblank=1,notdeleted=1)");
        $oQuery->set_fields("$this->_table_name.id, $this->_table_name.description");
        if($this->_select_user && $sView && $sTableField)
        {    
            $oQuery->add_joins($this->build_userhierarchy_join($this->_select_user,$sView,$sTableField));
        }
        $oQuery->set_where("($this->_table_name.is_enabled IS NULL OR $this->_table_name.is_enabled='1')");
        if($notDeleted) $oQuery->add_and("$this->_table_name.delete_date IS NULL");
        
        //recupero los atributos que tengan valores
        $arFilled = $this->get_filled_attribs();
        if($arFilled)
            $oQuery->add_and($this->build_and_condition($arFilled));        
        
        $oQuery->set_orderby("2 ASC");
        $sSQL = $oQuery->get_select();
        
        $arRows = $this->query($sSQL);
        foreach($arRows as $arRow)
            $arPicklist[$arRow["id"]] = $arRow["description"];

        return $arPicklist;
    }//get_picklist_hierarchy

    /**
     * @deprecated 1.7.12 02/11/2015 
     * La tabla debe contar con campos: description,order_by,type
     * @param string $sType Group of items (fielname type in array_table)
     * @param boolean $useArrangeOrder Use order_by ASC
     * @param boolean $useBlank top white item ""=>""
     * @param boolean $notDeleted delete_date IS NULL
     * @return array Picklist type
     */
    public function get_picklist_by_type($sType,$useArrangeOrder=0,$useBlank=1,$notDeleted=1)
    {
        $arPicklist = array();
        if($useBlank) $arPicklist[""] = tr_main_none;

        $oQuery = new ComponentQuery($this->_table_name);
        $oQuery->set_comment("tfwmodel.get_picklist_by_type(type,useArrangeOrder=0,useBlank=1,notDeleted=1)");
        $oQuery->set_fields("$this->_table_name.id, $this->_table_name.description");        
        $oQuery->set_where("($this->_table_name.is_enabled IS NULL OR $this->_table_name.is_enabled='1')");
        if($notDeleted) $oQuery->add_and("$this->_table_name.delete_date IS NULL");
        $oQuery->add_and("$this->_table_name.type='$sType'");
        
        if($useArrangeOrder && $this->is_defined_field("order_by"))  
            $oQuery->add_orderby("$this->_table_name.order_by ASC");
        
        $oQuery->add_orderby("$this->_table_name.description ASC");
        
        if($this->isLanguage && $this->_id_language)
        {
            $oQuery->set_fields("$this->_table_name.id");
            $oQuery->add_fields("lang.description AS description");
            $oQuery->add_joins("LEFT JOIN $this->_table_name_lang AS lang 
                                ON $this->_table_name.id = lang.id_source 
                                AND lang.id_language=$this->_id_language");
            $oQuery->set_orderby();
            if($useArrangeOrder && $this->is_defined_field("order_by"))  
                $oQuery->add_orderby("$this->_table_name.order_by ASC");            
            $oQuery->add_orderby("lang.description ASC");
        }            
        
        $sSQL = $oQuery->get_select();
        
        $arRows = $this->query($sSQL);
        foreach($arRows as $arRow)
            $arPicklist[$arRow["id"]] = $arRow["description"];

        return $arPicklist;
    }//get_picklist_by_type

    protected function is_reserved($sDbType,$sFieldName)
    {
        $arReserved = $this->arReservedWord[$sDbType];
        return in_array($sFieldName,$arReserved);
    }
    
    protected function save_reserved_words($sFieldName)
    {
        if($this->is_reserved($this->get_db_type(),$sFieldName))
        {
            if($this->is_db_mssql()) $sFieldName = "[$sFieldName]";
            else $sFieldName = "`$sFieldName`";
        }
        return $sFieldName;
    }

    protected function check_intable($sType="insert")
    {
        $arPkFields = $this->arPkFields;
        foreach($arPkFields as $i=>$sFieldName)
            if($sFieldName=="id")unset($arPkFields[$i]);
        //quito el id autonumerico
        //para el insert, no llega un id puesto que este se autogenera con lo cual se comprueba el resto de claves
        //para el update, el id que viene no es una condicion and id=id_actual sino id!=id_actual
        unset($arPkFields["id"]);
        $oQuery = new ComponentQuery();
        $oQuery->set_fromtables($this->_table_name);
        $oQuery->set_comment("check_intable");
        $oQuery->set_fields("id");
        
        if($sType=="update")
        {
            $idCurrent = $this->get_attrib_value("id");
            $oQuery->add_where("id!=$idCurrent");
        }
        
        //si despues de quitar el autonumerico quedan claves se comprueban
        if($arPkFields)
        {
            foreach($arPkFields as $sFieldName)
            {
                $sFieldValue = $this->get_attrib_value($sFieldName);
                if(!$this->is_numeric_field($sFieldName))
                    $sFieldValue = $this->get_as_string_value($sFieldValue);
                $oQuery->add_where("$sFieldName=$sFieldValue");
            }
            $sSQL = $oQuery->get_select();
            $id = $this->query($sSQL,1,1);
            return $id;
        }
        return FALSE;
    }
    
    protected function check_valtypes($sType="fields")
    {
        if($sType=="pkkeys")
        {
            foreach($this->arPkFields as $sFieldName)
            {
                $sFieldValue = $this->get_attrib_value($sFieldName);
                if($sFieldValue!==NULL)
                    if($this->is_numeric_field($sFieldName))
                    {
                        if(!is_numeric($sFieldValue))
                        {
                            $this->arErrorValtypes[$sFieldName] = [
                                $this->get_field_type($sFieldName)=> $sFieldValue
                            ];
                            return FALSE;
                        }
                    }
            }          
        } 
        else
            foreach($this->arFieldsDefinition as $sFieldName=>$arTypeLen)
            {
                $sFieldType = array_keys($arTypeLen);
                $sFieldType = $sFieldType[0];
                //usa los metodos get publicos
                $sFieldValue = $this->get_attrib_value($sFieldName);
                //pr($sFieldName);var_dump($sFieldValue);
                //04/02/2017 añado comprobacion !== "" ya que si para un id_x numerico no obligatorio viene un vacio "" lo entenderia como 
                //error no numerico y deberia dejarlo pasar para guardarlo como NULL
                if($sFieldValue!==NULL && $sFieldValue!=="")
                {
                    if($this->is_numeric_field($sFieldName))
                        if(!is_numeric($sFieldValue))
                        {
                            $this->arErrorValtypes[$sFieldName] = [
                                $this->get_field_type($sFieldName)=> $sFieldValue
                            ];
                            return FALSE;
                        }
                }
            }
        return TRUE;
    }//check_valtypes

    protected function sqlclean($sString,$isNumeric=0)
    {
        if($this->is_db_mssql())
            return mssqlclean($sString,$isNumeric);
        return mysqlclean($sString,$isNumeric);
    }
    
    public function autoinsert()
    {
        //bug($this->arDescConfig);
        //bug($this->get_attrib_value("description"),"descvalue");
        if($this->arFieldsDefinition)
        {
            if($this->check_intable())
            {
                $this->isInTable = TRUE;
                $this->add_error(tr_main_error_reccord_exists);
            }
            elseif($this->check_valtypes())
            {
                $sSysDate = date("YmdHis");
                $arExclude = array("delete_date","delete_user","delete_platform"
                            ,"cru_csvnote","processflag");
                $arExclude = array_merge($arExclude,$this->arInsUpdExclude);
                //bug($arExclude,"exclude");die;
                if(!$this->_insert_date) $this->_insert_date = $sSysDate;
                if(!$this->_update_date) $this->_update_date = $sSysDate;
                if(!$this->_insert_user) $this->_insert_user = $this->iSessionUserId;
                if(!$this->_update_user) $this->_update_user = $this->iSessionUserId;
                $this->_insert_platform = $this->_platform;
                $this->_update_platform = $this->_insert_platform;
                $this->_is_erpsent = 0;

                $arFieldNames = array();
                $arFieldValues = [];
                //Recorre los campos y los guarda en formato nombre=>tipo
                //omitiendo los que son autid
                //bug($this->arFieldsDefinition,"die");
                //bug($this->arPkFields,"pks");bug($arExclude,"exclude");
                foreach($this->arFieldsDefinition as $sFieldName=>$arTypeLen)
                {
                    $sFieldValue = NULL;
                    if((in_array($sFieldName,$this->arPkFields) && $this->isPkAuto) || in_array($sFieldName,$arExclude))
                        continue;

                    if($sFieldName=="description" && $this->arDescConfig)
                        $sFieldValue = $this->build_description_field();

                    //bug($arTypeLen,"arTypelen");
                    $sFieldType = array_keys($arTypeLen);
                    //bug($sFieldType,"array_keys");
                    $sFieldType = $sFieldType[0];
                    $iFieldLen = $arTypeLen[$sFieldType];
                    //usa los metodos get publicos
                    if(!$sFieldValue)
                        $sFieldValue = $this->get_attrib_value($sFieldName);

                    if($sFieldValue===NULL)
                        continue;

                    //Guardo el nombre del campo
                    $arFieldNames[] = $this->save_reserved_words($sFieldName);

                    //Solo acorto a la longitud del campo si no es numerico
                    if(!in_array($sFieldType,$this->arNumericTypes))
                        $sFieldValue = substr($sFieldValue,0,$iFieldLen);
                    
                    if(in_array($sFieldType,$this->arNumericTypes))
                        $arFieldValues[] = $this->sqlclean($sFieldValue,1);
                    else
                        $arFieldValues[] = $this->get_as_string_value($this->sqlclean($sFieldValue));
                }
                //bug($this->_id,"id");
                //bug($arFieldNames,"fieldnames");
                //bug($arFieldValues,"fieldvalues");
                $this->oQuery = new ComponentQuery($this->_table_name);
                $this->oQuery->set_comment("autoinsert()");
                $this->oQuery->set_insertfields($arFieldNames);
                $this->oQuery->set_insertvalues($arFieldValues);
                $sSQL = $this->oQuery->get_insert();
                //bug($sSQL); die;
                $this->execute($sSQL);            
            }
            else
            {
                $this->log_error($this->arErrorValtypes,"autoinsert");
                $this->add_error(tr_main_error_fieldtype);
            }
        }
        else
        {
            $this->log_error("no fields found for $this->_table_name","autoinsert");
            $this->add_error(tr_main_error_fieldtype);            
        }
    }//autoinsert()

    public function autoupdate()
    {
        if($this->check_intable("update"))
        {
            $this->isInTable = TRUE;
            $this->add_error(tr_main_error_reccord_exists);
        }
        elseif($this->check_valtypes())
        {
            $sSysDate = date("YmdHis");
            $arExclude = array("insert_date","insert_user","insert_platform"
                        ,"delete_date","delete_user","delete_platform"
                        ,"cru_csvnote","processflag");
            $arExclude = array_merge($arExclude,$this->arInsUpdExclude);
            //$arExclude = array(); //no evito estos campos pq puede pasar que se haga un insert manual y posteriormente
            $this->_update_date = $sSysDate;
            $this->_update_user = $this->iSessionUserId;
            $this->_update_platform = $this->_platform;
            $this->_is_erpsent = 0;

            $arSet = array(); $arWhere = array();
            foreach($this->arFieldsDefinition as $sFieldName=>$arTypeLen)
            {
                $sFieldValue = NULL;
                //los campos clave no se actualizan ni los que se fuerza la exclusion
                if(in_array($sFieldName,$this->arPkFields) || in_array($sFieldName,$arExclude))
                    continue;

                //si es el campo description se carga el valor desde la configuracion
                if($sFieldName=="description" && $this->arDescConfig)
                    $sFieldValue = $this->build_description_field();

                //bugraw($arTypeLen,"0 - arTypelen");
                $sFieldType = array_keys($arTypeLen);
                $sFieldType = $sFieldType[0];
                $iFieldLen = $arTypeLen[$sFieldType];
                //usa los metodos get publicos

                //@TODO si no tiene valor es pq probablemente no era de descripcion (mal, esto hay que controlarlo)
                //se intenta recuperar su valor con su metodo propiedad
                if(!$sFieldValue)
                    $sFieldValue = $this->get_attrib_value($sFieldName);

                //bugraw("1 - $sFieldName=$sFieldValue");

                //si despues de todos estos intentos el valor sigue siendo nulo se omite
                if($sFieldValue===NULL)continue;

                //si se ha encontrado un valor se ajusta su longitud
                if(!in_array($sFieldType,$this->arNumericTypes))
                    $sFieldValue = substr($sFieldValue,0,$iFieldLen);
                //bugraw("2 ($iFieldLen) - $sFieldName=$sFieldValue");
                
                if(in_array($sFieldType,$this->arNumericTypes))
                    $sFieldValue = $this->sqlclean($sFieldValue,1);
                else
                    $sFieldValue = $this->get_as_string_value($this->sqlclean($sFieldValue));

                //bugraw("9 - $sFieldName=$sFieldValue");
                //Guardo el nombre del campo
                $sFieldName = $this->save_reserved_words($sFieldName);
                $arSet[] = "$sFieldName=$sFieldValue";
            }
            //bug($arSet);
            //$this->log_custom($arSet);
            foreach($this->arPkFields as $sFieldName)
                $arWhere[$sFieldName]=$this->get_attrib_value($sFieldName);

            $this->oQuery = new ComponentQuery($this->_table_name);
            $this->oQuery->set_comment("autoupdate()");
            //Para que no aplique condicion from despues de update
            $this->oQuery->set_fromtables(NULL);
            $this->oQuery->set_fieldandvalues($arSet);
            $this->oQuery->add_and($this->build_and_condition($arWhere));
            $sSQL = $this->oQuery->get_update();
            //bug($sSQL,"con objeto"); die;
            $this->execute($sSQL);
        }
        else
        {
            $this->log_error($this->arErrorValtypes,"autoupdate");
            $this->add_error(tr_main_error_fieldtype);
        }        
    }//autoupdate()
    
    /**
     * 
     * @param array $arAndCondition array(pk1=>value1,pk2=>value2...)
     */
    public function autodelete($arAndCondition=array())
    {
        if(!$arAndCondition)
        {
            if($this->check_valtypes("pkkeys"))
            {
                foreach($this->arPkFields as $sFieldName)
                {
                    $sFieldValue = $this->get_attrib_value($sFieldName);
                    if($sFieldValue!==NULL) 
                        $arAndCondition[$sFieldName] = $sFieldValue;
                }
            }
            else
            {
                $this->log_error($this->arErrorValtypes,"autodelete");
                $this->add_error(tr_main_error_fieldtype);
            }
        }

        if($arAndCondition && !$this->isError)
        {
            $this->oQuery = new ComponentQuery($this->_table_name);
            $this->oQuery->set_comment("autodelete()");
            $this->oQuery->add_and($this->build_and_condition($arAndCondition));
            $sSQLDelete = $this->oQuery->get_delete();
            $this->oQuery->set_fields("*");
            $sSQL = $this->oQuery->get_select();
            $arDelete = $this->query($sSQL);
            $this->log_custom($arDelete);
            $this->execute($sSQLDelete);
        }
    }//autodelete
        
    public function autoquarantine($arAndCondition=array())
    {
        $sSysDate = date("YmdHis");
        $this->_delete_date = $sSysDate;
        if(!$this->_delete_user) $this->_delete_user = $this->iSessionUserId;
        $this->_delete_platform = $this->_platform;
        $this->_is_erpsent = 0;
        
        if(!$arAndCondition)
            if($this->check_valtypes("pkkeys"))
            {
                foreach($this->arPkFields as $sFieldName)
                {
                    $sFieldValue = $this->get_attrib_value($sFieldName);
                    if($sFieldValue!==NULL) 
                        $arAndCondition[$sFieldName] = $sFieldValue;
                }
            }
            else
            {
                $this->log_error($this->arErrorValtypes,"autoquarantine");
                $this->add_error(tr_main_error_fieldtype);
            }

        if($arAndCondition && !$this->isError)
        {
            $this->oQuery = new ComponentQuery();
            $this->oQuery->set_comment("autoquarantine()");
            $this->oQuery->set_writetable($this->_table_name);
            $this->oQuery->add_fieldandvalue("delete_platform='$this->_delete_platform'");
            $this->oQuery->add_fieldandvalue("delete_date='$this->_delete_date'");
            $this->oQuery->add_fieldandvalue("delete_user=$this->_delete_user");
            $this->oQuery->add_fieldandvalue("is_erpsent=$this->_is_erpsent");
            $this->oQuery->add_and($this->build_and_condition($arAndCondition));
            $sSQL = $this->oQuery->get_update();
            //bug($sSQL); die;
            $this->execute($sSQL);
        }
    }//autoquarantine
    
    public function autoclon()
    {
        if($this->check_valtypes("pkkeys"))
        {
            $oQuery = new ComponentQuery($this->_table_name);
            $oQuery->set_fields($this->get_all_fields());
            $oQuery->set_comment("clon_single.select");            
            $arPkf = $this->get_pk_fields();
            $arPkf = array_unique($arPkf);
            foreach($arPkf as $sPkf)
            {
                $sValue = $this->get_attrib_value($sPkf);
                $sValue = $this->get_as_string_value($sValue);
                $oQuery->add_and("$sPkf=$sValue");
                $oQuery->add_and("$this->_table_name.delete_date IS NULL");
                $oQuery->add_and("$this->_table_name.is_enabled=1");
            }
            $sSQL = $oQuery->get_select();
            //pr($sSQL);
            $arRow = $this->query($sSQL,1);
            if($arRow)
            {                
                unset($arRow["delete_platform"]);
                unset($arRow["delete_user"]);
                unset($arRow["delete_date"]);
                $arRow["insert_date"] = $this->get_todaydb();
                $arRow["update_date"] = $arRow["insert_date"];
                $arRow["insert_user"] = $this->iSessionUserId;
                $arRow["update_user"] = $this->iSessionUserId;
                $arRow["insert_platform"] = $this->_platform;
                $arRow["update_platform"] = $this->_platform;
                $arRow["is_erpsent"] = $this->_is_erpsent;
                $arRow["cru_csvnote"] = "a:clonned,o:$this->_id,";
                
                $oQuery = new ComponentQuery($this->_table_name);
                $oQuery->set_comment("clon_single.insert");
                //TODO aqui habria que hacer mas cosas, comprobar si la clave es automatica, si es autogen por la app
                //si la tiene que proporcionar el usuario en un array de clonacion. De momento se cuenta con un auto id en bd
                foreach($arRow as $sFieldName=>$sFieldValue)
                {
                    if(!in_array($sFieldName,$arPkf))
                    {
                        $oQuery->add_insertfield($sFieldName);
                        $sFieldValue = $this->sqlclean($sFieldValue);
                        $sValue = $this->get_as_string_value($sFieldValue);
                        $oQuery->add_insertvalue($sValue);
                    }
                }
                $sSQL = $oQuery->get_insert();
                //pr($sSQL);die;
                //en este metodo se carga el ultimo id 
                $this->execute($sSQL);
            }
            //!$arRow
            else
            {
                $this->add_error(tr_main_error_datanotfound);                
            }
        }
        else
        {
            $this->log_error($this->arErrorValtypes,"clon_single");
            $this->add_error(tr_main_error_fieldtype);
        }
    }//clon_single
    
    protected function get_column_values($arRows,$sFieldName="id")
    {
        $arValues = array();
        if(is_array($arRows))
            foreach($arRows as $arField)
                if(key_exists($sFieldName,$arField))
                    $arValues[] = $arField[$sFieldName];
        
        return $arValues;
    }//get_column_values
    
    /**
     * Crea un string "('val1'..'valn')" ó "(3,7,8...n)"
     * @param string $mxVariable valores separados por doble coma tipo, val1,,val2,,val3..<br>
     * Este es el formato que se recupera desde un control multiselección
     * @param boolean $isNumeric el formato del sqlin si es numerico no aplicará comillas 
     * @return string "(values...)" para aplicar Code IN returned_string
     */
    protected function build_sqlin($mxVariable,$isNumeric=FALSE)
    {
        //bug($mxVariable);
        $sSQLIn = "";
        if(is_array($mxVariable))
        {
            $sSQLIn = implode("','",$mxVariable);
            if($isNumeric)
                $sSQLIn = implode(",",$mxVariable);
                
            if(empty($sSQLIn))
            {
                $sSQLIn = "('')";
                if($isNumeric){$sSQLIn = "(-1)";}
            }
            else
            {
                if($isNumeric) $sSQLIn = "($sSQLIn)";
                else $sSQLIn = "('$sSQLIn')";
            }
        }
        elseif($mxVariable!="" && $mxVariable!=",,")
        {    
            $sReplace = "','";
            if($isNumeric) $sReplace = ",";
            $mxVariable = str_replace(",,",$sReplace,$mxVariable);
            if(!$isNumeric) $mxVariable = "'$mxVariable'";
            $sSQLIn = "($mxVariable)";
        }
        else
        {
            $sSQLIn = "('')";
            if($isNumeric){$sSQLIn = "(-1)";}
        }
        return $sSQLIn;
    }//build_sqlin
    
    function build_description_field()
    {
        $arValues = array();
        //array(fieldname=>(type=>,))
        foreach($this->arDescConfig as $sFieldName=>$arConfig)
        {
            //bug($this->arDescConfig);//si es numerico se entiende que el nombre del campo no se almacena en la clave sino en el valor
            if(is_numeric($sFieldName)) $sFieldName = $arConfig;
            if($sFieldName=="separator")
                continue;
            $sFieldType = "";
            if(isset($arConfig["type"])) $sFieldType = $arConfig["type"];
            $sValue = $this->get_attrib_value($sFieldName);
            if($sFieldType=="date") $sValue = dbbo_date($sValue,"/");
            elseif($sFieldType=="time4") $sValue = dbbo_time4($sValue,"/");
            elseif($sFieldType=="time6") $sValue = dbbo_time6($sValue,"/");
            $arValues[] = $sValue;
        }
        
        $sSeparator = $this->arDescConfig["separator"];
        if(!$sSeparator) $sSeparator = " ";
        //bug($arValues);die;
        return implode($sSeparator,$arValues);
    }
    
    protected function build_sql_orderby($arOrderFields=array(),$arTypes=array(),$useClause=0)
    {
        //$isMapping = count($this->arFieldsMappingExtra);
        $arMapFields = array_keys($this->arFieldsMappingExtra);
        if(!$arOrderFields) $arOrderFields = $this->_order_fields;
        if(!$arTypes) $arTypes = $this->_order_types;
        //bug($arOrderFields,"arOrderFields"); bug($arTypes,"artypes"); bug($arMapFields,"mapfields"); die;
        $sSQLOrderBy = "";
        $arOrderBy = array();
        
        if($arOrderFields)
            foreach($arOrderFields as $iPosition=>$sFieldName)
            {
                if($sFieldName)  
                {    
                    //bug($this->arFieldsMappingExtra);
                    //si hay mapeo de campos extras
                    if($arMapFields)
                    {  
                        //busco tabla.campo en el mapeo
                        $sTableField = $this->get_extrafield_mapped($sFieldName);
                        //no es campo extra, posible campo de tabla
                        if(!$sTableField)
                        {
                            bug("fieldorder no extra");
                            //compruebo si es campo de la tabla (_table_name)
                            if($this->is_defined_field($sFieldName))
                            {
                                
                                $sTableField = "$this->_table_name.$sFieldName";
                                if($this->get_field_type($sFieldName)=="text" && $this->is_db_mssql())
                                {
                                    $sTableField = "CONVERT(NVARCHAR,$sTableField)";
                                }
                            }
                        }

                        //sino existe ni en el mapeo ni en la matriz se omite (posible campo virtual)
                        if($sTableField)
                            $arOrderBy[] = $sTableField." ".$arTypes[$iPosition];
                    }
                    //no hay mapeo con tablas de joins
                    else
                    {
                        $sTableField = "$this->_table_name.$sFieldName";
                        if($this->get_field_type($sFieldName)=="text")
                            $sTableField = $sFieldName;
                        $arOrderBy[] = "$sTableField ".$arTypes[$iPosition];
                    }
                }//hay un campo
                else
                {
                    bug($arOrderFields,"no order by");
                    bug("BUG NO ORDERBY","build_sql_orderby 1.7.10 $sFieldName");
                }
            }//foreach fields
        
        //bug($arOrderBy,"arOrderby");
        if(!empty($arOrderBy))
        {  
            if($useClause) $sSQLOrderBy .= " ORDER BY ";
            $sSQLOrderBy .= implode(", ",$arOrderBy);
        }
        return $sSQLOrderBy;
    }
    
    protected function build_and_condition($arFieldAndValue=array())
    {
       $sSQLAnd = "";
       $arSQLAnd = array();
       foreach($arFieldAndValue as $sFieldName=>$sFieldValue)
       {
           if($this->is_numeric_field($sFieldName))
               $arSQLAnd[] = "$this->_table_name.$sFieldName=$sFieldValue";
           else
               $arSQLAnd[] = "$this->_table_name.$sFieldName=".$this->get_as_string_value($sFieldValue);
       }
       $sSQLAnd .= implode(" AND ",$arSQLAnd);
       return $sSQLAnd;
    }

    protected function build_sql_filters($useAndPrefix=0)
    {
        $arMapFields = array_keys($this->arFieldsMappingExtra);
        $sSQLFilter = "";
        $arSQL = array();
        //bug($this->arFilters);
        foreach($this->arFilters as $sFieldName=>$mxData)
        {
            $sOperator = NULL; $mxValue = NULL;
            if(isset($mxData["operator"]))
                $sOperator = $mxData["operator"];
            if(isset($mxData["value"]))
                $mxValue = $mxData["value"];
            
            if(isset($mxData["mapping"]))
                $sFieldName = $mxData["mapping"];
            
            if(!$mxValue && !is_array($mxData)) 
                $mxValue = $mxData;
            //bug($mxValue,"$sFieldName valor");
            if($mxValue || $mxValue=="0")
            { 
                if(!$sOperator) $sOperator="=";

                if($sOperator=="like")
                { 
                    //operador like
                    $sOperator = " LIKE ";
                    $mxValue = "'%$mxValue%'";
                }
                elseif($sOperator=="liker")
                { 
                    //operador like
                    $sOperator = " LIKE ";
                    $mxValue = "'$mxValue%'";
                }
                elseif($sOperator=="likel")
                { 
                    //operador like
                    $sOperator = " LIKE ";
                    $mxValue = "'%$mxValue'";
                }
                else
                {    
                    $mxValue = "'$mxValue'";
                    if($this->is_numeric_field($sFieldName))
                        $mxValue = "$mxValue";
                }
                
                //si hay mapeo de campos extras
                if($arMapFields)
                {    
                    //busco table.field en los extras
                    $sTableField = $this->get_extrafield_mapped($sFieldName);
                    //si no hay
                    if(!$sTableField)
                    {
                        //busco en la tabla matriz
                        if($this->is_defined_field($sFieldName))
                            $sTableField = "$this->_table_name.$sFieldName";
                    }    
                    if($sTableField)
                        $arSQL[] = $sTableField.$sOperator.$mxValue;
                }
                //no hay mapeo extra y el campo esta definido en la tabla principal
                elseif($this->is_defined_field($sFieldName))
                    $arSQL[] = "$this->_table_name.$sFieldName$sOperator$mxValue";
                else
                    ;//es un campo que no interviene en los filtros, es tipo auxiliar que solo sirve en la interface
                
                //El campo puede ser de una tabla que hace join. El nombre de la tabla se refiere al alias
                $sJoinTable = NULL;
                if(isset($mxData["table"]))
                    $sJoinTable = $mxData["table"];
                
                if($sJoinTable) 
                {
                    $sTableField = "$sJoinTable.$sFieldName";
                    $arSQL[] = $sTableField.$sOperator.$mxValue;
                }
                //ejemplo: selLayoutmode en pictures
            }//if($mxValue || $mxValue=="0")
        }//foreach $arFilters
        
        if($arSQL)
        {
            if($useAndPrefix) $sSQLFilter .= " AND ";
            $sSQLFilter .= implode(" AND ",$arSQL);
            $sSQLFilter .= " ";
        }
        //bug($arSQL,$sSQLFilter);
        return $sSQLFilter;
    }
    
    public function get_message($sNl=".\n"){return implode($sNl,$this->arMessage);}
    
    public function get_message_error($sNl=".\n"){return implode($sNl,$this->arErrorMessages);}
 
    private function get_attrib_value($sFieldName)
    {
        $sFieldValue = NULL;
        $sGetMethod = "get_$sFieldName";
        if(method_exists($this,$sGetMethod))
        {        
            $sFieldValue = $this->{$sGetMethod}();
            //bugraw("fieldvalue from $sGetMethod: $sFieldValue");
        }
        else 
        {
            $sMessage = "warning: missing method: $this->_table_name.$sGetMethod\n";
            $sMessage .= "protected \$_$sFieldName;\n";
            $sMessage .= "public function get_$sFieldName(){return \$this->_$sFieldName;}\n";
            $sMessage .= "public function set_$sFieldName(\$value){\$this->_$sFieldName = \$value;}";
            $this->log_error($sMessage);
        }
        return $sFieldValue;
    }

    private function get_log_name()
    {
        $sLogName = "model_";
        if($this->_table_name) $sLogName .= $this->_table_name."_";
        if($_SESSION["tfw_user_identificator"]) $sLogName .= $_SESSION["tfw_user_identificator"]."_";
        $sLogName .= date("Ymd").".log";
        return $sLogName;
    }
    
    public function truncate_table()
    {
        $sSQL = "TRUNCATE TABLE $this->_table_name";
        $this->execute($sSQL);
    }
    
    protected function query($sSQL,$iRow=0,$iColumn=0)
    {
        if($this->isDebug) pr($sSQL);        
        $arRows = $this->oDB->query($sSQL);
        //bug($arRows,"arRows");
        $iRow = $iRow-1;
        $iColumn = $iColumn-1;
        
        if($iRow>-1)
        {
            if(isset($arRows[$iRow]))
                $arRows = $arRows[$iRow];
            else 
                $arRows = NULL;
            
            if($iColumn>-1 && is_array($arRows))
            {                        
                $arKeys = array_keys($arRows);
                $arRows = $arRows[$arKeys[$iColumn]];
            }
        }
            
        if($this->oDB->is_error())
            $this->add_error($this->oDB->get_error_message());
        
        $this->save_query_in_log($sSQL,$this->oDB->get_affected_rows(),$this->oDB->get_query_time());
        return $arRows;
    }
    
    protected function execute($sSQL)
    {
        //ejecuta la sentencia
        $this->oDB->query($sSQL);
        if(strstr($sSQL,"INSERT INTO "))
            $this->load_last_insert_id();
        //si ha ocurrido algun error se recupera y se propaga a las variables
        //de control de error del modelo. arMessage y isError
        if($this->oDB->is_error())
            $this->add_error($this->oDB->get_error_message());
        
        $this->save_query_in_log($sSQL,$this->oDB->get_affected_rows());
        return $this->oDB->get_affected_rows();
    }
    
    /**
     * 
     * @param string $sSQL
     * @param integer $iAffectedRows
     * @param float $fQueryTime
     */
    private function save_query_in_log($sSQL,$iAffectedRows,$fQueryTime="")
    {
        $doSaveLog = FALSE;
        $sAuxPathFolder = $this->oLog->get_path_folder_target();
        $sAuxFilename = $this->oLog->get_target_file_name();
        
        //Aplico directorio de destino de traza
        if($this->_log_delete && preg_match("/DELETE FROM ([^ ]+)/",$sSQL))
        {$this->oLog->set_path_folder_target($this->_path_log_delete); $doSaveLog=TRUE;$sPrefix="del";}
        elseif($this->_log_insert && preg_match("/INSERT INTO ([^ ]+)/",$sSQL))        
        {$this->oLog->set_path_folder_target($this->_path_log_insert);$doSaveLog=TRUE;$sPrefix="ins";}
        elseif($this->_log_update && preg_match("/UPDATE ([^ ]+)/",$sSQL))        
        {$this->oLog->set_path_folder_target($this->_path_log_update);$doSaveLog=TRUE;$sPrefix="upd";}
        elseif($this->_log_select && preg_match("/SELECT ([^ ]+)/",$sSQL))        
        {$this->oLog->set_path_folder_target($this->_path_log_select);$doSaveLog=TRUE;$sPrefix="sel";}
        
        //if(strstr($sSQL,"DELETE")){bug("DOSAVE:$doSaveLog,sqltosave",$sSQL);die;}
        //bug($arMatches,"arMatches");die;
        if($doSaveLog)
        {
            $sFileName = $sPrefix."_";
            if(isset($_SESSION["tfw_user_identificator"])) $sFileName .= $_SESSION["tfw_user_identificator"]."_";
            $sFileName .= date("Ymd").".log";
            $sContent = "[".date("H:i:s")."]\n$sSQL /*r($iAffectedRows)*/";
            if($fQueryTime) $sContent .= " /*t($fQueryTime s.)*/";
            
            $this->oLog->set_filename_target($sFileName);
            $this->oLog->add_content($sContent);
            //Restauro la carpeta y archivo configurado
            $this->oLog->set_path_folder_target($sAuxPathFolder);
            $this->oLog->set_filename_target($sAuxFilename);
        }
    }
        
    /**
     * Es equivalente a SELECT * FROM table WHERE delete_date IS NULL AND is_enabled=1
     * @return string
     */
    public function get_select_all()
    {
        //$oQuery = new ComponentQuery();
        $this->oQuery->set_comment("get_select_all()");
        $this->oQuery->set_top($this->_top);
        if(!$this->sSELECTfields) $this->oQuery->set_fields($this->get_all_fields());
        else $this->oQuery->set_fields($this->sSELECTfields);
        $this->oQuery->set_fromtables($this->_table_name);
        //Reseteo el where para que no me duplique las condiciones si he llamado
        //previamente a get_select_all_ids()
        $this->oQuery->set_where();
        $this->oQuery->add_where("$this->_table_name.delete_date IS NULL");
        $this->oQuery->add_where("$this->_table_name.is_enabled=1");
        $sSQL = $this->oQuery->get_select();
        $arRows = $this->query($sSQL);
        return $arRows;
    }
    
    protected function build_table_pkeys()
    {
        $arKeys = array();
        foreach($this->arPkFields as $sFieldName)
            $arKeys[] = "$this->_table_name.$sFieldName";
        return implode(",",$arKeys);
    }
    
    public function get_select_all_ids()
    {
        $this->oQuery->set_comment("get_select_all_ids()");
        $this->oQuery->set_top($this->_top);
        if(!$this->sSELECTfieldsId) 
            //He creado el metodo table_pkeys para los casos en los cuales se rescriba las claves primarias de la tabla
            //este metodo crea: tabla.pk1,tabla.pk2...
            $this->oQuery->set_fields($this->build_table_pkeys());
        else 
            $this->oQuery->set_fields($this->sSELECTfieldsId);
        $this->oQuery->set_fromtables($this->_table_name);
  
//            $sSQLJoin = "/* estos joins solo se aplican si this->_select_user tiene algun valor. Para productos no serviria habría que mejorarlo
//                          la jerarquia se aplica por cliente. Pero, no seria mejor hacerlo por id_seller? habria que repensar si la mayoria 
//                          de tablas tienen esta foreign key*/
//                         INNER JOIN vbase_hieruser_customer AS vbhusrcus 
//                         ON vbhusrcus.id_customer = $this->_table_name.id_customer 
//                         AND vbhusrcus.id_user=$this->_select_user ";
        $this->oQuery->add_joins($this->build_userhierarchy_join($this->_select_user,"customer","id_customer")); 
        
        if($this->is_defined_field("delete_date"))
            $this->oQuery->add_where("$this->_table_name.delete_date IS NULL");
        if($this->is_defined_field("is_enabled"))
            $this->oQuery->add_where("$this->_table_name.is_enabled=1");
        //EXTRA AND
        $this->oQuery->add_and($this->build_sql_filters());
        
        //ORDERBY 
        //default orderby (mira _order_fields)
        $sOrderByAuto = $this->build_sql_orderby();
        if($sOrderByAuto) $this->oQuery->set_orderby($sOrderByAuto);
        else
            $this->oQuery->set_orderby($this->build_table_pkeys()." DESC");
        $sSQL = $this->oQuery->get_select();
        //bug($sSQL);
        return $this->query($sSQL);
    }//get_select_all_ids
    
    public function get_select_all_by_ids($arPks=NULL)
    {
        $this->oQuery->set_comment("get_select_all_by_ids()");
        $this->oQuery->set_top($this->_top);
        //Si no hay campos definidos en el objeto se usa *
        if(!$this->sSELECTfields)
            $this->oQuery->set_fields($this->get_all_fields());
        else
            $this->oQuery->set_fields($this->sSELECTfields);
        
        if(!$this->oQuery->get_fromtables()) 
            $this->oQuery->set_fromtables($this->_table_name);
        //Reseteo el where para que no me duplique las condiciones si he llamado
        //previamente a get_select_all_ids()
        $this->oQuery->set_where("1=1");
//        $this->oQuery->add_where("$this->_table_name.delete_date IS NULL");
//        $this->oQuery->add_where("$this->_table_name.is_enabled=1");
        //Reseteo los ands que vienen de get_select_all_by_ids ya que seria redundar puesto que el in ya viene filtrado        
        $this->oQuery->set_and();
        //@TODO: esto solo sirve para pks de una dimension. Habría que jugar con los ids, pasar las pks a multiclave
        //ojo en la transformación ya que las vistas puede que no tengan columna id.
        //y sino crear un tipo exists para la multiclave
        //ANDS 
        //bug($arPks,"array claves primarias");die;
        if($arPks) 
        {
            foreach($this->arPkFields as $sPkField)
            {    
                $arPkValues = $this->get_column_values($arPks,$sPkField);
                $this->oQuery->add_and("$this->_table_name.$sPkField IN ".$this->build_sqlin($arPkValues,1));
            }
        }
        //si la query anterior no devolvio resultados el array de ids viene vacio
        elseif(is_array($arPks))
        {   
            foreach($this->arPkFields as $sPkField)
                $this->oQuery->add_and("$this->_table_name.$sPkField IS NULL");
        }
        //si no es array, por defecto.. devuelve todo (para listado xls)
        else
        {
            $this->oQuery->add_joins($this->build_userhierarchy_join($this->_select_user,"customer","id_customer")); 
            if($this->is_defined_field("delete_date"))
                $this->oQuery->add_where("$this->_table_name.delete_date IS NULL");
            if($this->is_defined_field("is_enabled"))
                $this->oQuery->add_where("$this->_table_name.is_enabled=1");
            //EXTRA AND
            $this->oQuery->add_and($this->build_sql_filters());
            //ORDERBY 
            //creo el orderby por defecto con las claves primaris
            $this->oQuery->set_orderby($this->build_table_pkeys()." DESC");
            
            //si se estuviera pidiendo otro orderby (por ejemplo al pinchar en alguna columna del grid) sobrescribo el orderby por defecto
            $sOrderByAuto = $this->build_sql_orderby();
            if($sOrderByAuto) $this->oQuery->set_orderby($sOrderByAuto);            
        }
        $sSQL = $this->oQuery->get_select();
        //bug($sSQL,"select_all_by_ids"); die;
        return $this->query($sSQL);
    }//get_select_all_by_ids

    //http://www.deliciousdotnet.com/2011/03/getting-last-inserted-identity-value-in.html#.Ud7SB23pwQs
    private function load_last_insert_id()
    {
        if($this->is_db_mssql())
            $this->iLastInsertId = $this->query("/*last id mssql*/SELECT IDENT_CURRENT('$this->_table_name') AS lastid",1,1); 
        elseif($this->is_defined_field("id"))
            $this->iLastInsertId = $this->query("/*last id mysql*/SELECT MAX($this->_table_name.id) AS lastid FROM $this->_table_name",1,1); 
    }
    
    /**
     * 
     * ["seller"] = array("view"=>"get_|vbase_hieruser_seller","fieldname"=>"id_seller");//id_user,id_seller
     * ["customer"] = array("view"=>"get_|vbase_hieruser_customer","fieldname"=>"id_customer");//id_user,id_customer
     * ["userchild"] = array("view"=>"get_|vbase_hieruser_userchild","fieldname"=>"id_user_child");//id_user, id_user_child
     * @param string $sView seller, customer, userchild
     */
    protected function build_userhierarchy_join($idUser,$sView,$sFieldName)
    {
        $sSQLJoin = NULL;
        if($idUser && $sView && $sFieldName)
        {  
            if(!$this->is_defined_field($sFieldName))
            {
                $this->log_error("build_userhierarchy_join failed! $sFieldName does NOT exist in $this->_table_name");
                return $sSQLJoin;
            }
            $sHierarchyView = $this->arHierarchyViews[$sView]["view"];
            $sHierarchyField = $this->arHierarchyViews[$sView]["fieldname"];
            $sSQLJoin = "INNER JOIN $sHierarchyView 
                       ON $sHierarchyView.$sHierarchyField = $this->_table_name.$sFieldName 
                       AND $sHierarchyView.id_user=$idUser";
            
            if($this->is_db_mysql())
            {
                //para mysql ejecutare el metodo equivalente a la vista. Este me devuelve una subconsulta
                //Le pongo el mismo nombre que la vista para emularla
                $sSQLHierarchy = $this->$sHierarchyView($idUser);
                $sSQLJoin = "INNER JOIN ($sSQLHierarchy) AS $sHierarchyView
                            ON $sHierarchyView.$sHierarchyField = $this->_table_name.$sFieldName";
            }            
            return $sSQLJoin;
        }
        return $sSQLJoin;
    }

    protected function buildcustom_userhierarchy_join($idUser,$sView,$sTable,$sFieldTable)
    {
        $sSQLJoin = NULL;
        if($sView && $sTable && $sFieldTable && $idUser)
        {  
            $sHierarchyView = $this->arHierarchyViews[$sView]["view"];
            //id_foreign_entity
            $sHierarchyField = $this->arHierarchyViews[$sView]["fieldname"];
            $sSQLJoin = "INNER JOIN $sHierarchyView 
                         ON $sHierarchyView.$sHierarchyField = $sTable.$sFieldTable
                         AND $sHierarchyView.id_user=$idUser";
            if($this->is_db_mysql())
            {
                //para mysql ejecutare el metodo equivalente a la vista. Este me devuelve una subconsulta
                //Le pongo el mismo nombre que la vista para emularla
                $sSQLHierarchy = $this->$sHierarchyView($idUser);
                $sSQLJoin = "INNER JOIN ($sSQLHierarchy) AS $sHierarchyView
                            ON $sHierarchyView.$sHierarchyField = $sTable.$sFieldTable";
            }            
            return $sSQLJoin;            
        }
        return $sSQLJoin;
    }    
    
    /**
     * Pasa a minusculas los nombres de los campos 
     * @param array $arRows array(fieldname=>value,...,fieldnamen=>valuen)
     */
    protected function lower_fieldnames(&$arRows)
    {
        if($arRows)
        {
            $arLowered = array();
            $arTmpRow = array();
            $isSingleRow = FALSE;

            $arKeys = array_keys($arRows);
            //bug($arKeys);
            foreach($arKeys as $i=>$mxKey)
                if(!is_int($mxKey))
                {
                    $isSingleRow = TRUE;
                    break;
                }

            //se pasa una fila reducida    
            if($isSingleRow)
            {
                foreach($arRows as $sFieldName=>$sValue)
                {    
                    $sFieldName = strtolower($sFieldName);
                    $arTmpRow[$sFieldName] = $sValue; 
                }
                $arLowered = $arTmpRow;
            }
            //grupo de fila o filas
            else 
            {            
                foreach($arRows as $i=>$arRow)
                {
                    $arTmpRow = array();
                    foreach($arRow as $sFieldName=>$sValue)
                    {    
                        $sFieldName = strtolower($sFieldName);
                        $arTmpRow[$sFieldName] = $sValue; 
                    }
                    $arLowered[$i] = $arTmpRow;
                }
            }
            $arRows=$arLowered;
        }
    }    
    
    /**
     * Array de una única fila. Se utiliza en load_by_xxx
     * @param array $arRow tipo array(fieldname1=>value1,...,fieldnameN=>valueN)
     * @param int $isDb Si se carga de bd se comprueba las claves primarias definidas en arPkFields y arPkApp
     */
    protected function row_assign($arRow,$isDb=1)
    {
        if($isDb)
        {    
            if($this->is_pk_empty($arRow))
            {
                $this->isInTable = FALSE;
                $arPks = $this->get_pk_fields();
                
                //la fila tiene todas las claves primarias
                $isKeys = TRUE;
                foreach($arPks as $sFieldName)
                {
                    if(!isset($arRow[$sFieldName]) || $arRow[$sFieldName]===NULL)
                    {   
                        $isKeys = FALSE;
                        break;
                    }
                }
                
                //Si existe al menos una pk sin rellenar, se crea una fila erronea
                if(!$isKeys)
                {
                    $arRow = array();
                    foreach($arPks as $sFieldName)
                        $arRow[$sFieldName] = NULL;                    
                }
            }
            //todas las pks tienen valores -> existe el registro
            else 
            {
                $this->isInTable = TRUE;
            }//fin else pks ok
        }
        //No Db (xml)
        else
        {
            $this->isInTable = FALSE;
        }
        $this->set_attrib_value($arRow);
    }//row_assign
            
    private function force_null(&$sProperty){if(trim($sProperty)==="")$sProperty=NULL;}
    
    private function get_pk_fields()
    {
        $arPks = array_merge($this->arPkFields,$this->arPkApp);
        return array_merge($arPks,$this->arPkDb);
    }
    
    private function is_pk_empty($arRow)
    {
        if(!$arRow)
            return TRUE;
        
        $arPks = $this->get_pk_fields();
        $arFields = array_keys($arRow);
        
        foreach($arFields as $sFieldName)
            if(in_array($sFieldName,$arPks))
                if($arRow[$sFieldName]===NULL)
                    return TRUE;
        return FALSE;
    }//is_pk_empty
    
    /**
     * Si es un campo varchar > 255 hay que pasarlo a tipo TEXT en la consulta SELECT
     * @param string $sFieldName
     * @return boolean 
     */
    private function is_field_for_textconvert($sFieldName)
    {
        if($this->is_db_mssql())
        {
            $sFielType = $this->get_field_type($sFieldName);
            if($sFielType=="varchar")
            {    
                $iLength = (int)$this->get_field_length($sFieldName);
                if($iLength>254)
                    return TRUE;
            }
        }
        return FALSE;
    }
    
    private function is_anydate($sFieldName)
    {
        $sFielType = $this->get_field_type($sFieldName);
        $arDates = array("date","datetime");
        return in_array($sFielType,$arDates);
    }
    
    /**
     * Crea los campos de la tabla haciendo CONVERT(TEXT..) si fuera necesario
     * @return string
     */
    protected function get_all_fields()
    {
        //Corregir bug https://bugs.php.net/bug.php?id=13722
        $sSelectAll = "";
        $arSelect = array();
        //bug($this->arFieldsDb,"arFieldsDb");
        foreach($this->arFieldsDb as $sFieldName)
        {
            $sSavedFieldName = $this->save_reserved_words($sFieldName);
            
            if($this->is_db_mssql())
            {
                if($this->is_field_for_textconvert($sFieldName))
                    $arSelect[] = "CONVERT(TEXT,$this->_table_name.$sSavedFieldName) AS $sFieldName";
                elseif($this->is_anydate($sFieldName))
                    $arSelect[] = "LEFT(CONVERT(VARCHAR,$this->_table_name.$sSavedFieldName,120),20) AS $sFieldName";
                else
                    $arSelect[] = "$this->_table_name.$sSavedFieldName";                
            }
            else
                $arSelect[] = "$this->_table_name.$sSavedFieldName";
        }
        $sSelectAll = implode(",",$arSelect);
        return $sSelectAll;
    }
        
    protected function get_filled_attribs()
    {
        $arFieldsVals = array();
        foreach($this->arFieldsDb as $sFieldName)
        {
            $sFieldValue = $this->get_attrib_value($sFieldName);
            if($sFieldValue) $arFieldsVals[$sFieldName] = $sFieldValue;
        }
        return $arFieldsVals;
    }
    
    protected function get_dec_formatted($iFormat=1,$fValue)
    {
        if($iFormat==1)
            return bodb_numeric2($fValue);
        return $fValue;
    }//get_dec_formatted
        
    //==================================
    //             GETS
    //==================================

    //GET SYSTEM FIELDS
    public function get_processflag(){return $this->_processflag;}
    
    public function get_insert_platform(){$this->force_null($this->_insert_platform); return $this->_insert_platform; }
    public function get_insert_user(){$this->force_null($this->_insert_user); return $this->_insert_user; }
    public function get_insert_date(){$this->force_null($this->_insert_date); return $this->_insert_date; }
    
    public function get_update_platform(){$this->force_null($this->_update_platform); return $this->_update_platform; }
    public function get_update_user(){$this->force_null($this->_update_user); return $this->_update_user; }    
    public function get_update_date(){$this->force_null($this->_update_date); return $this->_update_date; }    
    
    public function get_delete_platform(){$this->force_null($this->_delete_platform); return $this->_delete_platform; }
    public function get_delete_user(){$this->force_null($this->_delete_user); return $this->_delete_user; }
    public function get_delete_date(){$this->force_null($this->_delete_date); return $this->_delete_date; }

    public function get_cru_csvnote(){$this->force_null($this->_cru_csvnote);return $this->_cru_csvnote;}    
    public function get_is_erpsent(){ return $this->_is_erpsent;}
    public function get_is_enabled(){ return $this->_is_enabled;}
    
    public function get_i(){return $this->_i;}
    public function get_id(){ return $this->_id; }
    public function get_code_erp(){$this->force_null($this->_code_erp); return $this->_code_erp; }
    public function get_description(){$this->force_null($this->_description); return $this->_description;}
    public function translate_description()
    {
        //ModelGentilicLang
        $sClassNameLang = get_class($this);
        $sClassNameLang .= "Lang";
        if(class_exists($sClassNameLang))
        {
            $oModelLang = new $sClassNameLang();
            $oModelLang->set_id_source($this->_id);
            $oModelLang->set_id_language($this->_id_language);
            $oModelLang->load_by_src_and_lang();
            $this->_description_lang = $oModelLang->get_description();
        }
    }
    
    public function get_description_lang(){return $this->_description_lang;}
    
    //END GET SYSTEM FIELDS    
    public function get_platform(){return $this->_platform;}
    
    protected function get_as_string_value($sFieldValue){return "'$sFieldValue'";}
    
    public function get_num_items_per_page(){return $this->_num_items_per_page;}
    
    protected function is_numeric_field($sFieldName)
    {
        $sFieldType = $this->get_field_type($sFieldName);
        return in_array($sFieldType,$this->arNumericTypes);
    }

    protected function get_extrafield_mapped($sFieldName)
    {
        foreach ($this->arFieldsMappingExtra as $sMapField=>$sMap)
            if($sFieldName==$sMapField)
                return $sMap;
        //cambiado pq no se puede asumir que un campo no mapeado no sea de la tabla maestra
        //return "$this->_table_name.$sFieldName";
        return NULL;
    }
    
    public function get_field_type($sFieldName)
    {
        //$arFields[$arRow["field_name"]]=array($arRow["field_type"]=>$arRow["field_length"]);
        if(isset($this->arFieldsDefinition[$sFieldName]))
        {
            $arFieldType = array_keys($this->arFieldsDefinition[$sFieldName]);
            if(isset($arFieldType[0]))
                return $arFieldType[0];        
        }
        return "";
    }
    
    public function get_field_length($sFieldName)
    {
        //$arFields[$arRow["field_name"]]=array($arRow["field_type"]=>$arRow["field_length"]);
        $arFieldValue = array_values($this->arFieldsDefinition[$sFieldName]);
        return $arFieldValue[0];        
    }
    public function get_fields_definition(){return $this->arFieldsDefinition;}
    public function get_fields_for_validation()
    {
        //$arFields TODO DEBE DEVOLVER: //array de configuracion length=>i,type=>array("numeric","required")
    }

    public function get_last_insert_id(){return $this->iLastInsertId;}
    /**
     * Devuelve el valor u operador de un filtro configurado
     * @param string $sFieldName 
     * @param string $sProperty "value", "operator"
     * @return $mxValue int or string
     */
    protected function get_filter($sFieldName,$sProperty="value"){return $this->arFilters[$sFieldName][$sProperty];}
    protected function is_defined_field($sFieldName){return in_array($sFieldName,$this->arFieldsDb);}
    public function get_table_name(){return $this->_table_name;}
    public function is_in_table(){return $this->isInTable;}
    public function get_id_language(){return $this->_id_language;}
    public function get_id_source(){return $this->_id_source;}
    //public function get_order_by(){return $this->_order_by;}
    public function is_language(){return $this->isLanguage;}
    
    protected function is_db_mysql(){return $this->oDB->get_type()=="mysql";}
    protected function is_db_mssql(){return $this->oDB->get_type()=="mssql";}
    protected function get_db_type(){return $this->oDB->get_type();}
    protected function is_fieldsdef_session($isOn=TRUE){$this->isFieldsDefSession=$isOn;}
    public function get_extra($sKey=NULL){return (isset($this->arExtras[$sKey])?$this->arExtras[$sKey]:NULL);}
    public function get_extras(){return $this->arExtras;}
    public function get_max_orderby()
    {
        if($this->is_defined_field("order_by"))
        {
            $oQuery = new ComponentQuery($this->_table_name);
            $oQuery->set_fields("MAX(order_by) AS orderby");
            $sSQL = $oQuery->get_select();
            $arRow = $this->query($sSQL,1,1);
            return $arRow;
        }
        return NULL;
    }
    
    //==================================
    //             SETS
    //==================================
    //SET SYSTEM FIELDS
    public function set_processflag($value){$this->_processflag = $value;}

    public function set_insert_platform($value){ $this->_insert_platform = $value; }
    public function set_insert_user($value){ $this->_insert_user = $value; }
    public function set_insert_date($value){ $this->_insert_date = $value; }

    public function set_update_platform($value){ $this->_update_platform = $value; }
    public function set_update_user($value){ $this->_update_user = $value; }
    public function set_update_date($value){ $this->_update_date = $value; }
    
    public function set_delete_platform($value){ $this->_delete_platform = $value; }
    public function set_delete_user($value){ $this->_delete_user = $value; }
    public function set_delete_date($value){ $this->_delete_date = $value; }
    
    public function set_cru_csvnote($value){$this->_cru_csvnote = $value;}
    public function set_is_erpsent($value){ $this->_is_erpsent = $value; }
    public function set_is_enabled($value){ $this->_is_enabled = $value; }
    public function set_code_erp($value){ $this->_code_erp = $value; }
    public function set_description($value){$this->_description = $value;}
    //END SET SYSTEM FIELDS 
    
    /**
     * Platform in use
     * 1 - BY USER ON DB (1)
     * 2 - DTS (2)
     * 3 - BACKOFFICE (3)
     * 4 - MOVIL DEVICE (4)
     * @param string $sValue
     */
    public function set_platform($sValue){$this->_platform = $sValue;}
    
    public function set_dbobject(ComponentDatabase $oDB){$this->oDB = $oDB;}
    public function set_i($value){$this->_i = $value;}
    public function set_id($value){ $this->_id = $value; }

    public function set_pk_fieldnames($mxFieldNames){if(is_string($mxFieldNames))$mxFieldNames=explode(",",$mxFieldNames); $this->arPkFields=$mxFieldNames;}
    public function add_pk_fieldnames($sFieldName){if($sFieldName) $this->arPkFields[]=$sFieldName;}
    
    public function set_orderby($array){$this->_order_fields = $array;}
    public function set_ordertype($array){$this->_order_types = $array;}
    public function set_debug_on($isOn=true){$this->isDebug=$isOn;}
    
    public function log_save_insert($isOn=true){$this->_log_insert = $isOn;}
    public function log_save_select($isOn=true){$this->_log_select = $isOn;}
    public function log_save_update($isOn=true){$this->_log_update = $isOn;}
    public function log_save_delete($isOn=true){$this->_log_delete = $isOn;}
    /**
     * @param array $arFilters array(fieldname=>(operator=>"",value=>"")
     */
    public function add_filter($sFieldName,$arFilter){$this->arFilters[$sFieldName] = $arFilter;}

    /**
     * @param array $arFilters array(fieldname=>(operator=>"",value=>"","mapping"=>optional)
     */    
    public function set_filters($arFilters){$this->arFilters = $arFilters;}
    public function add_sql($sSQL){if($sSQL)$this->arSQLExtra[]=$sSQL;}
    public function set_attrib_value($arFields=array(),$arExclude=array())
    {
        //$arFields = $this->get_fields_from_post();
        foreach($arFields as $sFieldName=>$sValue)
        {
            $sFieldName = strtolower($sFieldName);
            if(in_array($sFieldName,$arExclude)) 
                continue;
            $sSetMethod = "set_$sFieldName";
            if(method_exists($this,$sSetMethod))
                $this->{$sSetMethod}($sValue);
        }
    }

    /**
     * "type" => date, time4, time6
     * Array tipo ("fieldname"=>array("type"=>""),"fieldname","separator"=>" - " );
     * Ejemplo: array("company","start_hour"=>array("type"=>"time4"),"separator"=>" - ")
     * generaria una descripcion Nombre de compañia - hh:mm 
     * @param array $array
     */
    public function set_description_config($array){$this->arDescConfig = $array;}
    public function set_top($iTop){$this->_top = $iTop;}
    /**
     * Si se aplica este atributo en las consultas se utilizará las vistas de jerarquia
     * @param string $idUser  
     */
    public function set_select_user($idUser)
    {
        if($idUser!==NULL)
            //puede ser un booleano si no existe el objeto oUserSession si esto es así intenta recuperar
            //de la variable de sesion
            if(!$idUser && isset($_SESSION["tfw_user_identificator"])) 
                $idUser = $_SESSION["tfw_user_identificator"];
        $this->_select_user = $idUser;    
    }
    
    /**
     * Nombre de campos que no se insertaran y/o tomarán en cuenta en una actualizacion
     * Si no se pasa argumentos resetea la exclusión
     * @param array|string $mxFieldNames
     */
    public function set_insupd_exclude($mxFieldNames=NULL)
    {
        if(is_array($mxFieldNames))
            $this->arInsUpdExclude = $mxFieldNames;
        else
        {
            $this->arInsUpdExclude = array();
            if(trim($mxFieldNames)!="")
                $this->arInsUpdExclude[] = $mxFieldNames;
        }
    }
    
    /**
     * Campo/s que no se tomarán en cuenta en un update o insert
     * @param string $sFieldName csv ó cadena simple
     */
    public function add_insupd_exclude($sFieldName)
    {
        $sFieldName = trim($sFieldName);
        if($sFieldName!="")
        {
            if(strstr($sFieldName,","))
            {   
                $arFieldNames = explode($sFieldName,",");
                foreach($arFieldNames as $sFieldName)
                    $this->arInsUpdExclude[] = $sFieldName;
            }
            else
            {
                $this->arInsUpdExclude[] = $sFieldName;
            }
        }
    }//add_insupd_exclude
    
    /**
     * Consultar la tabla: base_languages. english:1,spanish:2,dutch:3,papiaments:4
     * @param int $idLanguage
     */
    public function set_id_language($idLanguage){$this->_id_language = $idLanguage;}
    public function set_id_source($value){$this->_id_source = $value;}
    //public function set_order_by($value){$this->_order_by = $value;}
    public function use_language($isOn=TRUE){$this->isLanguage = $isOn;}
    
    public function use_dbobject($i=0){$this->oDB = self::$arDbs[$i];}
    public function set_autopk($isOn=TRUE){$this->isPkAuto=$isOn;}
    
    public function reset_query()
    {        
        $this->oQuery = new ComponentQuery($this->_table_name);
        $this->oQuery->set_db_type($this->oDB->get_type());
    }
    
    public function add_extra($sKey,$mxValue){$this->arExtras[$sKey]=$mxValue;}
    
}//TheFrameworkModel