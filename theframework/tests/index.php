<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

//Example: https://developer.mozilla.org/es/docs/Web/HTML/Elemento/fieldset
use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Fieldset;
use TheFramework\Helpers\Form\Legend;
use TheFramework\Helpers\Form\Input\Text;
use TheFramework\Helpers\Form\Label;

(new Form())->show_opentag();
$oFs = new Fieldset();
$oLeg = new Legend("Información Personal");

$oLbl1 = new Label();
$oLbl1->set_innerhtml("Nombre:");
$oTxt1 = new Text("nombre","nombre");
$oTxt1->add_extras("tabindex","1");
$oTxt1->set_label($oLbl1);

$oLbl2 = new Label();
$oLbl2->set_innerhtml("Apellidos:");
$oTxt2 = new Text("nombre","nombre");
$oTxt2->add_extras("tabindex","2");
$oTxt2->set_label($oLbl2);

$oFs->add_inner_object($oLeg);
$oFs->add_inner_object($oTxt1);
$oFs->add_inner_object($oTxt2);
$oFs->show();
(new Form())->show_closetag();

?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
