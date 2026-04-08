<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Vendor\Google;

final class GoogleMaps
{
    private string $apikey = "";
    private array $markers = [];
    private array $div = [];
    private array $center = [];

    public function __construct(string $apikey = "")
    {
        $this->div = [];
        $this->markers = [];
        $this->center = [];
        $this->apikey = $apikey;
        $this->center[0] = ["lat" => "0.0", "long" => "0.0"];
        $this->loadAttrDiv();
    }

    private function loadAttrDiv(): void
    {
        $this->div["id"] = "map";
        $this->div["height"] = "400px";
        $this->div["width"] = "100%";
        $this->div["margin"] = "0";
        $this->div["padding"] = "0";
    }

    public function getMarkers(): array
    {
        return $this->markers;
    }

    public function getMarkersInjs(): string
    {
        $jsParts = [];
        foreach ($this->markers as $i => $marker) {
            $j = $i + 1;
            $text = $marker["text"] ?? "";
            $lat = $marker["lat"] ?? "0.0";
            $long = $marker["long"] ?? "0.0";
            $jsParts[] = "['{$text}',{$lat},{$long},{$j}]";
        }
        if ($jsParts) {
            return "[" . implode(",", $jsParts) . "];";
        }
        return "[];";
    }

    public function showStyle(): void
    {
?>
<style>
    #<?= $this->div["id"]; ?> {
        height: <?= $this->div["height"]; ?>;
        width: <?= $this->div["width"]; ?>;
        margin: <?= $this->div["margin"]; ?>;
        padding: <?= $this->div["padding"]; ?>;
    }
</style>
<?php
    }

    public function drawLines(): void
    {
    }

    public function showDiv(): void
    {
?>
    <div id="<?= $this->div["id"]; ?>"></div>
    <script>
    function initMap()
    {
        var oInfoWindow = new google.maps.InfoWindow();

        var oMarker, i;
        var oRequest = {
            travelMode: google.maps.TravelMode.DRIVING
        };

        let arMarkers = <?= $this->getMarkersInjs(); ?>
        let eDivMap = document.getElementById("<?= $this->div["id"]; ?>");
        let oMap = new google.maps.Map(eDivMap,{
            zoom: 10,
            center: new google.maps.LatLng(<?= $this->center[0]["lat"]; ?>,<?= $this->center[0]["long"]; ?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        for(i=0; i<arMarkers.length; i++)
        {
            oMarker = new google.maps.Marker({
                position: new google.maps.LatLng(arMarkers[i][1], arMarkers[i][2]),
                map: oMap
            });

            google.maps.event.addListener(oMarker,'click',(function(marker,i){
                return function() {
                    oInfoWindow.setContent(arMarkers[i][0]);
                    oInfoWindow.open(oMap,marker);
                }
            })(oMarker,i));
        }
    }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $this->apikey; ?>&callback=initMap"></script>
<?php
    }

    public function setApikey(string $key): void
    {
        $this->apikey = $key;
    }

    public function addAttrDiv(string $key, mixed $value): void
    {
        $this->div[$key] = $value;
    }

    public function addMarker(string $lat, string $long, string $text = ""): void
    {
        $this->markers[] = ["text" => $text, "lat" => $lat, "long" => $long];
    }

    public function setCenter(string $lat, string $long): void
    {
        $this->center[0] = ["lat" => $lat, "long" => $long];
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
