<?php

require 'components/Application.php';

(new \X\Components\Application([
    'log.file'=>'/tmp/x.application.log'
]))->run();


