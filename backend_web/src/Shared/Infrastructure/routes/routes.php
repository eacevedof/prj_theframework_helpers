<?php
return [
    [
        "url"=>"/nosotros",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"we", "allowed"=>["get"],
        "name"=>"home.we"
    ],
    [
        "url"=>"/la-carta",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"the_menu", "allowed"=>["get"],
        "name"=>"home.themenu"
    ],
    [
        "url"=>"/eventos",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"events", "allowed"=>["get"],
        "name"=>"home.events"
    ],
    [
        "url"=>"/contacto",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"contact", "allowed"=>["get"],
        "name"=>"home.contact"
    ],
    [
        "url"=>"/buscar",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\HomeController",
        "method"=>"search", "allowed"=>["get"],
        "name"=>"home.search"
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

    [
        "url"=>"/contact-send",
        "controller"=>"App\Open\Home\Infrastructure\Controllers\ContactSendController",
        "method"=>"send", "allowed"=>["post"],
        "name"=>"home.contactsend"
    ],

    ["url"=>"/error/bad-request-400","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"badrequest_400", "name"=>"error.400"],
    ["url"=>"/error/forbidden-403","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"forbidden_403", "name"=>"error.403"],
    ["url"=>"/error/unexpected-500","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"internal_500", "name"=>"error.500"],

    ["url"=>"/error/not-found-404","controller"=>"App\Open\Errors\Infrastructure\Controllers\ErrorsController","method"=>"notfound_404", "name"=>"error.404"],
];
