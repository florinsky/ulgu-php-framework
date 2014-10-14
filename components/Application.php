<?php
namespace X\components;

use X\components\logger\Logger;
use X\components\logger\LogFileWriter;

class X {
    static public $app;
}

class Application {

    public $logger;
    public $conf_file;
    public $conf;

    public function __construct($conf_file) {
        spl_autoload_register(array($this,'autoload'));
        $this->conf_file = $conf_file;
        $this->conf = include($this->conf_file);
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
        var_dump($this->createObject($this->conf['components']['logger']));
    }

    public function createObject($conf) {
        // if this is a string - it is a class path
        if(is_string($conf)) {
            $conf['class'] = $conf;
        }
        if(!isset($conf['class'])) {
            throw new \Exception("Failed to create a new object because the 'class' is not specified. The requested class configuration is: ".print_r($conf));
        }
        $class = $conf['class'];
        unset($conf['class']);
        return new $class($conf);
    }
}

