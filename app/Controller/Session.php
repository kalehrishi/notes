<?php

namespace Notes\Controller;

use Notes\Model\User as UserModel;
use Notes\Model\Session as SessionModel;
use Notes\Service\Session as SessionService;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    public function post($request)
    {
        $userModel = new UserModel();
        $userModel->setEmail($request['email']);
        $userModel->setPassword($request['password']);
        try {
            $sessionService = new SessionService();
            $response       = $sessionService->login($userModel);
        } catch (\ModelNotFoundException $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
    
    public function delete($request)
    {
        $sessionModel = new sessionModel();
        
        $sessionModel->setAuthToken($request['authToken']);
        $sessionModel->setUserId($request['userId']);
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
