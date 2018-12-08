<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Radio;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someRadio");
$oL->set_innerhtml("Choose one value: ");
$oL->show();

$o = new Radio(["key-1"=>"val-1","key-2"=>"val-2","key-3"=>"val-3"],"myRadioGroup");
$o->show();

?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
