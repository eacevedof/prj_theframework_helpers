<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Button;

$arButtons = [
    "submit" => "im a submitter",
    "reset" => "im a resetter",
    "button" => "im a common button"
];

foreach($arButtons as $sType=>$sInnerHtml)
    (new Button($sInnerHtml,$sType))->show();

echo "<br/><br/>";

foreach($arButtons as $sType=>$sInnerHtml)
{
    $oButton = new Button();
    $oButton->set_type($sType);

    $oButton->set_innerhtml($sInnerHtml);
    if($sType=="submit")
    {
        $oButton->set_style("background:red;color:white");
        $oButton->set_js_onclick("alert('submit.clicked')");
    }
    elseif($sType=="reset")
    {
        $oButton->set_style("background:green;color:white");
        $oButton->set_js_onmouseover("alert('reset.moseover')");
    }
    else 
    {
        $oButton->set_style("background:cyan");
        $oButton->set_js_onmouseout("alert('reset.mouseout')");
    }

    $oButton->show();    
}//foreach(arButtons)


?>
