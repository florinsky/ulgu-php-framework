<?php

namespace X\components\response;

use X\components\base\Component;

class Response extends Component {

    private $headers = [];
    private $data = '';
    private $status_code = '200';

    function setHeaders($headers_list) {
        $this->headers = $headers_list;
    }

    function addHeaders($header) {
        $this->headers[] = $header;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setStatusCode($code) {
        $this->status_code = $code;
    }

    function send() {
        http_response_code($this->status_code);
        foreach($this->headers as $h) {
            header($h);
        }
        echo $this->data;
    }
}
