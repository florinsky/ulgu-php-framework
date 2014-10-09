<?php

class X {
    static public $app;

    /**
     * This is alias for the system log service.
     * It uses the logger component with the name 'syslog'.
     * To enable this feature add the following to the configuration:
     * 'components'=>[
     *   ...
     *   'debug'=>[
     *       'class'=>'\X\components\logger\Logger',
     *       'writer'=>[
     *           'class'=>'\X\components\logger\LogFileWriter',
     *           'log_file'=>$root.'/x.debug.log',
     *       ]
     *   ],
     *   ...
     **/
    static public function debug() {
        $args = func_get_args();
        static $buff=[];
        if(@self::$app->debug) {
            // flush the internal buffer
            if(!empty($buff)) {
                foreach($buff as $m) {
                    call_user_func_array(array(self::$app->debug, "info"),$m);
                }
                $buff = [];
            }
            call_user_func_array(array(self::$app->debug, "info"),$args);
            return;
        }
        $buff[] = $args;
    }

}

require 'components/Application.php';

