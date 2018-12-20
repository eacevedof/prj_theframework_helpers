<!-- hot reload -->
<meta http-equiv="refresh" content="500">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t theframework/tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Script;
use TheFramework\Helpers\Vendor\Google\GoogleMaps;

$oScript = new Script();
$sPathFrom = realpath(__DIR__."/../helpers/src/Vendor/Google/GoogleMaps3.js");
$sPathTo = realpath(__DIR__."/js/");
if($sPathTo) $sPathTo .= DIRECTORY_SEPARATOR."GoogleMaps3.js";
$oScript->add_public($sPathFrom,$sPathTo);
$oScript->move_topublic();
$oScript->add_src("/js/GoogleMaps3.js");

$oGoogleMap = new GoogleMaps("AIzaSyDjgTpYTwwgJtthbRh3vYZUS1xkpC-bf0k");

$oGoogleMap->add_marker("-33.950198","151.259302","Maroubra Beach");
$oGoogleMap->add_marker("-33.923036","151.259052","Coogee Beach");
$oGoogleMap->add_marker("-34.028249","151.157507","Cronulla Beach");
$oGoogleMap->add_marker("-33.80010128657071","151.28747820854187","Manly Beach");
$oGoogleMap->add_marker("-33.890542","151.274856","Bondi Beach");
?>
<!DOCTYPE html>
<html>
<head>
<?php
$oGoogleMap->show_style();
?>
</head>
<body>
    <h3>My Google Maps Demo</h3>
<?php
$oGoogleMap->show_div();
?>
</body>
</html>