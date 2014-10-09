<?php

namespace X\components\logger;

use X\components\base\Component;

class Logger extends Component implements ILogger {

    private $writer;

    public function __construct(ILogWriter $writer) {
        $this->writer = $writer;
    }

    public function info($msg) {
        $this->writer->write($msg, 'info');
    }

    public function err($msg) {
        $this->writer->write($msg, 'err');
    }
}

