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
    $i=0;
    foreach($arHelpers as $sClassName=>$sFileName):
        $i++;
        $sClassNameLow = strtolower($sClassName);
        $sUrl = "/$sClassNameLow/examples/";
        $sUrlContent = "/$sClassNameLow/code/";
    ?>    
        <tr>
            <th scope="row"><?php s($i);?></th>
            <td>
                <a class="btn btn-default" href="<?php s($sUrl);?>" role="button"><?php s($sClassName);?></a>
            </td>
            <td>
                <a class="btn" href="<?php s($sUrlContent);?>" role="button"><?php s($sFileName);?></a>
            </td>
        </tr>
    <?php
    endforeach;
    ?>
        </tbody>
    </table> 
</div>
<!--/view_list-->