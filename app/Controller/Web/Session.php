<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
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
