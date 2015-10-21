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

use Notes\Factory\Layout as Layout;

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
            
            $noteCollection = $notesService->get($userModel);
            
            $toArray = $noteCollection->toArray();
            
            $objResponse = new Response($toArray, 1, "SUCCESS");
                
            echo $objResponse->getResponse();
        } catch (ModelNotFoundException $error) {
            $response = $error->getMessage();
            $objResponse = new Response($response, 0, "FAILURE");
                
            echo $objResponse->getResponse();
        }
    }
}
