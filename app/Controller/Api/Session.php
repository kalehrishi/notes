<?php
namespace Notes\Controller\Api;

use Notes\Response\Response as Response;
use Notes\Model\Session as SessionModel;
use Notes\Service\Session as SessionService;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;
use Notes\Model\User as UserModel;

class Session
{
    
    protected $request;
    public $message="Ok";
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function post()
    {
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        $userModel = new UserModel();
        $userModel->setEmail($data['email']);
        $userModel->setPassword($data['password']);
    
            $sessionService = new SessionService();
            $response     = $sessionService->login($data);
        if ($response) {
             $objectResponse= new Response(200, $this->message, "1.0.0", $userModel->toArray());
            return $objectResponse->getResponse();
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($sessionModel);
            throw $obj;
        }
    }
    
    public function delete()
    {
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        
        $sessionModel = new sessionModel();
        $sessionModel->setAuthToken($data['authToken']);
        $sessionModel->setUserId($data['userId']);
    
            $sessionService   = new SessionService();
            $sessionModelRead = $sessionService->isValid($sessionModel);
            $response         = $sessionService->logout($sessionModelRead);
            
        if ($response) {
            $objectResponse= new Response(200, $this->message, "1.0.0", $sessionModel->toArray());
            return $objectResponse->getResponse();
      
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($sessionModel);
            throw $obj;
        }
        
        $objectResponse= new Response(200, $this->message, "1.0.0", $sessionModel->toArray());
        return $objectResponse->getResponse();
    }
}
