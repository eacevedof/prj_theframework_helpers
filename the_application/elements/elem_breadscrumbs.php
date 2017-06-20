<!--elem_breadscrumbs-->
<div class="row">
<?php
$arScrumbs = $oAppMain->get_scrumbs();
?>
        <ol class="breadcrumb">
<?php
foreach($arScrumbs as $arScrumb):
?>
    <li class="breadcrumb-item"><a href="<?php s($arScrumb["url"])?>"><?php s($arScrumb["description"])?></a></li>
<?php
endforeach;
?>
        </ol>
</div>
<!--/elem_breadscrumbs-->
