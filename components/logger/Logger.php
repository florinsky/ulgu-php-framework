<?php

namespace X\components\logger;

use X\components\base\Component;

class Logger extends Component implements ILogger {

    private $writer;
    private $counter=0;

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
        $this->writer->write($this->updateMessage($msg,'info'),'info');
    }

    public function err($msg) {
        $this->writer->write($this->updateMessage($msg,'err'),'err');
    }

    private function updateMessage($msg, $level) {
        list($sec, $ts) = explode(" ", microtime());
        $sec = str_pad((string)round($sec, 4), 6, '0');
        $date_time = date("Y-m-d H:i:s", $ts)." $sec";
        $pid = getmypid();
        $c = str_pad($this->counter++, 5, '0',STR_PAD_LEFT);
        $str = "[#$c] [$level] [$date_time] [$pid] $msg \n";
        return $str;
    }
}

