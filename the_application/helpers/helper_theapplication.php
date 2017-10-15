<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Helpers\TheApplicationHelper
 * @file helper_theapplication.php 
 * @version 1.0.0
 * @date 08-10-2017 08:44 (SPAIN)
 * @observations:
 * @requires  
 */
namespace TheApplication\Helpers;

use TheFramework\Helpers\TheFrameworkHelper;

class TheApplicationHelper extends TheFrameworkHelper
{
    protected $iSpan;
    
    public function __construct()
    {
        parent::__construct();       
    }
    
    public function set_span($iSpan=12){$this->iSpan = $iSpan;}
    public function get_span(){return $this->iSpan;}
}//TheApplicationHelper
