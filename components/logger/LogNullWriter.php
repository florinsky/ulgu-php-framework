<?php

namespace X\components\logger;

use X\components\base\Component;

class LogNullWriter extends Component implements ILogWriter {

    public function write($msg) {
    }
}
