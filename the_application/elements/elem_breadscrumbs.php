<!--elem_breadscrumbs 1.0.0-->
<div class="row">
<?php
//No se usa de momento
$arScrumbs = $oAppMain->get_scrumbs();
//pr($arScrumbs);die;
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
