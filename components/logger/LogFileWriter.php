<?php

namespace X\components\logger;

use X\components\base\Component;
use X\components\helpers\File;

class LogFileWriter extends Component implements ILogWriter {

    public $log_file;

    public function __construct($log_file) {
        $this->log_file = $log_file;
    }

    public function write($msg, $level) {
        list($sec, $ts) = explode(" ", microtime());
        $date_time = date("Y-m-d H:i:s", $ts)." $sec";
        $pid = getmypid();
        $str = "[$level] [$date_time] [$level] $msg \n";
        File::append($this->log_file,$str);
    }
}
