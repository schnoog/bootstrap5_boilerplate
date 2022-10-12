<?php 

$runtime = array();

$runtime['parse_only_content'] = false;

$runtime['css_to_include'] = ['bootstrap.min.css','starter-template.css','navbar-top-fixed.css'];
$runtime['js_to_include'] = ['bootstrap.bundle.min.js'];

$runtime['out'] = array();
$runtime['error'] = array();
$runtime['success'] = array();
$runtime['message'] = array();
$runtime['debug'] = "";

$runtime['UserAuthentification'] = $App['Settings']['site']['UserAuthentification'];


$reqScheme = "http";
if(isset($_SERVER['REQUEST_SCHEME'])){
  $reqScheme = $_SERVER['REQUEST_SCHEME'];
}
$urlBase = $reqScheme . '://' . $_SERVER['HTTP_HOST'];
$App['Settings']['site']['BaseUrl'] = $urlBase;
$App['Settings']['site']['Domain'] = $_SERVER['HTTP_HOST'];
$res = array();
$runtime['BaseUrl'] = $urlBase . "/";
