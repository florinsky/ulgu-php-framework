<?php

namespace X\components\logger;

use X\components\base\Component;

class LoggerNull extends Component implements ILogger {

    public function __construct($options) {
    }

    public function info() {
    }

    public function err() {
    }
}

