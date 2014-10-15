<?php

namespace X\components;

use X;
use X\components\logger\Logger;
use X\components\logger\LogFileWriter;

class Application {

    public $conf_file;
    public $conf;

    private $log_buffer;

    public function __construct($conf_file) {
        $this->conf_file = $conf_file;
        spl_autoload_register(array($this,'autoload'));
    }

    private function init() {
        $this->log('Creating an Application object ...');
        $this->conf = include($this->conf_file);
        $this->log("Configuration file [{$this->conf_file}] read.");
        if(isset($this->conf['components'])) {
            $this->log('Loading application components ...');
            foreach($this->conf['components'] as $field=>$component) {
                $this->log("Loading $field ...");
                $this->$field = $this->createObject($component);
            }
            $this->log("Done.");
        }
    }

    /**
     * The system log service.
     * It uses the logger component with the name 'syslog'.
     * To enable this feature add the following to the configuration:
     * 'components'=>[
     *   ...
     *   'syslog'=>[
     *       'class'=>'\X\components\logger\Logger',
     *       'writer'=>[
     *           'class'=>'\X\components\logger\LogFileWriter',
     *           'log_file'=>$root.'/x.syslog.log',
     *       ]
     *   ],
     *   ...
     **/
    private function log($msg) {
        if(@$this->syslog) {
            // flush the internal buffer
            if(!empty($this->log_buffer)) {
                foreach($this->log_buffer as $m) {
                    $this->syslog->info($m);
                }
                $this->log_buffer = [];
            }
            $this->syslog->info($msg);
            return;
        }
        $this->log_buffer[] = $msg;
    }

    private function autoload($name) {
        $list = explode('\\', $name);
        if (strtolower($list[0]) !== 'x') {
            throw new \Exception("Requested autoload $name is out of X's namespace!");
        }
        array_shift($list);
        $path = implode('/',$list) . '.php';
        require $path;
        $this->log("Autoload: $name");
    }

    public function run() {
        $this->init();
        X::$app = $this;
        X::$app->logger->info('Hello!');
    }

    /**
     * Create object based on $conf array. I uses the key 'class' (array key) to specify the class name.
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
        $this->log('Creating object '.$class);
        return new $class($options);
    }
}

