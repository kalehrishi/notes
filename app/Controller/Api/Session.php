<?php
namespace Notes\Controller\Api;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Model\User as UserModel;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    protected $request;
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view    = new View();
    }
    
    public function post()
    {
        $input = $this->request->getData();
        
        $userModel = new UserModel();
        $userModel->setId($input['id']);
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        
        $sessionService = new SessionService();
        try {
            $response = $sessionService->login($userModel);
            if ($response instanceof SessionModel) {
                setcookie('userId', $response->getUserId(), time() + (86400 * 30), "/");
                setcookie('authToken', $response->getAuthToken(), time() + (86400 * 30), "/");
                
                $objResponse = new Response($response->toArray(), 1, "SUCCESS");
                
                echo $objResponse->getResponse();
            }
        } catch (ModelNotFoundException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response, 0, "FAILURE");
            echo $objResponse->getResponse();
        }
    }
}
