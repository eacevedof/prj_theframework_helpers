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
var iThread = setTimeout("location.reload(true);",10000);
console.log("iThread:",iThread)

function resetTimeout(){
    consolo.log("Removing thread:",iThread)
    clearTimeout(iThread);
    iThread = setTimeout("location.reload(true);",10000);
}
</script>