<?php

return [
    'timeZone' => 'PRC',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:4*',
                    ],
                ],
            ],
        ],
        'jwt' => [
            'class' => sizeg\jwt\Jwt::class,
            'key' => 'WstOpBBatR23A$s#ya%snYTEdB', // 请在main-local中重载该配置
        ],
        'queue' => [
            'class' => yii\queue\redis\Queue::class,
            'channel' => 'queue'
        ],
        'wechat' => [
            'class' => 'common\components\WechatComponent',
        ],
    ],
];
