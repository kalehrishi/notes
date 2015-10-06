<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Request\Request as Request;
use Notes\Factory\Layout as Layout;

class Login
{
    protected $request;
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view    = new View();
    }
}
