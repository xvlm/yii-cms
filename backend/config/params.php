<?php
return [
    'adminEmail' => 'admin@example.com',
    'activityConf' => [
        '1' => [
            'a1' => ['name' => '基础模板','layout' => 'main','controller' => 'act'],
            'a2' => ['name' => '广告位测试1','layout' => 'main_widget_test','controller' => 'act'],
            'search' => ['name' => 'search活动','layout' => 'mainSearch','controller' => 'act']
        ],
        '2' => [
            'm1' => ['name' => '基础模板','layout' => 'main-index','controller' => 'act'],
            'empty' => ['name' => '空模板','layout' => 'main','controller' => 'act']
        ]
    ],
    
    'cmsStatusConf' => [
        '-1' => '已删除',
        '0' => '未发布',
        '1' => '已发布',
        '2' => '发布后修改'
        ],



    'AppId' => 'Advertisement',
];
