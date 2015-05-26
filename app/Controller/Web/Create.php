<?php
namespace Notes\Controller\Web;

use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\View\View as View;

class Create
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
        $this->view->render("Create.php");
    }
}
