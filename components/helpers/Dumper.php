<?php

namespace X\components\helpers;
use X\components\base\Component;

class Dumper extends Component {

    static public function dump($value) {
        $type = gettype($value);
        switch($type) {
        case 'boolean':
            return self::dumpBool($value);
            break;
        case 'integer':
            return self::dumpInt($value);
            break;
        case 'double':
            return self::dumpDouble($value);
            break;
        case 'string':
            return self::dumpStr($value);
            break;
        case 'array':
            return self::dumpArray($value);
            break;
        case 'object':
            return self::dumpObject($value);
            break;
        case 'resource':
            return 'resource';
            break;
        case 'NULL':
            return 'null';
            break;
        case 'unknown type':
            return 'unknown type';
            break;
        }
    }

    static function dumpInt($value) {
        return $value;
    }

    static function dumpBool($value) {
        if($value) {
            return 'true';
        } else {
            return 'false';
        }
    }

    static function dumpDouble($value) {
        return $value;
    }

    static function dumpStr($value) {
        if(empty($value)) {
            return 's:0:""';
        }
        $l = strlen($value);
        $value = str_replace(["\n"],['\n'],$value);
        return "s:$l:$value";
    }

    static function dumpArray($value,$level=1) {
        if(empty($value)) {
            return 'a:0:[]';
        }
        $padding = str_pad('',$level*2,' ');
        $r = 'a:'.count($value).":[\n";
        foreach($value as $k=>$v) {
            if (gettype($v)=='array') {
                $dumped_value = self::dumpArray($v,$level+1);
            } else {
                $dumped_value = self::dump($v);
            }
            $r .= $padding.$k.'=>'.$dumped_value."\n";
        }
        $r .= str_pad('',($level-1)*2,' ').']';
        return $r;
    }

    static function dumpObject($value) {
        return 'Object <'.get_class($value).'>';
    }
}
