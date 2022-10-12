<?php 


$runtime['navbar'] = [
    'mainlink' => $runtime['BaseUrl'],

    'dropdownitems' => [
        'Settings' => $runtime['BaseUrl'] . "settings",
        'More'  => $runtime['BaseUrl'] . "more",
        'Dummy'  => $runtime['BaseUrl'] . "dummy",
        'Test'  => $runtime['BaseUrl'] . "test",
    ],
];


function SetLoginNavbar($LoggedIn = false){
    global $runtime;

    if($LoggedIn){
        $runtime['navbar']['userdropdownitems'] = [
            'Logout' => $runtime['BaseUrl'] . "index/logout",
            'Usersettings' => $runtime['BaseUrl'] . "usersettings",
        ];
    }else{
        $runtime['navbar']['userdropdownitems'] = [
            'Login' => $runtime['BaseUrl'] . "login",
            'Register' => $runtime['BaseUrl'] . "register",
        ];
    }

}