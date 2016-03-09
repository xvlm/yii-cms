<?php

/**
 * 
 */
return [
    'language' => 'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
//已经放到了common config main 中
        'session' => (YII_ENV_PROD) ? [
            'class' => 'yii\redis\Session',
                ] : [
            'class' => 'yii\web\Session'
                ],
        //**注意 线上环境的cms需要登陆ci环境vpn，通过192.168.225.51/webstore_0.3/backend/index.php来修改 或者本地host  cms.ftzmall.com  到192.168.255.51
// TODO  cms  用户管理登陆
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => YII_ENV_PROD ? 'mysql:host=192.168.200.15;dbname=webstore' : 'mysql:host=127.0.0.1;dbname=webstore',
            'username' => YII_ENV_PROD ? 'ftzmall' : 'root',
            'password' => YII_ENV_PROD ? 'Passw0rd' : 'handaocn',
            'charset' => 'utf8',
            'tablePrefix' => 'cms_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'TkRNUbrCOG0EpdGS_iN3N1Zw6i_lwjk0',
        ],
    ],
];
