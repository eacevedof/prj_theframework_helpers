<!--view_list 1.1.0-->
<div class="col-lg-12">
    <br/>        
    <table class="table table-striped table-responsive table-hover">
        <thead>
        <tr>
            <th>#</th><th>Examples</th><th>File content</th>
        </tr>
        </thead>
        <tbody>
    <?php
    $iRow=0;

    foreach($arHelpers as $i=>$arHelper):
        $iRow++;
        $sSlug = $arHelper["slug"];
        $sUrl = "/$sSlug/examples/";
        $sUrlContent = "/$sSlug/";
    ?>    
        <tr>
            <th scope="row"><?php s($i);?></th>
            <td>
                <a class="btn btn-default" href="<?php s($sUrl);?>" role="button"><?php s($arHelper["classname"]);?></a>
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