<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Controllers\ControllerHomes
 * @file controller_homes.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Controllers;

use TheApplication\Controllers\TheApplicationController;
use TheApplication\Components\ComponentPagedata;

class ControllerHomes extends TheApplicationController
{
    public function __construct()
    {
        //bugpg();
    }
    
    //
    public function index()
    {
        include("helpers/array_helpers.php");       
        $oAppMain = new ComponentPagedata($arHelpers);
        include("homes/view_index.php");
    }
    
    //versions
    public function versions()
    {
        include("homes/view_versions.php");
    }
    
    //helper:/examples
    public function examples()
    {
        
    }
    
    //helper:/code
    public function code()
    {
        
    }    
    
    //download/version:/
    public function download()
    {
        
    }    
    
}//ControllerHomes