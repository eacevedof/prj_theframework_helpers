<?php
//<prj>/the_vendor/bootstrap.php 1.0.1
//autoload para paquetes composer
require_once "autoload.php";//require_once __DIR__ . '/composer/autoload_real.php';
require_once "paths.php";//$arVendorsPaths

$arPaths[] = get_include_path();
foreach($arVendors as $sFolder)
    $arPaths[] = realpath(TFW_PATH_VENDORDS.$sFolder);

//var_dump($arPaths);
$sPathInclude = implode(PATH_SEPARATOR,$arPaths);
set_include_path($sPathInclude);
