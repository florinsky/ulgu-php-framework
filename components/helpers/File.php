<?php

namespace X\components\helpers;
use X\components\base\Component;

class File extends Component {
    private $file_path;
    private $file_handler;

    private function __construct($file_path) {
        $this->file_path = $file_path;
    }

    static public function put($file_path, $data) {
        self::checkCreatable($file_path);
        $f = new File($file_path);
        $f->open('wb');
        $f->write($data);
        $f->close();
    }

    static public function get($file_path) {
        self::checkReadable($file_path);
        $f = new File($file_path);
        $f->open('rb');
        $d = $f->read();
        $f->close();
        return $d;
    }

    static public function append($file_path,$data) {
        if(!file_exists($file_path)) {
            self::checkCreatable($file_path);
        } else {
            self::checkWritable($file_path);
        }
        $f = new File($file_path);
        $f->open('ab');
        $f->write($data);
        $f->close();
    }

    private function read() {
        if (flock($this->file_handler, LOCK_SH)) {
            $r = fread($this->file_handler, filesize($this->file_path));
            flock($this->file_handler, LOCK_UN);
            if($r === false) {
                throw new \Exception("Failed to read the content of the file {$this->file_path}");
            }
            return $r;
        } else {
            throw new \Exception("Couldn't get the lock on the file {$this->file_path}");
        }
    }

    private function write($data) {
        if (flock($this->file_handler, LOCK_EX)) {
            if(fwrite($this->file_handler, $data) === false) {
                throw new \Exception("Failed to write to the file {$this->file_path}");
            }
            flock($this->file_handler, LOCK_UN);
        } else {
            throw new \Exception("Couldn't get the lock on the file {$this->file_path}");
        }
    }

    public function close() {
        fclose($this->file_handler);
    }

    private function open($mode) {
        $this->file_handler = fopen($this->file_path, $mode);
        if($this->file_handler === false) {
            throw new \Exception("Failed to open file {$this->file_path}");
        }
    }

    static private function checkReadable($file_path) {
        if(!file_exists($file_path)) {
            throw new \Exception("The file [$file_path] does not exist - unable to read to the file!");
        }
        if(!is_readable($file_path)) {
            throw new \Exception("Failed to read file [$file_read]. The file is unreadable.");
        }
    }

    static private function checkWritable($file_path) {
        if(!file_exists($file_path)) {
            throw new \Exception("The file [$file_path] does not exist - unable to write to the file!");
        }
        if(file_exists($file_path) and !is_writeable($file_path)) {
            throw new \Exception("The file [$file_path] exists and is not writable!");
        }
    }

    static private function checkCreatable($file_path) {
        if(!file_exists($file_path) and !is_writeable(dirname($file_path))) {
            throw new \Exception("The file [$file_path] does not exist and the parent folder is not writable - unable to create a file!");
        }
    }

    static private function createFile($file_path) {
        if(file_put_contents($file_path,'')===false) {
            throw new \Exception("Failed to create/truncate file $file_path");
        }
    }

}
