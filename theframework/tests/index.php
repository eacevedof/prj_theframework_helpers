<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Input\Date;

$o = new Date("someId");
$o->set_value("06/12/2018");//ok
$o->set_value("06-12-2018");//ok
$o->set_value("2018-12-06");//ok
$o->set_value("20181206");//bad!
$o->set_value("06122018");//bad!
$o->show();

?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
