<?php
namespace Notes\Controller;

use Notes\Model\User as UserModel;
use Notes\Model\Session as SessionModel;
use Notes\Service\Session as SessionService;
use Notes\Response\Response as Response;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

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
        
        try {
            $sessionService = new SessionService();
            $userModel      = $sessionService->login($data);

        } catch (\ModelNotFoundException $e) {
            $response = $e->getMessage();
        }
        
     $objResponse= new Response(200,$this->message,"1.0.0",$userModel->toArray());
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
            $sessionService   = new SessionService();
            $sessionModelRead = $sessionService->isValid($sessionModel);
            $sessionModel         = $sessionService->logout($sessionModelRead);
            
        } catch (\ModelNotFoundException $e) {
            $response = $e->getMessage();
        }
        
   $objResponse= new Response(200,$this->message,"1.0.0",$sessionModel->toArray());
       return $objResponse->getResponse();
       print_r($objResponse);
   }
}

