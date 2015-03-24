<?php
namespace Notes\Controller;

use Notes\Model\User as UserModel;
use Notes\Model\Session as SessionModel;
use Notes\Service\Session as SessionService;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    protected $request;
    
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
        try {
            $sessionService = new SessionService();
            $userModel      = $sessionService->login($userModel);
        } catch (\ModelNotFoundException $e) {
            $response = $e->getMessage();
        }
        return $userModel;
    }
    
    public function delete()
    {
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        
        $sessionModel = new sessionModel();
        $sessionModel->setAuthToken($data['authToken']);
        $sessionModel->setUserId($data['userId']);
        try {
            $sessionService   = new SessionService();
            $sessionModelRead = $sessionService->isValid($sessionModel);
            $response         = $sessionService->logout($sessionModelRead);
            
        } catch (\ModelNotFoundException $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}
