<?php

return [
    'components'=>[
        'logger'=>[
            'class'=>'\X\components\logger\Logger',
            'writer'=>[
                'class'=>'\X\components\logger\LogFileWriter',
                'log_file'=>'/tmp/x.app.log',
            ]
        ],
    ],
];

