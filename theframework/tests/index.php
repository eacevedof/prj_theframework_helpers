<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Checkbox;

//https://www.w3schools.com/tags/att_input_checked.asp
$o = new Checkbox();
$o->set_name("chkSome");
$o->set_unlabeled(0);
$o->set_options(["valbike"=>"Bike","valcar"=>"Car"]);
$o->show();
        
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
