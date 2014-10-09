<?php

$root = dirname(__FILE__).'/..';

// The local configuration file contains only local configuration and
// never be committed. You are free to use local config for your debug purposes.
if(file_exists('conf/local.conf.php')) {
    $local = include('conf/local.conf.php');
} else {
    $local = [];
}

// The General Application config.
// Each value may be redefined in local config.
$main = [
    'application'=>[
        'name'=>'This is a Test Application',
        'debug'=>false,
    ],
    'components'=>[
        // framework level logging service
        'debug'=>[
            'class'=>'\X\components\logger\Logger',
            'writer'=>[
                'class'=>'\X\components\logger\LogFileWriter',
                'log_file'=>$root.'/runtime/x.framework.log',
            ]
        ],
        // application (user space) level logging service
        'logger'=>[
            'class'=>'\X\components\logger\Logger',
            'writer'=>[
                'class'=>'\X\components\logger\LogFileWriter',
                'log_file'=>$root.'/runtime/x.app.log',
            ]
        ],
        'request'=>[
            'class'=>'\X\components\Request',
        ],
    ],
];

return array_replace_recursive($main,$local);

