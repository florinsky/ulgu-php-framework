<?php

namespace X\components;

use X;
use X\components\logger\Logger;
use X\components\logger\LogFileWriter;
use X\components\helpers\Dumper;

class Application {

    public $conf_file;
    public $conf;

    public function __construct($conf_file) {
        $this->conf_file = $conf_file;
        spl_autoload_register(array($this,'autoload'));
    }

    private function init() {
        X::$app = $this;
        X::debug('Creating an Application object ...');
        $this->processConfig();
        if(isset($this->conf['components'])) {
            X::debug('Loading application components ...');
            foreach($this->conf['components'] as $field=>$component) {
                X::debug("Loading $field ...");
                $this->$field = $this->createObject($component);
            }
            X::debug("Done.");
        }
    }

    /**
     * Add some default values to the loaded application configuration.
     **/
    private function processConfig() {
        $this->conf = include($this->conf_file);
        X::debug("Configuration file [{$this->conf_file}] read.");
        if(!isset($this->conf['application'])) {
            $this->conf['application'] = [];
        }
        if(!isset($this->conf['application']['name'])) {
            $this->conf['application']['name'] = 'Test Application';
        }
        if(!isset($this->conf['application']['debug'])) {
            $this->conf['application']['debug'] = true;
        }
        X::debug("Loaded and processed configuration:", $this->conf);
    }

    private function autoload($name) {
        $list = explode('\\', $name);
        if (strtolower($list[0]) !== 'x') {
            throw new \Exception("Requested autoload $name is out of X's namespace!");
        }
        array_shift($list);
        $path = implode('/',$list) . '.php';
        require $path;
    }

    public function run() {
        $this->init();
        X::debug('Initialization completed.');
        $_GET['r'] = 'aaaa/ssss';
        $result = $this->doAction();
    }

    private function doAction() {
        list($controller,$action) = $this->request->getRoute();
        if($controller==null) {
            // reponse404
        }
    }

    /**
     * Create object based on $conf array. It uses the key 'class' (array key) to specify the class name.
     * Example:
     * $conf = [
     *     'class'=>'X\components\logger\Logger,
     *     'writer=>[
     *         'class'=>'X\components\logger\LogFileWriter',
     *         'log_file'=>'/tmp/x.log',
     *     ]
     * ];
     *
     * It will recursively create LogFileWriter like this:
     * new LogFileWriter(['log_file'=>'/tmp/x.log']);
     *
     * After that the Logger will be create:
     * new Logger(['writer'=><LogFileWriter Object>]);
     *
     * Any other options from $conf array will be passed to the contructor as is.
     * The 'class' key must present in the $conf.
     **/
    public function createObject($conf) {
        // if this is a string - it is a class path
        if(is_string($conf)) {
            $conf['class'] = $conf;
        }
        if(!isset($conf['class'])) {
            throw new \Exception("Failed to create a new object because the 'class' is not specified. The requested class configuration is: ".print_r($conf));
        }
        $options = [];
        // Walk through the array and recusively create nested object if necessary.
        foreach($conf as $key=>$value) {
            if(is_array($value) and isset($options['class'])) {
                $options[$key] = $this->createObject($value);
            } else {
                $options[$key] = $value;
            }
        }
        $class = $options['class'];
        unset($options['class']);
        X::debug('Creating object '.$class);
        return new $class($options);
    }
}

