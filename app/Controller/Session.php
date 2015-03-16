<?php

namespace Notes\Controller;

use Notes\Model\User as UserModel;
use Notes\Service\Session as SessionService;

class Session
{
    public function login($request)
    {
        $userModel = new UserModel();
        $userModel->setEmail($request[0]);
        $userModel->setPassword($request[1]);
        try {
            $sessionService = new SessionService();
            $response       = $sessionService->login($userModel);
        } catch (\InvalidArgumentException $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
    
    public function logout($request)
    {
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($request[0]);
        $sessionModel->setExpiredOn($request[1]);
        $sessionModel->setIsExpired($request[2]);
        try {
            $sessionService = new SessionService();
            $response       = $sessionService->logout($sessionModel);
        } catch (\InvalidArgumentException $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}
