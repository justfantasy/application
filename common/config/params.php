<?php

return [
    'wechatConfig' => [
        'app_id' => '',
        'secret' => '',
        'oauth' => [
            'scopes'   => ['snsapi_userinfo'],
            'callback' => '/oauth/callback',
        ],
    ]
];
