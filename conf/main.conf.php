<?php

$root = dirname(__FILE__).'/../runtime';

return [
    'application'=>[
        'name'=>'This is a Test Application',
    ],
    'components'=>[
        'syslog'=>[
            'class'=>'\X\components\logger\Logger',
            'writer'=>[
                'class'=>'\X\components\logger\LogFileWriter',
                'log_file'=>$root.'/x.syslog.log',
            ]
        ],
        'logger'=>[
            'class'=>'\X\components\logger\Logger',
            'writer'=>[
                'class'=>'\X\components\logger\LogFileWriter',
                'log_file'=>$root.'/x.app.log',
            ]
        ],
        'request'=>[
            'class'=>'\X\components\Request',
        ],
    ],
];

