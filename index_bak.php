<?php
error_reporting(E_ALL);
$App = array();
$App['dirs']['basedir'] = __DIR__;
$App['dirs']['appdir'] = $App['dirs']['basedir'] . "/app/";
require_once( $App['dirs']['appdir'] .  "loader.php");

$template = "content";
$page_to_load = "index";
$runtime['title'] = "MyTest";
$runtime['parse_only_content'] = false;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_REQUEST['params'])){
    if(strpos($_REQUEST['params'],"/")){
        $params = explode("/",$_REQUEST['params']);
        $requested_site = $params[0];
    }else{
        $requested_site = $_REQUEST['params'];
    }
    $requested_site = strtolower($requested_site);
    $App['info']['requested_site'] = $requested_site;
    $runtime['out'][] = "Req: -". $requested_site ."-";
    if(isset($App['pages'][$requested_site])){
        $page_to_load = $requested_site;
    }
}


$App['info']['returend_site'] = $page_to_load;
$App['info']['include_page'] = $App['pages'][$page_to_load];

include_once( $App['pages'][$page_to_load] );
$App['info']['included'][] = $App['pages'][$page_to_load]; 

/**
 * Smarty final call
 */

$runtime['debug'] = SHDebug::print([$res,$runtime,$App],true);


$smarty->assign('template',$template . ".tpl");
$smarty->assign('runtime',$runtime);
$smarty->display('index.tpl');
