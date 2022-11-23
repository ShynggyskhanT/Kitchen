<?php

declare(strict_types=1);

use app\models\UserRoleEnum;
use yii\debug\Module;
use yii\log\FileTarget;
use app\models\User;
use yii\caching\FileCache;
use yii\rbac\DbManager;
use yii\symfonymailer\Mailer;
use yii\web\JsonParser;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => DbManager::class,
            'defaultRoles' => ['admin', 'user'],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'umPalDxZ-X9IFzu5aB1I8YYVzAmki4H9',
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],
        'response' => [
            'format' => Response::FORMAT_JSON,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => null,
            'enableSession' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST <controller:(ingredients)>/<id:\d+>/<action:(disable|enable)>' => '<controller>/<action>',

                /** REST */
                'POST <controller>' => '<controller>/create',
                'GET <controller>' => '<controller>/index',
                'GET <controller>/<id:\d+>' => '<controller>/view',
                'PUT <controller>/<id:\d+>' => '<controller>/update',
                'DELETE <controller>/<id:\d+>' => '<controller>/delete',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
