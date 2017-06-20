<!--elem_navbar 1.0.3-->
<?php
$arActive = ["home" => "","versions"=>""];
if($oAppMain->is_inrequesturi("versions"))
    $arActive["versions"] = "active";
elseif(!$oAppMain->is_inrequesturi("?"))
    $arActive["home"] = "active";

?>
<div class="header clearfix">
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?=$arActive["home"]?>" rel="nofollow" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=$arActive["versions"]?>" href="/index.php?view=versions">Versions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" rel="nofollow" href="https://github.com/eacevedof/prj_theframework_helpers">Github</a>
            </li>
        </ul>
    </nav>
    <h3 class="text-muted">The Framework PHP Helpers</h3>
</div>
<!--/elem_navbar-->