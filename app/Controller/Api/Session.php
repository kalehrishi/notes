<?php
namespace Notes\Controller\Api;

use Notes\Model\User as UserModel;
use Notes\Model\Session as SessionModel;
use Notes\Service\Session as SessionService;
use Notes\Response\Response as Response;
use Notes\Model\Model as Model;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    protected $request;
    protected $message = "Ok";
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function post()
    {
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        
        
        try {
            $sessionService = new SessionService();
            $sessionModel   = new SessionModel();
            $sessionModel   = $sessionService->login($data);
        } catch (ModelNotFoundException $e) {
            $this->message = $e->setMessage();
        }
        $objResponse = new Response(200, $this->message, $sessionModel->toArray());
        return $objResponse->getResponse();
    }
    
    
    public function delete()
    {
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        
        $sessionModel = new sessionModel();
        $sessionModel->setAuthToken($data['authToken']);
        $sessionModel->setUserId($data['userId']);
        try {
            $sessionService = new SessionService();
            
            $sessionModelRead = $sessionService->isValid($sessionModel);
            
            $sessionModel = $sessionService->logout($sessionModelRead);
            
        } catch (ModelNotFoundException $e) {
            $this->message = $e->setMessage();
        }
        $objResponse = new Response(200, $this->message, $sessionModel->toArray());
        return $objResponse->getResponse();
    }
}
