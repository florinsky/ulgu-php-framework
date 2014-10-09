<?php

namespace X\components\response;


class ResponseHTML extends Response {

    function __construct($html) {
        $this->setStatusCode(200);
        $this->addHeaders('Content-type: text/html');
        $this->setData($html);
    }

}
