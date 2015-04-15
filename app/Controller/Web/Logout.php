<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;

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
            } catch (ModelNotFoundException $error) {
            	$response    = $error->getMessage();
            	$objResponse = new Response($response);
            	$this->view->render("Notes.php", $objResponse->getResponse());
        	}
        	echo '<script language="javascript">location.href="http://notes.com/login";
            </script>';
        }
    }
}
