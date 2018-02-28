<!--view_list 1.2.0-->
<div class="col-lg-12">
    <span class="glyphicon glyphicon-envelope"></span>
    <br/>        
    <table class="table table-striped table-responsive table-hover">
        <thead>
        <tr>
            <th>#</th><th>Examples</th><th>File content</th>
        </tr>
        </thead>
        <tbody>
<?php
//http://glyph.smarticons.co/#usage
    $iRow=0;
    //bug($arHelpers);
    foreach($arHelpers as $i=>$arHelper):
        $iRow++;
        $sSlug = $arHelper["slug"];
        $sUrl = "/$sSlug/examples/";
        $sUrlContent = "/$sSlug/";
?>    
        <tr>
            <th scope="row"><?php s($i);?></th>
            <td>
                <a class="btn btn-default" href="<?php s($sUrl);?>" role="button">
                    <?php s($arHelper["classname"]);?>
<?php
if($arHelper["has_example"]):
?>
                    <img src="/images/svg/si-glyph-checked.svg" height="10" width="10"/>
<?php
endif;
?>                    
                </a>
            </td>
            <td>
                <a class="btn" href="<?php s($sUrlContent);?>" role="button"><?php s($arHelper["filename"]);?></a>
            </td>
        </tr>
<?php
    endforeach;
?>
        </tbody>
    </table> 
</div>
<!--/view_list-->