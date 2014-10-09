<?php

namespace X\components\logger;

interface ILogger {
    public function info($msg);
    public function err($msg);
}
