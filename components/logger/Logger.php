<?php

namespace X\components\logger;

use X\components\base\Component;
use X\components\helpers\Dumper;

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

    private function writeMessages($msgs, $level) {
        $s = $this->getMessagePrefix($level);
        foreach($msgs as $m) {
            if(is_string($m)) {
                $s .= $m . "\n";
            } else {
                $s .= Dumper::dump($m) . "\n";
            }
        }
        $this->writer->write($s);
    }

    public function err() {
        $this->writeMessages(func_get_args(), 'err');
    }

    public function info() {
        $this->writeMessages(func_get_args(), 'info');
    }

    private function getMessagePrefix($level) {
        list($sec, $ts) = explode(" ", microtime());
        $sec = str_pad((string)round($sec, 4), 6, '0');
        $date_time = date("Y-m-d H:i:s", $ts)." $sec";
        $pid = getmypid();
        $c = str_pad($this->counter++, 5, '0',STR_PAD_LEFT);
        $str = "[$pid] [#$c] [$level] [$date_time] ";
        return $str;
    }
}

