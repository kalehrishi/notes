<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Note as NoteService;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

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
        
        $noteService = new NoteService();
        $response    = $noteService->get($input);
        
        $response = $response->toArray();
        if (empty($response)) {
            $response = "Note Not Created Yet!!! Create A New Note";
        }
        $objResponse = new Response($response);
        $this->view->render("Notes.php", $objResponse->getResponse());
        return $response;
    }
}
