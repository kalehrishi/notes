<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Note as NoteService;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\Model\User as UserModel;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;

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
        $input = $this->request->getCookies()['userId'];
        
        $userModel = new UserModel();
        $userModel->setId($input);

        $noteService = new NoteService();
        $noteCollection    = $noteService->get($userModel);
        
        $notesArray = $noteCollection->toArray();
        $response = $this->view->render("Notes.php", $notesArray);
        return $response;
    }
}
