<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Div;
use TheFramework\Helpers\Html\Xl\Xl;
use TheFramework\Helpers\Html\Xl\Li;

$oDivMain = new Div("","divMain");
$oDivMain->add_style("border:1px dashed blue");

$oUl = new Xl();
$oUl->add_li((new Li("Item One")));
$oUl->add_li((new Li("Item Two")));
$oUl->add_li((new Li("Item Three")));

$oDiv1 = new Div();
$oDiv1->set_id("divOne");
$oDiv1->add_style("background:#ccc");
$oDiv1->add_inner_object($oUl);

$oDiv2 = new Div("","divTwo");
$oDiv2->add_style("border:1px solid magenta");
$oDiv2->add_inner_object("this is a simple text");

$oDivMain->add_inner_object($oDiv1);
$oDivMain->add_inner_object($oDiv2);

$oDivMain->show();

?>
