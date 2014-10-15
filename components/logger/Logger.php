<?php

namespace X\components\logger;

use X\components\base\Component;

class Logger extends Component implements ILogger {

    private $writer;

    public function __construct($options) {
        if(!isset($options['writer'])) {
            throw new \Exception("Failed to create object of Logger. It requires 'writer' field in constructor options. The options array is: ".print_r($options,true));
        }
        if(!($options['writer'] instanceof ILogWriter)) {
            throw new \Exception("Failed to create object of Logger. It requires the 'writer' object must implements an ILogWriter interface. The options array is: ".print_r($options,true));
        }
        $this->writer = $options['writer'];
    }

    public function info($msg) {
        $this->writer->write($msg, 'info');
    }

    public function err($msg) {
        $this->writer->write($msg, 'err');
    }
}

