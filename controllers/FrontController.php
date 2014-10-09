<?php

namespace X\controllers;

use X\components\base\Controller;
use X\components\response\ResponseHTML;

class FrontController extends Controller {

    public function indexAction() {
        return $this->render('front/index.php', ['data'=>$this]);
    }

    public function aboutAction() {
        return $this->render('front/about.php');
    }

}

