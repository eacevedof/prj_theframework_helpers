<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Anchor;

$arLinks = [
    "blank"=>["href"=>"https://github.com/eacevedof","innerhtml"=>"My Github (blank)"],
    "self" =>["href"=>"http://theframework.es","innerhtml"=>"Site example (self)"]
];

foreach($arLinks as $sTarget => $arLink)
{
    $sHref = $arLink["href"];
    $sInnerHtml = $arLink["innerhtml"];
    $oAnchor = new Anchor($sInnerHtml);
    $oAnchor->set_href($sHref);
    $oAnchor->add_style("background:yellow");
    if($sTarget=="blank")
        $oAnchor->add_style("background:#99FF00");
    $oAnchor->set_target($sTarget);
    $oAnchor->show();
    echo "<br/>";
}

?>
