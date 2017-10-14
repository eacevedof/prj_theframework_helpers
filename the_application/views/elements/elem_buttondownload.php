<!--elem_buttondownload 1.0.4-->
<?php
use TheApplication\Components\ComponentDownload;
$oDownload = new ComponentDownload($oAppMain);
$arLatest = $oDownload->get_versions(1);
$sVersion = key($arLatest);
$sVersionDwl = str_replace(".","-",$sVersion);
//bug($sVersion);
$sReleased = $arLatest[$sVersion]["released"];

$sInnerText = "<b>DOWNLOAD version $sVersion</b><br/>"
        . "<small>released at $sReleased </small>";
?>
            <p>
                <a class="btn btn-primary btn-lg" href="/download/v-<?=$sVersionDwl?>/" role="button" rel="nofollow">
                    <?php s($sInnerText)?>
                </a>
            </p>
<!--/elem_buttondownload-->
