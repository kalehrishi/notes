<?php
namespace Notes\Controller\Api;

use Notes\Service\User as UserService;

use Notes\Model\User as UserModel;

use Notes\Response\Response as Response;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class User
{
    
    protected $request;
    public $message = "OK";
    public $errormessage = "ResourceNotFound";
    
    public function __construct($request)
    {
        $this->request = $request;
        
    }
    
    public function create()
    {
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        
        $userModel = new UserModel();
        $userModel->setFirstName($data['firstName']);
        $userModel->setLastName($data['lastName']);
        $userModel->setEmail($data['email']);
        $userModel->setPassword($data['password']);
        $userModel->setCreatedOn($data['createdOn']);
        
        try {
            $userService = new UserService();
            $userModel  = $userService->createUser($data);
        
            
        } catch (\ModelNotFoundException $e) {
            $this->message = $e->setMessage();
            
            if ($e instanceof ModelNotFoundException) {
                $objectResponse = new Response(404, $this->errormessage, $userModel->toArray());
                $objectResponse->getResponse();
            }
            
        }
          
        $objectResponse = new Response(200, $this->message, $userModel->toArray());
        $objectResponse->getResponse();
        
    }
    
    public function update()
    {
        
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        $userModel  = new UserModel();
        $userModel->setId($data['id']);
        $userModel->setFirstName($data['firstName']);
        $userModel->setLastName($data['lastName']);
        $userModel->setEmail($data['email']);
        $userModel->setPassword($data['password']);
        $userModel->setCreatedOn($data['createdOn']);
        try {
            $userService = new UserService();
            $userModel   = $userService->updateUser($data);
        } catch (\ModelNotFoundException $e) {
            $this->message = $e->setMessage();
            
            if ($e instanceof ModelNotFoundException) {
                $objectResponse = new Response(404, $this->errormessage, $userModel->toArray());
                $objectResponse->getResponse();
            }
        }
        $objectResponse = new Response(200, $this->message, $userModel->toArray());
        $objectResponse->getResponse();
       
    }
}
