<!--view_versions 1.0.3-->
<?php

?>
<div class="col-lg-12">
    <br/>        
    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th>#</th><th>Release</th><th>Version</th>
        </tr>
        </thead>
        <tbody>
<?php
$i=0;
foreach($arVersions as $sVersion=>$arData):
    if(!$arData["published"])
        continue;
    $i++;
    $sVer = str_replace(".","-",$sVersion);
?>    
            <tr>
                <td><?=$i?></td>
                <td>
                    <?=$arData["released"]?> <small>(<?=$arData["counter"]?>)<small>
                </td>                
                <td>
                    <a class="btn btn-success" href="/download/v-<?=$sVer?>/" role="button" rel="nofollow">
                        Download version <?=$sVersion?>
                    </a>
                </td>
            </tr>
<?php
endforeach;
?>
        </tbody>
    </table> 
</div>
<!--/view_versions-->