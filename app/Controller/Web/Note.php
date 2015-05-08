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
            $sessionService->isValid($sessionModel);
        } catch (ModelNotFoundException $error) {
            $app = \Slim\Slim::getInstance('developer');
            $app->redirect("/login");
        }
        $noteId = $this->request->getUrlParams();
        
        $noteModel = new NoteModel();
        $noteModel->setId($noteId);
        
        $noteService = new NoteService();
        try {
            $noteModel = $noteService->get($noteModel);
            $this->view->render("Note.php", $noteModel);
        } catch (ModelNotFoundException $error) {
            $response = $error->getMessage();
            $this->view->render("Note.php", $response);
        } catch (\Exception $error) {
            $response = $error->getMessage();
            $this->view->render("Note.php", $response);
        }
    }
    public function delete()
    {
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($this->request->getCookies()['userId']);
        $sessionModel->setAuthToken($this->request->getCookies()['authToken']);
        
        $sessionService = new SessionService();
        try {
            $sessionService->isValid($sessionModel);
        } catch (ModelNotFoundException $error) {
            $app = \Slim\Slim::getInstance('developer');
            $app->redirect("/login");
        }

        $noteModel = new NoteModel();
        $noteModel->setId($this->request->getUrlParams());
        $noteService = new NoteService();
        try {
            $noteModel = $noteService->get($noteModel);
            $noteModel = $noteService->delete($noteModel);
            if ($noteModel instanceof NoteModel) {
                $app = \Slim\Slim::getInstance('developer');
                $app->redirect("/notes");
            }
        } catch (ModelNotFoundException $error) {
            $response = $error->getMessage();
            $this->view->render("Notes.php", $response);
        } catch (\Exception $error) {
            $response = $error->getMessage();
            $this->view->render("Notes.php", $response);
        }
    }
}
