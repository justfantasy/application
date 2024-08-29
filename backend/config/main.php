<?php

use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'system' => [
            'class' => 'backend\modules\system\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'response' => [
            'format' => Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => 'common\models\admin\AdminUser',
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],
    'as authenticator' => [
        'class' => sizeg\jwt\JwtHttpBearerAuth::class,
        'optional' => [
            'system/auth/login',
        ]
    ],
    'as adminAccessFilter' => [
        'class' => backend\filters\AdminAccessFilter::class,
        'except' => [
            'system/auth/login',
        ]
    ],
    'params' => $params,
];
