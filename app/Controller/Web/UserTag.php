<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;

use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

use Notes\Model\User as UserModel;
use Notes\Collection\Collection as Collection;

use Notes\Service\UserTag as UserTagService;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class UserTag
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
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($this->request->getCookies()['userId']);
        $sessionModel->setAuthToken($this->request->getCookies()['authToken']);
        
        $sessionService = new SessionService();
        try {
            $sessionService->isValid($sessionModel);
        } catch (ModelNotFoundException $error) {
            $app = \Slim\Slim::getInstance();
            $app->redirect("/login");
        }
        $userId = $this->request->getCookies()['userId'];
        $userModel = new UserModel();
        $userModel->setId($userId);
        $userTagService = new UserTagService();
        try {
            $userTagModel = $userTagService->get($userModel);
            $toArray = $userTagModel->toArray();
            $json =  json_encode($toArray);
            echo $json;
            
        } catch (ModelNotFoundException $error) {
            $response = $error->getMessage();
            $this->view->render("Note.php", $response);
        }

    }
}
