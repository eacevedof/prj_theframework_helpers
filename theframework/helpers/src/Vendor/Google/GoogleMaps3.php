<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Vendor\GoogleMaps3
 */
namespace TheFramework\Helpers\Vendor;

final class GoogleMaps3
{
    private string $signature = "";
    private bool $useSignature = false;
    private string $criptokey = "";
    private bool $useCriptoKey = false;
    private string $clientId = "";
    private string $channel = "";
    private string $apikey = "";
    private bool $useApikey = true;
    private bool $useGoogleJquery = true;

    private string $mapType = "'roadmap'";
    private float $latitude = 40.41694;
    private float $longitude = -3.70361;
    private int $zoom = 6;

    private string $markers = "[]";
    private bool $useMakersNumbers = true;
    private string $markerColor = "green";
    private bool $drawLinesEnabled = false;

    private string $idDivContainer = "'map_canvas'";
    private int $width = 800;
    private int $height = 600;
    private string $unitWH = "px";

    private string $routeMode = "driving";
    private bool $drawRoutesEnabled = false;
    private string $routeColor = "green";
    private float $routeAlpha = 0.5;
    private int $routeWidth = 3;

    private string $urlApiDistanceMatrix = "http://maps.googleapis.com/maps/api/distancematrix/xml?";
    private string $urlApiGeocode = "http://maps.googleapis.com/maps/api/geocode/xml";
    private bool $doNarrowSearch = true;
    private array $narrowLat = ["min" => 35, "max" => 43];
    private array $narrowLong = ["min" => -9, "max" => 4];

    private array $addresses = [];
    private bool $useDelay = true;
    private int $delayTime = 250;

    private bool $isError = false;
    private string $message = "";
    private array $routes = [];

    public function __construct(array $routes = [], array $addresses = [], string $apikey = "")
    {
        $this->routes = $routes;
        $this->addresses = $addresses;
        if (!empty($apikey)) {
            $this->apikey = $apikey;
        }
    }

    public function drawMap(): void
    {
        if ($this->useGoogleJquery) {
            $this->showGoogleJqueryTag();
        }
        $this->showJsapiV3Tag();
?>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/styledmarker/src/StyledMarker.js"></script>
<script type="text/javascript">
    gmaps3.config.sMapType = <?php $this->echoMaptype(); ?>;
    gmaps3.config.fLatitude = <?php $this->echoLatitude(); ?>;
    gmaps3.config.fLongitude = <?php $this->echoLongitude(); ?>;
    gmaps3.config.iZoom = <?php $this->echoZoom(); ?>;
    gmaps3.config.arRoutes = <?php $this->showJsArrayRoutes(); ?>;
    gmaps3.config.useMarkersNumbers = <?php $this->echoIsMakersWithNumbers(); ?>;
    gmaps3.config.drawLines = <?php $this->echoDoDrawLines(); ?>;
    gmaps3.config.sIdDivContainer = <?php $this->echoDivContainer(); ?>;
    gmaps3.config.iHeight = <?php $this->echoHeight(); ?>;
    gmaps3.config.iWidth = <?php $this->echoWidth(); ?>;
    gmaps3.config.sUnitWH = <?php $this->echoSizeUnit(); ?>;
    gmaps3.config.sRouteMode = <?php $this->echoRoutetype(); ?>;
    gmaps3.config.drawRoutes = <?php $this->echoDoDrawRoutes(); ?>;
    gmaps3.config.sRouteColor = <?php $this->echoRouteColor(); ?>;
    gmaps3.config.iRouteWidth = <?php $this->echoRouteWidth(); ?>;
    gmaps3.config.fRouteAlpha = <?php $this->echoRouteAlpha(); ?>;

    jQuery(document).ready(gmaps3.load_map);
</script>
<?php
    }

    public function showJsArrayRoutes(): void
    {
        echo $this->getJsAsArrayFromRoutes();
    }

    private function getJsAsArrayFromRoutes(): string
    {
        $jsRoutes = [];
        $jsArray = "[";
        foreach ($this->routes as $routeData) {
            $jsRoute = "[";
            $jsRoute .= $this->getJsAsArrayTableFromMarkers($routeData["dots"]);
            $jsRoute .= "," . $this->getJsAsArrayListOfStops($routeData["stops"]);
            $jsRoute .= "," . $this->getAsJsString($routeData["pincolor"]);
            $jsRoute .= "," . $this->getAsJsString($routeData["tracecolor"]);
            $jsRoute .= "]";
            $jsRoutes[] = $jsRoute;
        }
        if (!empty($jsRoutes)) {
            $jsArray .= implode(",", $jsRoutes);
        }
        $jsArray .= "]";
        return $jsArray;
    }

    private function getJsAsArrayTableFromMarkers(array $markers): string
    {
        $items = [];
        $jsArray = "[";
        foreach ($markers as $row) {
            $items[] = $this->getAsJsArrayRow($row);
        }
        if (!empty($items)) {
            $jsArray .= implode(",", $items);
        }
        $jsArray .= "]";
        return $jsArray;
    }

    private function getJsAsArrayListOfStops(array $stops): string
    {
        $jsArray = "[";
        $jsArray .= implode(",", $stops);
        $jsArray .= "]";
        return $jsArray;
    }

    private function getAsJsArrayRow(array $rowMarker = []): string
    {
        $items = [];
        $jsArray = "[";
        foreach ($rowMarker as $key => $fieldValue) {
            $jsValue = $this->getMarkerFieldAsJsValue($key, $fieldValue);
            if ($jsValue === null) {
                continue;
            }
            $items[] = $jsValue;
        }
        if (!empty($items)) {
            $jsArray .= implode(",", $items);
        }
        $jsArray .= "]\n";
        return $jsArray;
    }

    private function getMarkerFieldAsJsValue(string $key, mixed $fieldValue): mixed
    {
        if (in_array($key, ["content", "title"])) {
            return $this->getAsJsString($fieldValue);
        }

        if (in_array($key, ["number", "latitude", "longitude", "zindex"])) {
            return $fieldValue;
        }

        return null;
    }

    private function getAsJsString(string $value): string
    {
        return "'{$value}'";
    }

    public function calculateDistance(array $point1, array $point2): float
    {
        $x1 = $point1["latitude"];
        $y1 = $point1["longitude"];
        $x2 = $point2["latitude"];
        $y2 = $point2["longitude"];

        if (!$this->areValidCoordinates($x1, $y1, $x2, $y2)) {
            return (float)round($x1, 2);
        }

        $distance = sqrt(pow(($x1 - $x2), 2) + pow(($y1 - $y2), 2));
        return (float)round($distance, 2);
    }

    private function areValidCoordinates(mixed $x1, mixed $y1, mixed $x2, mixed $y2): bool
    {
        return is_numeric($x1) && is_numeric($y1) && is_numeric($x2) && is_numeric($y2);
    }

    public function getDistanceAndTime(array $point1, array $point2): array
    {
        $timeDistance = ["time" => "", "distance" => ""];
        $urlDistanceOrig = $this->buildDistanceMatrixUrl($point1, $point2);
        $urlDistanceSigned = $this->getUrlByKeypriority($urlDistanceOrig);

        $xml = simplexml_load_file($urlDistanceSigned);
        if ($xml === false) {
            $this->writeLog($urlDistanceSigned, "distancematrix error obtencion xml");
            $urlDistanceSigned = $urlDistanceOrig;
            $xml = simplexml_load_file($urlDistanceSigned);
        }

        if ($xml === false) {
            $this->setMessageError("Could not create xml from: {$urlDistanceSigned}");
            $this->writeLog($urlDistanceSigned, "distancematrix error obtencion xml");
            return $timeDistance;
        }

        $xmlStatus = $xml->status;
        if (strcmp($xmlStatus, "OK") !== 0) {
            $this->setMessageError("Distance calculation failed. Status={$xmlStatus}");
            $this->writeLog($urlDistanceSigned, "distancematrix xml status fallido");
            return $timeDistance;
        }

        $timeDistance = $this->parseDistanceMatrixXml($xml);
        $this->writeLog($urlDistanceSigned, "distancematrix ok");
        return $timeDistance;
    }

    private function buildDistanceMatrixUrl(array $point1, array $point2): string
    {
        $x1 = $point1["latitude"];
        $y1 = $point1["longitude"];
        $x2 = $point2["latitude"];
        $y2 = $point2["longitude"];

        $params = [];
        if (!empty($this->clientId)) {
            $params["clientid"] = "client={$this->clientId}";
        }
        if (!empty($this->channel)) {
            $params["channel"] = "channel={$this->channel}";
        }
        $params["sensor"] = "sensor=false";
        $params["origins"] = "origins={$x1},{$y1}";
        $params["destinations"] = "destinations={$x2},{$y2}";
        $params["mode"] = "mode=driving";
        $params["language"] = "language=es-ES";

        return $this->urlApiDistanceMatrix . implode("&", $params);
    }

    private function parseDistanceMatrixXml(object $xml): array
    {
        $timeDistance = ["time" => "", "distance" => ""];
        $timeDistance["time"]["min"] = (string)$xml->row->element->duration->text;
        $timeDistance["time"]["sec"] = (string)$xml->row->element->duration->value;
        $timeDistance["distance"]["m"] = (string)$xml->row->element->distance->value;

        $distanceInKm = ((float)$timeDistance["distance"]["m"]) / 1000;
        $distanceInKm = number_format($distanceInKm, 3);
        $timeDistance["distance"]["fkm"] = $distanceInKm;
        $timeDistance["distance"]["km"] = number_format((float)$distanceInKm, 2);
        $timeDistance["distance"]["km"] = str_replace(".", ",", $timeDistance["distance"]["km"]);
        $timeDistance["distance"]["km"] .= " km";

        return $timeDistance;
    }

    private function writeLog(string $url, string $message): void
    {
        if (function_exists('writelog')) {
            writelog("bd_ask", $url, $message);
        }
    }

    public function sumDistance(): float
    {
        $point1 = ["latitude" => 0, "longitude" => 0];
        $point2 = ["latitude" => 0, "longitude" => 0];
        $numMarkers = count($this->markers);
        $distance = 0;
        for ($i = 0; $i < $numMarkers - 1; $i++) {
            $point1["latitude"] = $this->markers[$i]["latitude"];
            $point1["longitude"] = $this->markers[$i]["longitude"];
            $point2["latitude"] = $this->markers[$i + 1]["latitude"];
            $point2["longitude"] = $this->markers[$i + 1]["longitude"];
            $distance += $this->calculateDistance($point1, $point2);
        }
        return (float)$distance;
    }

    private function isDistanceInKm(string $text): bool
    {
        return strpos($text, "km") !== false;
    }

    private function encodeBase64UrlSafe(string $value): string
    {
        return str_replace(["+", "/"], ["-", "_"], base64_encode($value));
    }

    private function decodeBase64UrlSafe(string $value): string
    {
        return base64_decode(str_replace(["-", "_"], ["+", "/"], $value));
    }

    public function getEncodedSignature(string $urlEncoded, string $cryptokey): string
    {
        $urlComponents = parse_url($urlEncoded);
        $urlPartToSign = $urlComponents["path"] . "?" . $urlComponents["query"];
        $binDecodedCryptokey = $this->decodeBase64UrlSafe($cryptokey);
        $signature = hash_hmac("sha1", $urlPartToSign, $binDecodedCryptokey, true);
        return $this->encodeBase64UrlSafe($signature);
    }

    public function getUrlSigned(string $urlEncoded, string $cryptokey): string
    {
        $encodedSignature = $this->getEncodedSignature($urlEncoded, $cryptokey);
        return $urlEncoded . "&signature=" . $encodedSignature;
    }

    private function getUrlByKeypriority(string $urlEncoded): string
    {
        if (empty($urlEncoded)) {
            return $urlEncoded;
        }

        if (!empty($this->signature) && $this->useSignature) {
            return $urlEncoded . "&client={$this->clientId}&signature={$this->signature}";
        }

        if (!empty($this->criptokey) && $this->useCriptoKey) {
            $this->signature = $this->getEncodedSignature($urlEncoded, $this->criptokey);
            return $urlEncoded . "&signature={$this->signature}";
        }

        if (!empty($this->apikey) && $this->useApikey) {
            return $urlEncoded . "&key={$this->apikey}";
        }

        return $urlEncoded;
    }

    public function showUrlByKeypriority(string $urlEncoded): void
    {
        echo $this->getUrlByKeypriority($urlEncoded);
    }

    public function showGoogleJqueryTag(): void
    {
        echo $this->getGoogleJquery();
    }

    public function showApikeyTag(): void
    {
        echo $this->getApikeyTag();
    }

    public function getMarkers(): string
    {
        return $this->markers;
    }

    public function echoIsMakersWithNumbers(): void
    {
        echo $this->useMakersNumbers ? "true" : "false";
    }

    public function echoDoDrawLines(): void
    {
        echo $this->drawLinesEnabled ? "true" : "false";
    }

    private function echoDoDrawRoutes(): void
    {
        echo $this->drawRoutesEnabled ? "true" : "false";
    }

    public function getLatlongFromAddress(array $address): array
    {
        $ll = ["latitude" => "", "longitude" => ""];
        if (empty($address)) {
            return $ll;
        }

        $urlApiGeocode = $this->buildGeocodeUrl($address);
        $xml = simplexml_load_file($urlApiGeocode);
        $this->applyDelay();

        if ($xml === false) {
            $this->setMessageError("Could not create xml from: {$urlApiGeocode}");
            return $ll;
        }

        $xmlStatus = $xml->status;
        if (strcmp($xmlStatus, "OK") !== 0) {
            $this->setMessageError("Address could not be geolocated. Status={$xmlStatus}");
            return $ll;
        }

        $latitude = (float)$xml->result->geometry->location->lat;
        $longitude = (float)$xml->result->geometry->location->lng;

        if ($this->doNarrowSearch && !$this->isInRangeLatLong($latitude, $longitude)) {
            $this->setMessageError("Address out of range: Lat:{$latitude}, Long:{$longitude}");
            return $ll;
        }

        $ll["latitude"] = $latitude;
        $ll["longitude"] = $longitude;
        $this->message = "Address found";
        return $ll;
    }

    private function buildGeocodeUrl(array $address): string
    {
        $addrForUrl = join(", ", $address);
        $addrForUrl = utf8_encode($addrForUrl);
        $addrForUrl = urldecode($addrForUrl);
        $addrForUrl = str_replace(" ", "+", $addrForUrl);
        return $this->urlApiGeocode . "?address=" . $addrForUrl . "&sensor=false";
    }

    private function applyDelay(): void
    {
        if ($this->useDelay) {
            usleep($this->delayTime);
        }
    }

    private function isInRangeLatLong(float $latitude = 0.0, float $longitude = 0.0): bool
    {
        return (
            $this->compareFloat($latitude, "<", $this->narrowLat["max"]) &&
            $this->compareFloat($this->narrowLat["min"], "<", $latitude) &&
            $this->compareFloat($longitude, "<", $this->narrowLong["max"]) &&
            $this->compareFloat($this->narrowLong["min"], "<", $longitude)
        );
    }

    private function compareFloat(float $float1, string $operator = "=", float $float2 = 0.0, int $precision = 10): bool|string
    {
        switch (trim($operator)) {
            case "=":
                return bccomp($float1, $float2, $precision) === 0;
            case "<":
                return bccomp($float1, $float2, $precision) === -1;
            case ">":
                return bccomp($float1, $float2, $precision) === 1;
            case "!=":
                return !$this->compareFloat($float1, "=", $float2, $precision);
            case ">=":
                return $this->compareFloat($float1, ">", $float2, $precision)
                    || $this->compareFloat($float1, "=", $float2, $precision);
            case "<=":
                return $this->compareFloat($float1, "<", $float2, $precision)
                    || $this->compareFloat($float1, "=", $float2, $precision);
            default:
                return "operator error";
        }
    }

    public function getGoogleJquery(): string
    {
        return "<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js\"></script>\n";
    }

    public function getApikeyTag(): string
    {
        if (empty($this->apikey)) {
            return "<script type=\"text/javascript\" src=\"noapikeysuplied\"></script>";
        }
        return "<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?v=3&sensor=false\"></script>\n";
    }

    public function getJsapiV3Tag(): string
    {
        $urlJsApi = "http://maps.googleapis.com/maps/api/js?v=3&sensor=false";
        if (!empty($this->clientId)) {
            $urlJsApi .= "&client={$this->clientId}";
        }
        if (!empty($this->channel)) {
            $urlJsApi .= "&channel={$this->channel}";
        }
        return "<script type=\"text/javascript\" src=\"{$urlJsApi}\"></script>\n";
    }

    public function showJsapiV3Tag(): void
    {
        echo $this->getJsapiV3Tag();
    }

    private function echoMaptype(): void
    {
        echo $this->mapType;
    }

    private function echoDivContainer(): void
    {
        echo $this->idDivContainer;
    }

    private function echoZoom(): void
    {
        echo $this->zoom;
    }

    private function echoLatitude(): void
    {
        echo $this->latitude;
    }

    private function echoLongitude(): void
    {
        echo $this->longitude;
    }

    private function echoHeight(): void
    {
        echo $this->height;
    }

    private function echoWidth(): void
    {
        echo $this->width;
    }

    private function echoSizeUnit(): void
    {
        echo "'{$this->unitWH}'";
    }

    private function echoRoutetype(): void
    {
        echo "'{$this->routeMode}'";
    }

    private function echoRouteColor(): void
    {
        echo "'{$this->routeColor}'";
    }

    private function echoRouteWidth(): void
    {
        echo $this->routeWidth;
    }

    private function echoRouteAlpha(): void
    {
        echo $this->routeAlpha;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getApikey(): string
    {
        return $this->apikey;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function setMarkers(array $markers = []): void
    {
        $this->markers = $markers;
    }

    public function setMarkersNumbersOff(bool $isOn = false): void
    {
        $this->useMakersNumbers = $isOn;
    }

    public function setMaptype(string $value): void
    {
        $this->mapType = strtolower("'{$value}'");
    }

    public function setDivContainer(string $value): void
    {
        $this->idDivContainer = "'{$value}'";
    }

    public function setZoom(int $zoom): void
    {
        $this->zoom = $zoom;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function drawLines(bool $isOn = true): void
    {
        $this->drawLinesEnabled = $isOn;
    }

    public function setSizeContainer(int $width = 800, int $height = 600): void
    {
        if (!empty($height)) {
            $this->height = $height;
        }
        if (!empty($width)) {
            $this->width = $width;
        }
    }

    public function setSizeUnit(string $type = "pt"): void
    {
        $this->unitWH = $type;
    }

    public function addAddress(array $address): void
    {
        $this->addresses[] = $address;
    }

    public function drawRoutes(bool $isOn = true): void
    {
        $this->drawRoutesEnabled = $isOn;
    }

    public function setRouteColor(string $color = "green"): void
    {
        $this->routeColor = $color;
    }

    public function setMarkerColor(string $color = "green"): void
    {
        $this->markerColor = $color;
    }

    public function setRoutetype(string $type = "driving"): void
    {
        $this->routeMode = $type;
    }

    public function setRouteWidth(int $width = 3): void
    {
        $this->routeWidth = $width;
    }

    public function setRouteAlpha(float $alpha = 0.5): void
    {
        $this->routeAlpha = $alpha;
    }

    private function setMessageError(string $message, bool $isError = true): void
    {
        $this->isError = $isError;
        $this->message = $message;
    }

    public function noNarrow(bool $isOn = false): void
    {
        $this->doNarrowSearch = $isOn;
    }

    public function setDelayTime(int $microSeconds): void
    {
        $this->delayTime = $microSeconds;
    }

    public function noDelay(bool $isOn = false): void
    {
        $this->useDelay = $isOn;
    }

    public function setApikey(string $apikey): void
    {
        $this->apikey = $apikey;
    }

    public function noAutoApikey(bool $isOn = false): void
    {
        $this->useApikey = $isOn;
    }

    public function noGoogleJquery(bool $isOn = false): void
    {
        $this->useGoogleJquery = $isOn;
    }

    public function setSignature(string $value): void
    {
        $this->signature = $value;
    }

    public function useSignature(bool $isOn = true): void
    {
        $this->useSignature = $isOn;
    }

    public function setCryptokey(string $value): void
    {
        $this->criptokey = $value;
    }

    public function useCryptokey(bool $isOn = true): void
    {
        $this->useCriptoKey = $isOn;
    }

    public function setClientid(string $id): void
    {
        $this->clientId = $id;
    }

    public function setChannel(string $channelJs): void
    {
        $this->channel = $channelJs;
    }
}
