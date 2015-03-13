<?php

namespace Notes\Controller;

use Notes\Model\User as UserModel;
use Notes\Service\Session as SessionService;

class Session
{
    public function __construct()
    {
        
    }
    
    public function create($request)
    {
        $userModel = new UserModel();
        $userModel->setEmail($request[0]);
        $userModel->setPassword($request[1]);
        $sessionService = new SessionService();

        $session        = $sessionService->login($userModel);
        return $session;
    }
    
    public function delete($request)
    {
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($request[0]);
        $sessionModel->setExpiredOn($request[1]);
        $sessionModel->setIsExpired($request[2]);

        $sessionService = new SessionService();
        $session        = $sessionService->logout($sessionModel);
        return $session;
    }
    
    public function read($request)
    {
        $sessionModel = new SessionModel();
        $sessionModel->setId($request[0]);

        $sessionService = new SessionService();
        $session        = $sessionService->read($sessionModel);
        return $session;
    }
    public function isValid($request)
    {
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($request[0]);
        $sessionModel->setAuthToken($request[1]);

        $sessionService = new SessionService();
        $session = $sessionService->isValid($sessionModel);
        return $session;
    }
}
