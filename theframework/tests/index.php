<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Form\Form;
use TheFramework\Helpers\Form\Select;
use TheFramework\Helpers\Form\Input\Generic;
use TheFramework\Helpers\Form\Label;

/*
($id="", $name="", $method="post", $innerhtml=""
,$action="", $class="", $style="", $arExtras=array(), $enctype="", $onsubmit="")
*/
$oForm = new Form("SomeFormId");
$oForm->set_method("post");
$oLabel = new Label("POST-name","Select one:");
$oSelect = new Select([""=>"...","key1"=>"Txt 1","key2"=>"Txt 2","key3"=>"Txt 3","key4"=>"Txt 4"]);
$oSelect->set_label($oLabel);
//$oSelect->set_value_to_select("key3"); autoselect by key
//$oSelect->readonly(); //autoselect by key and removes other keys
$oButton = new Generic("Save");
$oButton->add_extras("type","submit");
$oForm->add_control($oSelect);
$oForm->add_control($oButton);
$oForm->show();
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
