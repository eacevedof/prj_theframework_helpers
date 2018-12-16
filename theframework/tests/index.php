<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

<?php
//index.php
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Script;
use TheFramework\Helpers\Vendor\GoogleMaps3;

$oScript = new Script();
$sPathFrom = realpath(__DIR__."/../helpers/src/Vendor/Google/GoogleMaps3.js");
$sPathTo = realpath(__DIR__."/js/");
if($sPathTo) $sPathTo .= DIRECTORY_SEPARATOR."GoogleMaps3.js";
$oScript->add_public($sPathFrom,$sPathTo);
$oScript->move_topublic();
$oScript->add_src("/js/GoogleMaps3.js");



$oGoogleMap3 = new GoogleMaps3($arTrayecto);
$oGoogleMap3->set_zoom(2);
//$oGoogleMap3->get_latlong_from_address(array("pais"=>"Espa�a","direccion"=>"Conde de Pe�alver 32", "zona"=>"Madrid", "cp"=>"28006"));
/**/
//bug($oGoogleMap3->get_url_signed("http://maps.googleapis.com/maps/api/js?sensor=false&client=$config_google_clientid", $config_google_cryptokey));
//devuelve : http://maps.googleapis.com/maps/api/js?sensor=false&client=gme-telynetsa&signature=6mBkaXZ7zfF9Je5rviTegiys-mA=
$oGoogleMap3->set_client_id($config_google_clientid);
$oGoogleMap3->set_channel("adeccorot");
/**/
//$oGoogleMap3->draw_lines();
$oGoogleMap3->set_size_container(795,475);
$oGoogleMap3->no_google_jquery();
$oGoogleMap3->draw_routes();

//SE DIBUJA EL MAPA
$oGoogleMap3->draw_map();
?>
<div id="divMap"></div>
<?php
$oScript->show_htmlsrc();
?>