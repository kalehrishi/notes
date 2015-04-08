<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function get()
    {
        $fileName = "Login.php";
        $view     = new View();
        $view     = $view->render($fileName);
    }
    public function post()
    {   
        $input          = $this->request->getUrlParams();
        $sessionService = new SessionService();
        try {
                $response = $sessionService->login($input);
            
            } catch (\InvalidArgumentException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response(200, "ok", "1.0.0", $response);
            $fileName    = "Login.php";
            $view        = new View();
            $view        = $view->render($fileName, $objResponse->getResponse());
        }
        catch (ModelNotFoundException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response(200, "ok", "1.0.0", $response);
            $fileName    = "Login.php";
            $view        = new View();
            $view        = $view->render($fileName, $objResponse->getResponse());
        }
        if ($response instanceof SessionModel) {
            setcookie('userId', $response->getUserId(), time() + (86400 * 30), "/");
            setcookie('authToken', $response->getAuthToken(), time() + (86400 * 30), "/");       
            
            header('Location: notes');
            exit();
        }
    }
}
