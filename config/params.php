<?php

return [
    'url' => '',
    'adminEmail' => 'admin@example.com',
    'ldap' => array(
            'port'	=> '',
            'host'	=> '',
            'username'	=> '',
            'password'	=> '',
            'dc'	=> '',
            'uid'	=> ''
    ),
    'oauth2' => [
        'clientId' => '',    // The client ID assigned to you by the provider
        'clientSecret' => '',   // The client password assigned to you by the provider
        'redirectUri' => '',
        'urlAuthorize' => '',
        'urlAccessToken' => '',
        'urlResourceOwnerDetails' => ''
    ],
    'defaultPermissions' => [
        [
            'name' => 'Giriş Ekranı',
            'code' => 'site/login'
        ],
        [
            'name' => 'Çıkış Ekranı',
            'code' => 'site/logout'
        ],
        [
            'name' => 'Hata',
            'code' => 'site/error'
        ],
        [
            'name' => 'OAuth Giriş',
            'code' => 'auth/auth'
        ],
    ],
    'redis' => [
        'hostname' => '',
        'port' => '',
    ]
];
