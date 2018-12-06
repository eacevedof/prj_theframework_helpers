<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use \TheFramework\Helpers\Html\Div;

$oDiv = new Div();
$oDiv->set_innerhtml("gato");
$oDiv->show();

?>
<script type="text/javascript">
//fuente: https://stackoverflow.com/questions/4644027/how-to-automatically-reload-a-page-after-a-given-period-of-inactivity
var iTimeSec = 10

iTimeSec = iTimeSec * (1000)
var iThread = setTimeout("location.reload(true);",iTimeSec)
console.log("iThread:",iThread)

function resetTimeout(){
    consolo.log("Removing thread:",iThread)
    clearTimeout(iThread);
    iThread = setTimeout("location.reload(true);",iTimeSec)
}//resetTimeout
</script>