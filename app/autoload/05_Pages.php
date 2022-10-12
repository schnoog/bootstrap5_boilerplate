<?php 



$App['dirs']['pagedir'] = $App['dirs']['basedir'] . "/pages/";

foreach (glob( $App['dirs']['pagedir'] . "*.php") as $pagefile)
{
    list($page,$extension) = explode(".",basename($pagefile)); 
    $App['pages'][$page] = $pagefile;
}

