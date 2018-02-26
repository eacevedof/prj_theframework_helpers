<?php
//404.php 1.0.1
$sRequestUri = $_SERVER["REQUEST_URI"];
//bug($sRequestUri);
//helper-span -> helper-span/examples

//bugg();
$sText = "Home";
$sUrl = "/";

$arMap = [
    "helperspan"=>"helper-span","helperselect"=>"helper-select","helperimagelist"=>"helper-imagelist",
    "helperselect"=>"helper-select","helperulli"=>"helper-ul-li","helperform"=>"helper-form",
    "helperfpdfcell"=>"helper-fpdf-cell","helperanchor"=>"helper-anchor","helperinputfile"=>"helper-input-file",
    "helpertabletd"=>"helper-table-td","helperinputpassword"=>"helper-input-password","helpergooglemaps3"=>"helper-googlemaps-3",
];

if(strstr($sRequestUri,"content"))
{
    $sClassName = (isset($_GET["content"])?$_GET["content"]:"");
    if($sClassName)
    {
        $sClassName = (isset($arMap[$sClassName])?$arMap[$sClassName]:"");
        if($sClassName)
        {
            $sText = "Go to content of $sClassName";
            $sUrl = "http://helpers.theframework.es/$sClassName/";
        }
    }
}
elseif(strstr($sRequestUri,"example"))
{
    $sClassName = (isset($_GET["example"])?$_GET["example"]:"");
    if($sClassName)
    {
        $sClassName = (isset($arMap[$sClassName])?$arMap[$sClassName]:"");
        if($sClassName)
        {
            $sText = "Go to examples of <br/> $sClassName";
            $sUrl = "http://helpers.theframework.es/$sClassName/examples/";
        }
    }    
}

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<style type="text/css">
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>Oops!</h1>
                <h2>404 Not Found</h2>
                <div class="error-details">
                    Sorry, an error has occured. Requested page not found!
                </div>
                <div class="error-actions">
                    <a href="<?php s($sUrl)?>" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-home"></span> <?php s($sText)?>
                    </a>
                    <a href="https://twitter.com/eacevedof" rel="nofollow" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-envelope"></span> @eacevedof 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>