<!-- horizontal bar  -->
<?php
/**
 * @var App\Shared\Infrastructure\Views\AppView $this
 */
use App\Open\Home\Infrastructure\Helpers\NavMenuHelper;
$menu = NavMenuHelper::get_self()->get_selected();

$arActive = ["home" => "","versions"=>"","issues"=>""];
/*
if($oPagedata->is_inrequesturi("versions"))
    $arActive["versions"] = "active";
elseif(!$oPagedata->is_inrequesturi("?"))
    $arActive["home"] = "active";
*/
?>
<div class="header clearfix">
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?=$arActive["home"]?>" rel="nofollow" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=$arActive["versions"]?>" href="/versions/">Versions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=$arActive["issues"]?>" rel="nofollow" target="_blank" href="https://github.com/eacevedof/prj_theframework_helpers/issues">Github Issues</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" rel="nofollow" target="_blank" href="https://github.com/eacevedof/prj_theframework_helpers">Github</a>
            </li>
        </ul>
    </nav>
    <h3 class="text-muted">The Framework PHP Helpers</h3>
</div>
<!-- horizontal bar -->