<?php

namespace Notes\Controller\Web;

use Notes\View\View as View;

class Home
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function get()
    {
        $fileName = "Home.php";
        $view     = new View();
        $view     = $view->render($fileName, $this->request);
    }
}
