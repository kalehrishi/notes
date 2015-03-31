<?php
namespace Notes\Controller\Api;

use Notes\Service\Session as SessionService;
use Notes\Model\User as UserModel;
use Notes\Model\Session as SessionModel;
use Notes\Response\Response as Response;
use Notes\Model\Model as Model;

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
            $response    = $sessionService->login($data);
        } catch (\InvalidArgumentException $e) {
            $this->message = $e->getMessage();
        }
        catch (\Exception $e) {
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
            
            $response        = $sessionService->logout($sessionModelRead);
            
        } catch (\InvalidArgumentException $e) {
            $this->message = $e->getMessage();
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
        }
        $objectResponse= new Response(200, $this->message, "1.0.0", $sessionModel->toArray());
        return $objectResponse->getResponse();
    }
}
