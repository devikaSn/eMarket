<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'emarket',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xxxx',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // 'mailer' => [
        //     'class' => 'yii\swiftmailer\Mailer',
        //         // 'viewPath' => '@common/mail',
        //         'transport' => [
        //             'class' => 'Swift_MailTransport',
        //         ],
        //     //arjunphp.com/send-e-mail-yii2/#sthash.GPKKnYCW.dpuf
        //     // send all mails to a file by default. You have to set
        //     // 'useFileTransport' to false and configure a transport
        //     // for the mailer to send real emails.
        //     'useFileTransport' => false,
        // ],
          'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                // 'viewPath' => '@common/mail',
                'transport' => [
                    'class' => 'Swift_MailTransport',
                ],
                'useFileTransport' => false,
            ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            // 'rules' => [
            // ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
