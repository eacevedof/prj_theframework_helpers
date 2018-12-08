<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\File;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("This is an Input File:");
$o = new File("someId","someName",NULL,$oL);
$o->set_accept("image/png, image/jpeg");
$o->add_extras("multiple","multiple");
$o->show();
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
