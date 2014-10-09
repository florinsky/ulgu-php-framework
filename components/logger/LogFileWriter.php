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

    public function write($msg) {
        File::append($this->log_file,$msg);
    }
}
