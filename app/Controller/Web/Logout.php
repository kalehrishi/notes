<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Logout
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
        if ($sessionService->isValid($sessionModel)) {
            $sessionModel->setIsExpired(1);
            try {
                $response = $sessionService->logout($sessionModel);
                echo '<script language="javascript">location.href="/login";
            </script>';
            } catch (ModelNotFoundException $error) {
                $response    = $error->getMessage();
                $objResponse = new Response($response);
                $this->view->render("Notes.php", $objResponse->getResponse());
            } catch (\InvalidArgumentException $error) {
                $response    = $error->getMessage();
                $objResponse = new Response($response);
                $this->view->render("Notes.php", $objResponse->getResponse());
            }
        }
    }
}
