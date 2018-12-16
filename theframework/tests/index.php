<!-- hot reload -->
<meta http-equiv="refresh" content="500">
<a href="https://github.com/eacevedof/prj_theframework_helpers/tree/develop" target="_blank">Repo</a>
<a href="https://github.com/eacevedof/prj_theframework_helpers/blob/develop/theframework/helpers/EXAMPLES.md" target="_blank">Examples</a>
<pre>php -S localhost:3000 -t tests</pre>

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

$oGoogleMap = new GoogleMaps();

?>
<!DOCTYPE html>
<html>
  <head>
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: -25.344, lng: 131.036};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjgTpYTwwgJtthbRh3vYZUS1xkpC-bf0k&callback=initMap">
    </script>
  </body>
</html>