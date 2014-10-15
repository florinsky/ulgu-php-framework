<?php

namespace X\components;

use X;
use X\components\base\Component;

class Request extends Component {
    public function get($key) {
        if(isset($_GET[$key])) {
            return $_GET[$key];
        } else {
            return null;
        }
    }
    public function post($key) {
        if(isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            return null;
        }
    }
    public function getRoute() {
        return ['Frontend','index'];
    }
}

