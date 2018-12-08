<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Text;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someTextId");
$oL->set_innerhtml("Set a value:");

$o = new Text("someTextId","someName");
$o->set_label($oL);
$o->add_extras("placeholder"," this is placeholder");
$o->show();
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
