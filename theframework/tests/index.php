<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Xl\Xl;
use TheFramework\Helpers\Html\Xl\Li;

$arItems = [
    0 => "list item 0",1 => "list item 1"
    ,2 => "list item 2",3 => "list item 3",
];

$oUl = new Xl();
$oUl->add_style("background:grey");
$oUl->add_style("width:100px");

$oOl = new Xl();
$oOl->set_type("ol");
$oOl->add_style("background:yellow;width:200px;");

foreach($arItems as $i=>$sText)
{
    $oLi = new Li($sText);
    $oLi->add_style("border:1px dashed green");
    $oUl->add_li($oLi);
    $oOl->add_li($oLi);
}//foreach

echo "Unordered List (ul):<br/>";
$oUl->show();
echo "Ordered List (ol):<br/>";
$oOl->show();



?>
