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

$username ="tester3";
$pw = "testerpw";
$email = "tester3@schnoog.eu";

$error = array();

SHUser::Register($username,$pw,$pw,$email,$error);

SHDebug::print($error);