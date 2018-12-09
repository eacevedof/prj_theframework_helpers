<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Table\Raw;

$arData = [
    0=>["col0"=>"val_r0_col_0"
    ,"col1"=>"val_r0_col_1"
    ,"col2"=>"val_r0_col_2"],
    1=>["col0"=>"val_r1_col_0"
    ,"col1"=>"val_r1_col_1"
    ,"col2"=>"val_r1_col_2"],
    2=>["col0"=>"val_r2_col_0"
    ,"col1"=>"val_r2_col_1"
    ,"col2"=>"val_r2_col_2"]    
];

$arLabel = ["colName0" ,"colName1" ,"colName2"];

//$oHlpTable = new Raw($arData); //works fine
$oHlpTable = new Raw($arData,$arLabel);
$oHlpTable->show();
?>
<!-- hot reload -->
<meta http-equiv="refresh" content="5">
