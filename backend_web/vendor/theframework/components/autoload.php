<?php
//components autoload
//autoload.php 2.3.0
$pathcompsroot = dirname(__FILE__).DIRECTORY_SEPARATOR;
//die("sPathRoot: $pathcompsroot");//...tests\vendor\theframework\components
$compsubfolders[] = get_include_path();
$compsubfolders[] = $pathcompsroot;//ruta de components
//subcarpetas dentro de components
$compsubfolders[] = $pathcompsroot."console";
$compsubfolders[] = $pathcompsroot."db";
$compsubfolders[] = $pathcompsroot."session";
$compsubfolders[] = $pathcompsroot."config";
$compsubfolders[] = $pathcompsroot."formatter";
$compsubfolders[] = $pathcompsroot."db".DIRECTORY_SEPARATOR."integration";
$compsubfolders[] = $pathcompsroot."db".DIRECTORY_SEPARATOR."context";
$includepath = implode(PATH_SEPARATOR, $compsubfolders);
set_include_path($includepath);

//a partir de un nombre de namespace busca el archivo y hace un include
spl_autoload_register(function($fqnamespace) {
    //si no existe
    if (!strstr($fqnamespace,"TheFramework")) return;
    $nsparts = explode("\\",$fqnamespace);
    $classname = end($nsparts);
    if(!strstr($classname,"Component")) return;
    //https://autohotkey.com/docs/misc/RegEx-QuickRef.htm
    // (?<=...) and (?<!...) are positive and negative look-behinds (respectively) 
    // because they look to the left of the current position rather than the right 
    $classname = preg_replace("/(?<!^)([A-Z])/","_\\1",$classname);
    $classname = str_replace("Component","",$classname);
    $classname = strtolower($classname);
    $classname = "component$classname.php";
    if(stream_resolve_include_path($classname)) include_once $classname;
});

