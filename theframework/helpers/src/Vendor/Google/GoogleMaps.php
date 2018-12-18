<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name TheFramework\Helpers\Vendor\GoogleMaps  
 * @date 16-12-2018 17:53
 * @file GoogleMaps.php
 */
namespace TheFramework\Helpers\Vendor\Google;

class GoogleMaps
{
    
    private $sApikey;
    private $sDivId;
    private $sDivWidth;
    private $sDivHeight;

    private $arMarkers;
    
    public function __construct($sApikey="") 
    {
        $this->sApikey = $sApikey;
        $this->load_map_attribs();
    }
    
    private function load_map_attribs()
    {
        $this->sDivId = "map";
        $this->sDivHeight = "400px";
        $this->sDivWidth = "100%";
    }
    
    public function show_style()
    {
?>
<style>
    /* Set the size of the div element that contains the map */
    #<?= $this->sDivId; ?> {
        height: <?= $this->sDivHeight; ?>;  /* The height is 400 pixels */
        width: <?= $this->sDivWidth; ?>;  /* The width is the width of the web page */
    }
</style>
<?php
    }//show_style
    
    public function show_div()
    {
?>
    <!--The div element for the map -->
    <div id="<?= $this->sDivId ?>"></div>
    <script>
    //https://stackoverflow.com/questions/3059044/google-maps-js-api-v3-simple-multiple-marker-example
        // Initialize and add the map
        function initMap()
        {
            var locations = [
      ['Bondi Beach', -33.890542, 151.274856, 4],
      ['Coogee Beach', -33.923036, 151.259052, 5],
      ['Cronulla Beach', -34.028249, 151.157507, 3],
      ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
        }
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $this->sApikey; ?>&callback=initMap"></script>
<?php
    }//show_div
    
    public function set_aplikey($sKey){$this->sApikey=$sKey;}
    public function add_marker($sLat,$sLong,$sText=""){$this->arMarkers[]=["text"=>$sText,"lat"=>$sLat,"long"=>$sLong];}

}//GoogleMaps
