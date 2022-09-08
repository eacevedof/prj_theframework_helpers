<!--elem_breadscrumbs 1.0.0-->
<div class="row">
<?php
//No se usa de momento
//$arScrumbs = $oPagedata->get_scrumbs();
//pr($arScrumbs);die;
$arScrumbs = [];
?>
        <ol class="breadcrumb">
<?php
foreach($arScrumbs as $arScrumb):
?>
    <li class="breadcrumb-item"><a href="<?php $this->_echo($arScrumb["href"])?>"><?php $this->_echo($arScrumb["description"])?></a></li>
<?php
endforeach;
?>
        </ol>
</div>
<!--/elem_breadscrumbs-->
