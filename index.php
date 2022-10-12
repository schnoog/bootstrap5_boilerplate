<?php


error_reporting(E_ALL);

$App = array();
$App['dirs']['basedir'] = __DIR__;
$App['dirs']['appdir'] = $App['dirs']['basedir'] . "/app/";
require_once( $App['dirs']['appdir'] .  "loader.php");


$runtime['mainpage'] = "content";
$runtime['require_token'] = false;
$template = $runtime['mainpage'];
$page_to_load = "index";
$runtime['title'] = "MyTest";
$runtime['parse_only_content'] = false;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$runtime['loggedin'] = false;

if($App['Settings']['site']['UserAuthentification']){
    if(!isset($_SESSION['loggedin'])){
        if(SHUser::CookieResume()) $runtime['loggedin'] = true;
    }
}


$runtime['user'] = array();

if(isset($_SESSION['user'])){
    $runtime['loggedin'] = true;
    $runtime['user'] = $_SESSION['user'];
    $runtime['message'][] = "Session exists";
    
}
SetLoginNavbar($runtime['loggedin']);

$App['info']['requestslist'] = array();

if(isset($_REQUEST['params'])){
    $params = explode("/",$_REQUEST['params']);
    $App['info']['requestslist'] = $params;
    $requested_site = $params[0];

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


/***
 * Who needs to be forwarded?
 */
if(isset($runtime['forward_to'])){
    if(strlen($runtime['forward_to'])> 1){
        header('Location: '. $runtime['forward_to']);
        die();
    }

}
/**
 * Time to get the csrf token ready
 * available in $_SESSION['CSRF-Token']
 */
$runtime['csrf_token'] = BF::CreateSessionToken();
$runtime['csrf_token_control'] = "<input type='hidden' name='csrf-token' value='" . $runtime['csrf_token'] . "'>"; 

/**
 * Smarty final call
 */
$runtime['debug'] = array(SHDebug::print([$res,$runtime,$App],true));
$runtime['debug'] = BF::WrapAndRemoveEmpties($runtime['debug']);
$runtime['error'] = BF::WrapAndRemoveEmpties($runtime['error']);
$runtime['success'] = BF::WrapAndRemoveEmpties($runtime['success']);
$runtime['message'] = BF::WrapAndRemoveEmpties($runtime['message']);




$smarty->assign('template',$template . ".tpl");
$smarty->assign('runtime',$runtime);
$smarty->display('index.tpl');

