<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$secure = require __DIR__.'/secure.php';
$params=array_merge($params,$secure);
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@alipay'=>'@vendor/alipay',
    ],
    'defaultRoute'=>'index/index',
    'timeZone' => 'Asia/Shanghai',
    'language'=>'zh-CN',
    'charset'=>'utf-8',
//    'layoutPath'=>'..\views\layouts',
    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '119.23.70.61',
            'port' => 6379,
            'database' => 0,
        ],
        'assetManager'=>[
            'class'=>'yii\web\AssetManager',
            'bundles'=>[
                'yii\web\JqueryAsset'=>[
                    'js'=>[
                        YII_ENV_DEV?'jquery.js':'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset'=>[
                    'css'=>[
                        YII_ENV_DEV?'css/bootstrap.css':'css/bootstrap.min.css'
                    ]
                ]
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EFOVr_elAOuet2b21ZL8cHfyM7AD2UYr',
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis'=>[
                'hostname' => '119.23.70.61',
                'port' => 6379,
                'database' => 2,
            ]
        ],
        'admin'=>[
            'class'=>'app\models\Cart'
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],

        //自定义url错误处理
        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
        'mailer' => [
            'class' => 'sanjin\queue\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
//            'useFileTransport' => true,
            'db'=>1,
            'key'=>'mailers',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => '15658283276@163.com',
                'password' => 'abc123456',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix'=>'.html',
            'rules' => [
                'index'=>'index/index',
                [
                    'pattern'=>'sanjinback',
                    'route'=>'/admin/index/index',
                    'suffix'=>'.html'
                ]
            ],
        ],
    ],
    'params' => $params,
    'modules'=>[
        'admin'=>[
            'class'=>'app\modules\admin\Admin',

        ],

    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
