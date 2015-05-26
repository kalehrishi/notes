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

class Notes
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

            $userModel = new UserModel();
            $userModel->setId($this->request->getCookies()['userId']);
            
            $notesService   = new NotesService();
            $notesCollection = $notesService->get($userModel);
            
            $notesArray = $notesCollection->toArray();
            $noteCollection = $notesService->get($userModel);
            
            $response   = $this->view->render("Notes.php", $noteCollection);
            
            return $response;
        } catch (ModelNotFoundException $error) {
            $app = \Slim\Slim::getInstance('developer');
            $app->redirect("/error");
        }
    }
}
