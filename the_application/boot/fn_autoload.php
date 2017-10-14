<?php
//<prj>/the_application/boot/fn_autoload.php 1.1.1
spl_autoload_register(function($sNSClassName)
{
    //bug($sNSClassName,"boot/autoload.php.sNSClassName:");
    $arPieces = explode("\\",$sNSClassName);
    $iPieces = count($arPieces);
    $sTypeof = isset($arPieces[$iPieces-2])?$arPieces[$iPieces-2]:"";
    
    //El patron seria controllers->controller_x,models->model_x
    //main -> theframework_x
    if($sTypeof)
    {
        $sTypeof = strtolower($sTypeof);
        //parche para TheFramework\Main
        if($sTypeof!=="main")      
            $sTypeof = substr($sTypeof,0,-1);
        else
            $sTypeof="theframework";
    } 
    
    $arFiles = [];
    
    //bug($sTypeof,"typeof");
    $sClassOriginal = end($arPieces);
    $arFiles["originalclass"] = "$sClassOriginal.php";
    $sClassOrigLower = strtolower($sClassOriginal);
    $arFiles["originalfile"] = "$sClassOrigLower.php";
    
    $sFileUntyped = str_replace($sTypeof,"",$sClassOrigLower);
    $sSubfolder = (isset($_POST["tfw_controller"])?strtolower($_POST["tfw_controller"]):$sFileUntyped);
    
    $sFileUntyped = "$sFileUntyped.php";
    $arFiles["nonprefix"] = $sFileUntyped;
    $sFileTyped = $sFileUntyped;
    $sFileTyped = "$sTypeof"."_"."$sFileUntyped";
    $arFiles["withprefix"] = $sFileTyped;
    
    //wf:with folder
    $arFiles["wf_originalclass"] = "$sSubfolder/{$arFiles["originalclass"]}";
    $arFiles["wf_originalfile"] = "$sSubfolder/{$arFiles["originalfile"]}";
    $arFiles["wf_nonprefix"] = "$sSubfolder/{$arFiles["nonprefix"]}";
    $arFiles["wf_withprefix"] = "$sSubfolder/{$arFiles["withprefix"]}";
    
    //pr($arFiles,"FILES FOR:$sNSClassName");
    foreach($arFiles as $sType=>$sFile)
        if(stream_resolve_include_path($sFile))
        {
            $included = include_once $sFile;
            //bug("included:$included,file:$sFile");
            return $included;
        }

});//spl_autoload_register
