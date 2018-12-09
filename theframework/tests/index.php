<!-- hot reload -->
<meta http-equiv="refresh" content="5">
<?php
//index.php
//include_once "../components/autoload.php";
include_once "../helpers/autoload_nc.php";

use TheFramework\Helpers\Html\Table\Tr;
use TheFramework\Helpers\Html\Table\Td;
use TheFramework\Helpers\Html\Table\Table;

$arData = [
    0 => ["col0"=>"val_r0_col_0","col1"=>"val_r0_col_1","col2"=>"val_r0_col_2"],
    1 => ["col0"=>"val_r1_col_0","col1"=>"val_r1_col_1","col2"=>"val_r1_col_2"],
    2 => ["col0"=>"val_r2_col_0","col1"=>"val_r2_col_1","col2"=>"val_r2_col_2"]    
];

$arLabel = ["colName0" ,"colName1" ,"colName2"];

$arTrs = [];

$oTr = new Tr();
foreach($arLabel as $sLabel)
{
    $oTh = new Td();
    $oTh->set_type("th");
    $oTh->set_comments(" this is a comment before Th");
    $oTh->set_js_onclick("alert('clicked on {$sLabel}')");
    $oTh->set_innerhtml($sLabel);
    $oTr->add_td($oTh);
}
$arTrs[] = $oTr;

foreach($arData as $iRow=>$arRow)
{
    $oTr = new Tr();
    $oTr->set_attr_rownumber($iRow);
    foreach($arRow as $sFieldName=>$sFieldValue)
    {
        $oTd = new Td();
        if($iRow==0)
            $oTd->add_style("border:1px solid red");
        elseif($iRow==1)
            $oTd->add_style("border:1px solid green");
        else
            $oTd->add_style("border:1px solid blue");

        $oTd->set_attr_rownumber($iRow);
        $oTd->set_attr_colnumber($sFieldName);
        $oTd->set_innerhtml($sFieldValue);
        $oTr->add_td($oTd);
    }
    $arTrs[] = $oTr;
}//foreach


//$oHlpTable = new Raw($arData); //works fine
$oHlpTable = new Table($arTrs,"someTblId");
$oHlpTable->add_style("background:#cccccc");
$oHlpTable->add_style("border:1px dashed #FF0000");
$oHlpTable->show();
?>
