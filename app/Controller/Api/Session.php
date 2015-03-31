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
        try {
            $sessionService = new SessionService();
            $userModel      = $sessionService->login($data);
        } catch (\InvalidArgumentException $e) {
            $this->message = $e->getMessage();
        }
        
    
        $objectResponse= new Response(200, $this->message, "1.0.0", $userModel->toArray());
        return $objectResponse->getResponse();
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
            $sessionModel         = $sessionService->logout($sessionModelRead);
            
        } catch (\InvalidArgumentException $e) {
            $this->message = $e->getMessage();
        }
        
        $objectResponse= new Response(200, $this->message, "1.0.0", $sessionModel->toArray());
        return $objectResponse->getResponse();
    }
}