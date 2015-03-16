<?php

namespace Notes\Service;

use Notes\Domain\Session as SessionDomain;

class Session
{
    public function __construct()
    {
        
    }
    
    public function login($userModel)
    {
        $sessionDomain = new SessionDomain();
        
        $session = $sessionDomain->create($userModel);
        
        return $session;
    }
    
    public function logout($sessionModel)
    {
        $sessionDomain = new SessionDomain();
        
        $session = $sessionDomain->delete($sessionModel);
        
        return $session;
    }
    
    public function read($sessionModel)
    {
        $sessionDomain = new SessionDomain();
        
        $session = $sessionDomain->read($sessionModel);
        
        return $session;
    }
    
    public function isValid($sessionModel)
    {
        $sessionDomain = new SessionDomain();

        $session = $sessionDomain->getSessionByAuthTokenAndUserId($sessionModel);
        
        return $session;
    }
}
