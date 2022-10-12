<?php
/**
 * Loaded after secret and vendor and before autoload directory
 */

/**
 * Site Settings
 */

$App['Settings']['site'] = [
    'Title' => "StoreHouse",
    'BaseUrl' => '',
    'UserAuthentification' => true,
];

$App['security']['max_fail_count'] = 10;
$App['security']['bantime_on_max_fail_count'] = 3600;

$App['users']['default_group'] = 90;
$App['users']['allow_registration'] = true;



/**
 * 
 */



/**
 * Smarty Settings
 */

$App['Settings']['smarty'] = [
    'debug' => false,
    'force_compile' => false,
];