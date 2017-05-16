<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name HelperCss
 * @file helper_css.php
 * @date 05-08-2016 11:51 (SPAIN)
 * @observations: 
 */
namespace TheFramework\Helpers;
use TheFramework\Helpers\TheFrameworkHelper;

class HelperCss extends TheFrameworkHelper
{
    private $_sSubPathPlugin = "";
    private $_sSubPathStyle = "";
    private $_sSubPathExt = "";
    
    private $_arPathFiles = array("type"=>"custom|jquery","filename");

    public function __construct($sSubPathExt="", $arSubPathFiles=array())
    {
        parent::__construct();
        $this->_arPathFiles = $arSubPathFiles;
        $this->_sSubPathStyle = TFW_SUBPATH_STYLEDS;
        $this->_sSubPathPlugin = TFW_SUBPATH_PLUGINDS;
        $this->_sSubPathExt = $sSubPathExt;
    }
    
    private function add_filehref($sFileName,$sType,$sPath)
    {
        //$sPath = "js/";
        if(!strpos($sFileName,".css"))$sFileName .= ".css";
        if(!empty($sType)) $sPath .= "$sType/";
        $sPath .= $sFileName;
        if(!in_array($sPath, $this->_arPathFiles))
            $this->_arPathFiles[] = $sPath; 
    }
     
    public function add_tfw_filehref($sFileName,$sType="custom")
    {
        $this->add_filehref($sFileName,$sType,$this->_sSubPathJs);
    }

    public function add_plug_filehref($sFolderName,$sFileName)
    {
        $sPath = $this->_sSubPathPlugin.$sFolderName.TFW_DS."style".TFW_DS;
        $this->add_filehref($sFileName,null,$sPath); 
    }
    
    public function add_ext_filehref($sFileName,$sSubPath="")
    {
        if(empty($sSubPath)) $sSubPath = $this->_sSubPathExt;
        if(empty($sSubPath)) $sSubPath = "styles".TFW_DS;
        $this->add_filehref($sFileName,null,$sSubPath); 
    }
    
    private function get_html_tag_script_link($sHrefPath)
    {
        $sLinkTag = "";
        if(!empty($sHrefPath))
        $sLinkTag = "<link type=\"text/css\" rel=\"stylesheet\" href=\"$sHrefPath\">\n";
        return $sLinkTag;
    }
    
    public function get_html_tag_links()
    {
        $sLinks = "";
        foreach($this->_arPathFiles as $sHrefPath)
            $sLinks .= $this->get_html_tag_script_link($sHrefPath);

        return $sLinks;
    }
    
    public function add_file($sFilePath){$this->_arPathFiles[] = $sFilePath;}
    public function show_tag_links(){echo $this->get_html_tag_links();}

    //**********************************
    //             SETS
    //**********************************
    public function set_path_files($arPaths=array()){$this->_arPathFiles = $arPaths;}
    public function set_subpath_ext($sSubPath){$this->_sSubPathExt = $sSubPath;}
}