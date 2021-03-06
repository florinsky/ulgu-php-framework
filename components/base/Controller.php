<?php
namespace X\components\base;

class Controller {
    public $layout = 'layouts/main.php';

    public function renderLayout($data) {
        return $this->render($this->layout, ['content'=>$data]);
    }

    public function render($view, $vars=null) {
        $view_file = 'views/'.$view;
        if(!file_exists($view_file)) {
            throw new \Exception("Render error: failed to find the view file [$view_file]");
        }
        ob_start();
        if($vars!==null) {
            extract($vars);
        }
        include($view_file);
        $s = ob_get_contents();
        ob_end_clean ();
        return $s;
    }

    public function e404Action() {
        return $this->render('layouts/404.php');
    }
}
