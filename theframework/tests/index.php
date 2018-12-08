<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Textarea;
use TheFramework\Helpers\Form\Input\Generic;
use TheFramework\Helpers\Form\Label;

$oForm = new Form("SomeFormId");
$oForm->set_method("post");
$oLabel = new Label("idTextarea","Type your article:");
$oTextarea = new Textarea("idTextarea","nameTextarea");
$oTextarea->set_innerhtml("this is an example text");
$oTextarea->add_extras("autofocus");
$oTextarea->set_label($oLabel);
$oTextarea->set_maxlength(25);
//$oTextarea->set_counterspan(); //activa render de <span> contador </span>
//renderiza js que gestiona maxlength y actualiza span contador, tiene que estar activado counterspan
//$oTextarea->set_counterjs();
//$oTextarea->readonly();
$oButton = new Generic("Save");
$oButton->add_extras("type","submit");
$oForm->add_control($oTextarea);
$oForm->add_control($oButton);
$oForm->show();
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
