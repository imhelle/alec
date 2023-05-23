<?php

use app\models\common\User;

$params = require __DIR__ . '/params.php';

$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'id' => 'alec',
    'name' => 'ALEC',
    'language' => 'en-US',
    'sourceLanguage' => 'en-GB',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'controllerNamespace' => 'app\controllers',
    'vendorPath' => '@app/vendor',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-alec',
            'cookieValidationKey' => '123',
        ],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/assets/translations',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'ar' => 'ar.php',
                    ],
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'alec',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => getenv('BASE_URL') ? '/' . getenv('BASE_URL') . '/' : '',
            'rules' => [
                '/' => 'site/index',
                '/demo' => 'site/index',
                'upload-data' => 'upload/index',
                'chart/<link:\w+>' => 'site/chart'
            ],
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../runtime/assets',
            'baseUrl' =>  getenv('BASE_URL') ? '/' . getenv('BASE_URL') . '/runtime/assets' : '/runtime/assets',
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/cms/login'],
            'identityCookie' => ['name' => '_identity-alec', 'httpOnly' => true],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => getenv('SMTP_USER'),
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => getenv('DEBUG') ? 3 : 0,
            'targets' => [
                [
                    'class' => notamedia\sentry\SentryTarget::class,
                    'dsn' => getenv('SENTRY_DSN'),
                    'levels' => ['error', 'warning'],
                    'context' => true,
                    // Additional options for `Sentry\init`:
//                    'clientOptions' => ['release' => 'my-project-name@2.3.12']
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'charset' => 'utf8',
            'class' => yii\db\Connection::class,
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'tablePrefix' => getenv('DB_PREFIX'),
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
    ],
    'defaultRoute' => 'cms/index',
    'params' => $params,
    'runtimePath' => __DIR__ . '/../runtime',
];

if (getenv('DEBUG')) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
        'generators' => [
//            'cms_model' => [
//                'class' => \app\generators\model\Generator::class,
//                'templates' => [
//                    'cms_model' => '@app/generator/model/default',
//                ]
//            ],
//            'cms_crud' => [
//                'class' => \app\generators\crud\Generator::class,
//                'templates' => [
//                    'cms_crud' => '@app/generator/crud/default',
//                ]
//            ]
        ],
    ];
}

return $config;
