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
use TheFramework\Helpers\Html\Image;

$arImages = [
    ["src"=>"","alt"=>"","title"=>"","text"=>""],
    ["src"=>"","alt"=>"","title"=>"","text"=>""],
    ["src"=>"","alt"=>"","title"=>"","text"=>""],
];

$arObj = [];

foreach($arImages as $i=>$arImage)
{
    $sSrc = $arImage["src"];
    $sAlt = $arImage["alt"];
    $sTitle = $arImage["title"];
    $sText = $arImage["text"];

    $oImage = new Image();
    $oImage->set_src($sSrc);
    $oImage->set_alt($sAlt);
    $oImage->set_title($sAlt);
    $oImage->set_text($sText);

    $arObj[] = $oImage;
}//foreach





?>
