<?php

namespace X\components\logger;

interface ILogWriter {
    public function write($msg, $level);
}
