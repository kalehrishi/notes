<?php

namespace Notes\Service;

use Notes\Domain\Session as SessionDomain;

class Session
{
    public function __construct()
    {
        
    }
    
    public function login($userInput)
    {
        $sessionDomain = new SessionDomain();
        
        $session = $sessionDomain->create($userInput);
        
        return $session;
    }
    
    public function logout($sessionModel)
    {
        $sessionDomain = new SessionDomain();
        //print_r($sessionModel);
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
       // print_r($session);
        return $session;
    }
}
