<?php

namespace X\components\logger;

use X\components\base\Component;
use X\components\helpers\File;

class LogFileWriter extends Component implements ILogWriter {

    private $log_file;

    public function __construct($options) {
        if(!isset($options['log_file'])) {
            throw new \Exception("Failed to create object of LogFileWriter. It requires 'log_file' field in constructor options. The options array is: ".print_r($options,true));
        }
        $this->log_file = $options['log_file'];
    }

    public function write($msg, $level) {
        list($sec, $ts) = explode(" ", microtime());
        $date_time = date("Y-m-d H:i:s", $ts)." $sec";
        $pid = getmypid();
        $str = "[$level] [$date_time] [$level] $msg \n";
        File::append($this->log_file,$str);
    }
}
