<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Notes as NotesService;

use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

use Notes\Model\User as UserModel;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

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

    public function post()
    {
        print_r($this->request->getUrlParams());
        /*$app = \Slim\Slim::getInstance();
            $app->redirect("/notes");*/
    }

    
}
