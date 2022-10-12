<?php

$App['dirs']['configdir'] = $App['dirs']['appdir'] . "config/";
$App['dirs']['autoloaddir'] = $App['dirs']['appdir'] . "autoload/";
$App['dirs']['pagedir'] = $App['dirs']['basedir'] . "/pages/";



/*
    Get the secrets first
*/

if(file_exists( $App['dirs']['configdir'] . "secrets.php" )){
    include_once($App['dirs']['configdir'] . "secrets.php");
    $App['info']['included'][] = $App['dirs']['configdir'] . "secrets.php";
}else{
    include_once($App['dirs']['configdir'] . "secrets.dist.php");
    $App['info']['included'][] = $App['dirs']['configdir'] . "secrets.dist.php";
}


/*
    Now use the composer autoloader
*/
require_once($App['dirs']['basedir'] . "/vendor/autoload.php");
/*
    Now it's time to get the settings
*/
require_once($App['dirs']['configdir'] . "settings.php");
$App['info']['included'][] = $App['dirs']['configdir'] . "settings.php";


/*
    include the files in the autoloaddir
*/

foreach (glob( $App['dirs']['autoloaddir'] . "*.php") as $filename)
{
    $App['info']['included'][] = $filename;
    include_once( $filename);
}



