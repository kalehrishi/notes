<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Request\Request as Request;

class Login
{
    protected $request;
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view    = new View();
    }
    public function get()
    {
        $this->view->render("Login.php");
    }
}
