<?php
namespace Notes\Controller\Api;

use Notes\Service\User as UserService;

use Notes\Model\User as UserModel;

use Notes\Response\Response as Response;

use Notes\Model\Model as Model;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class User
{
    
    protected $request;
    public $message = "Ok";
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
            $response    = $userService->createUser($data);
            
        } catch (\ModelNotFoundException $e) {
            $this->message = $e->getMessage();
           
        }
        catch (\Exception $e) {
            print_r($this->message = $e->getMessage());
        
        }
        
        $objectResponse = new Response(200, $this->message, "1.0.0", $response->toArray());
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
            $response    = $userService->updateUser($data);
        } catch (\ModelNotFoundException $e) {
            $response = $e->getMessage();
            
            if ($e instanceof ModelNotFoundException) {
                $objectResponse = new Response(404, $this->message, "ResourceNotFound", $response->toArray());
                return $objectResponse->getResponse();
                
            }
            
        }
        $objectResponse = new Response(200, $this->message, "1.0.0", $response->toArray());
        return $objectResponse->getResponse();
        
    }
}
