<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Note as NoteService;

use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

use Notes\Model\Note as NoteModel;

use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Note
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
            $response = $sessionService->isValid($sessionModel);
            
            $noteId = $this->request->getUrlParams();
            
            $noteModel = new NoteModel();
            $noteModel->setId($noteId);

            $noteService =  new NoteService();
            try {
                $noteModel = $noteService->get($noteModel);
            } catch (ModelNotFoundException $error) {
                $response    = $error->getMessage();
                $this->view->render("Note.php", $response);
            }
            $notesArray = $noteModel->toArray();
            $this->view->render("Note.php", $notesArray);
            return $noteModel;
        } catch (ModelNotFoundException $error) {
            $response    = "Session Is Invalid";
            $this->view->render("Error.php", $response);
        }
    }
}
