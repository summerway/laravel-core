<?php

return [

    // aes encrypt
    'aes' => [
        'key' => env("AES_KEY","JUK1BHpXaGacW3CrfEXvw8DzzTdCne87"),
        'iv' => 'RGd5WkRoak4yVTE',
        'cipher' => 'AES-256-CBC'
    ],

    // 是否开启白名单
    'enable_whiteList' => true,

    // 白名单
    'whiteList' => [
        //'127.0.0.1'
    ]

];