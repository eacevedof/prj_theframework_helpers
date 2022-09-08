<?php
return [
    [
        "url"=>"/versions",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"versions", "allowed"=>["get"],
        "name"=>"home.versions"
    ],
    [
        "url"=>"/versions",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"versions", "allowed"=>["get"],
        "name"=>"home.versions"
    ],
    [
        "url"=>"/",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"index", "allowed"=>["get"],
        "name"=>"home.index"
    ],

    [
        "url"=>"/wp-admin",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"joke", "allowed"=>["get"],
        "name"=>"home.joke.wpadmin"
    ],

    [
        "url"=>"/wp-login",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"joke", "allowed"=>["get"],
        "name"=>"home.joke.wplogin"
    ],

    [
        "url"=>"/trs",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"trs", "allowed"=>["get"],
    ],

    ["url"=>"/error/bad-request-400","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"badrequest_400", "name"=>"error.400"],
    ["url"=>"/error/forbidden-403","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"forbidden_403", "name"=>"error.403"],
    ["url"=>"/error/unexpected-500","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"internal_500", "name"=>"error.500"],

    ["url"=>"/error/not-found-404","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"notfound_404", "name"=>"error.404"],
];
