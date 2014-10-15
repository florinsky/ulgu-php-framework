<?php

$root = dirname(__FILE__).'/../runtime';

return [
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
    ],
];

