<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Span;

$oSpan = new Span();
$oSpan->set_id("idSpan1");
$oSpan->add_extras("title","Some title for span one");
$oSpan->add_style("border:1px solid green");
if($oSpan->get_id()=="idSpan1")
    $oSpan->add_style("background:yellow");
$oSpan->add_inner_object("What is Lorem Ipsum?");
$oSpan->show();
?>
