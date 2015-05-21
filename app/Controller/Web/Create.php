<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Notes as NotesService;

use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

use Notes\Model\Note as NoteModel;
use Notes\Model\UserTag as UserTagModel;
use Notes\Model\NoteTag as NoteTagModel;

use Notes\Service\Session as SessionService;
use Notes\Service\Create as CreateService;

use Notes\Model\Session as SessionModel;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;
use Notes\Collection\Collection as Collection;

use Notes\Collection\NoteTagCollection as NoteTagCollection;

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
        $input = $this->request->getUrlParams();
        
        $arrayOfObjs = json_decode($input['userTag']);
        
        $noteTags           = array(
            'id' => null,
            'noteId' => null,
            'userTagId' => null,
            'isDeleted' => 0
        );
        $finalNoteTagsArray = array();
        for ($i = 0; $i < count($arrayOfObjs); $i++) {
            $arrayOfObjs[$i]->userId = $this->request->getCookies()['userId'];
            if ($arrayOfObjs[$i]->id == null) {
                $noteTags['userTag'] = (array) $arrayOfObjs[$i];
            } else {
                $noteTags['userTagId'] = $arrayOfObjs[$i]->id;
                $noteTags['userTag']   = (array) $arrayOfObjs[$i];
            }
            array_push($finalNoteTagsArray, $noteTags);
        }
        $noteTagCollection = new NoteTagCollection($finalNoteTagsArray);
        
        $sessionModel      = new SessionModel();
        $sessionModel->setUserId($this->request->getCookies()['userId']);
        $sessionModel->setAuthToken($this->request->getCookies()['authToken']);
        
        $sessionService = new SessionService();
        try {
            $sessionService->isValid($sessionModel);
        } catch (ModelNotFoundException $error) {
            $app = \Slim\Slim::getInstance();
            $app->redirect("/login");
        }
        $noteModel = new NoteModel();
        $noteModel->setUserId($this->request->getCookies()['userId']);
        $noteModel->setTitle($input['title']);
        $noteModel->setBody($input['body']);
        $noteModel->setNoteTags($noteTagCollection);
        
        $createService = new CreateService();
        $noteModel     = $createService->post($noteModel);
        
        if ($noteModel instanceof NoteModel) {
            $app = \Slim\Slim::getInstance();
            $app->redirect("/notes");
        }
        
    }
}
