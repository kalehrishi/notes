<?php
namespace Notes\Controller;

use Notes\Service\Session as SessionService;

class Session
{
    public function __construct()
    {
        
    }
    public function create($request)
    {
        $sessionService = new SessionService();
        $session        = $sessionService->login($request);
        return $session;
    }
    public function delete($request)
    {
        $sessionService = new SessionService();
        $session        = $sessionService->logout($request);
        return $session;
    }
    public function read($request)
    {
        $sessionService = new SessionService();
        $session        = $sessionService->read($request);
        return $session;
    }
}
