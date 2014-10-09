<?php
namespace X\components;

use X\components\logger\Logger;
use X\components\logger\LogFileWriter;

class X {
    static public $app;
}

class Application {

    public $logger;
    public $conf;

    public function __construct($conf) {
        spl_autoload_register(array($this,'autoload'));
        $this->conf = $conf;
        if(!isset($this->conf['log.file'])) {
            $this->conf['log.file'] = '/tmp/x.application.log';
        }
        $this->logger = new Logger(new LogFileWriter($this->conf['log.file']));
        $this->logger->info('Application is starting ...');
    }

    public function autoload($name) {
        $list = explode('\\', $name);
        if (strtolower($list[0]) !== 'x') {
            throw new \Exception("Requested autoload $name is out of X's namespace!");
        }
        array_shift($list);
        $path = implode('/',$list) . '.php';
        require $path;
    }

    public function run() {
        X::$app = $this;
    }
}

