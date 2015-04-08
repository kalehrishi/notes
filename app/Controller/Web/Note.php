<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Note as NoteService;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Model\Note as NoteModel;
use Notes\Response\Response as Response;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Note
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function get()
    {
        $fileName = "Note.php";
        $view     = new View();
        $view     = $view->render($fileName);
    }
    public function post()
    {
        $action = $_POST['button'];
        if ($action == "Submit") {
            $sessionModel = new SessionModel();
            $sessionModel->setUserId($_COOKIE['userId']);
            $sessionModel->setAuthToken($_COOKIE['authToken']);
            
            $sessionService = new SessionService();
            if ($sessionService->isValid($sessionModel)) {
                $input       = $this->request->getUrlParams();
                $noteService = new NoteService();
                try {
                    $response = $noteService->create($input);
                    print_r($response);
                } catch (\InvalidArgumentException $error) {
                    $response    = $error->getMessage();
                    $objResponse = new Response(200, "ok", "1.0.0", $response);
                    $fileName    = "Note.php";
                    $view        = new View();
                    $view        = $view->render($fileName, $objResponse->getResponse());
                } catch (ModelNotFoundException $error) {
                    $response    = $error->getMessage();
                    $objResponse = new Response(200, "ok", "1.0.0", $response);
                    $fileName    = "Note.php";
                    $view        = new View();
                    $view        = $view->render($fileName, $objResponse->getResponse());
                }
            } else {
                header('Location: login');
                exit();
            }
        } elseif ($action == "Logout") {
            header('Location: /');
            exit();
        }
    }
}
