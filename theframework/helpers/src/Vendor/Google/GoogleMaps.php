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
        $this->arMarkers = [];
        $this->sApikey = $sApikey;
        $this->load_map_attribs();
    }
    
    private function load_map_attribs()
    {
        $this->sDivId = "map";
        $this->sDivHeight = "400px";
        $this->sDivWidth = "100%";
    }
    
    public function get_markers(){return $this->arMarkers;}
    public function get_markers_injs()
    {
        $arJs = [];
        foreach($this->arMarkers as $i=>$arMarker)
        {
            $j = $i+1;
            $sText = isset($arMarker["text"])?$arMarker["text"]:"";
            $sLat = isset($arMarker["lat"])?$arMarker["lat"]:"0.0";
            $sLong = isset($arMarker["long"])?$arMarker["long"]:"0.0";

            $arJs[] = "['$sText',$sLat,$sLong,$j]";
        }
        if($arJs)
            return "[".implode(",",$arJs)."];";
        return "[];";
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
            var arMarkers = <?= $this->get_markers_injs();?>
            let eDivMap = document.getElementById("<?= $this->sDivId ?>");
            let oMap = new google.maps.Map(eDivMap,{
                zoom: 10,
                center: new google.maps.LatLng(-33.92, 151.25),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

        var oMarker, i;

        for (i = 0; i < arMarkers.length; i++) 
        {  
            oMarker = new google.maps.Marker({
                position: new google.maps.LatLng(arMarkers[i][1], arMarkers[i][2]),
                map: oMap
            });

            google.maps.event.addListener(oMarker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent(arMarkers[i][0]);
                infowindow.open(map, marker);
            }
            })(oMarker, i));
        }
    }//initMap()
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
