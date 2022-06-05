<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name TheFramework\Helpers\Html\Style
 * @date 21-02-2013 09:45
 * @file Style.php
 */
namespace TheFramework\Helpers\Html;
use TheFramework\Helpers\AbsHelper;
class Style extends AbsHelper
{
    private $_class_warning = ""; //yellow
    private $_class_error = ""; //red
    private $_class_success = ""; //green
    private $_class_tips = ""; //blue
    
    private $_class_default = "";
    private $_class_inverse = "";
    
    public function __construct(){$this->type = "style"; }
    
    //**********************************
    //             SETS
    //**********************************
    public function set_class_warning($value){$this->class_warning=$value;}
    public function set_class_error($value){$this->class_error=$value;}
    public function set_class_success($value){$this->class_success=$value;}
    public function set_class_tips($value){$this->class_tips=$value;}
    public function set_class_default($value){$this->class_default=$value;}
    public function set_class_inverse($value){$this->class_inverse=$value;}
    
    //**********************************
    //             GETS
    //**********************************
    public function get_class_warning(){return $this->class_warning;}
    public function get_class_error(){return $this->class_error;}
    public function get_class_success(){return $this->class_success;}
    public function get_class_tips(){return $this->class_tips;}
    public function get_class_default(){return $this->class_default;}
    public function get_class_inverse(){return $this->class_inverse;}
}