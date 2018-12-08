<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Hidden;

$oL = new TheFramework\Helpers\Form\Label;
$oL->set_for("someId");
$oL->set_innerhtml("Field hidden is here:");
$oL->show();
$o = new Hidden("someId","someName","her-comes-a-token-to-be-hidden-afdoopjy8679834ñoñ$$34878=?dsjk");
$o->show();
$o = new Hidden();
$o->set_id("someId2");
$o->set_name("someName2");
$o->set_value("this-is-a-date: 2018-12-08 09:02:00");
$o->show();
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
