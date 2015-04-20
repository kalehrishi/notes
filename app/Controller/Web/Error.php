<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;

class Error
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function get()
    {
        $fileName = "Error.php";
        $view     = new View();
        $view     = $view->render($fileName);
    }
}
