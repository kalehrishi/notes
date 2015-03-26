<?php
namespace Notes\Controller;

use Notes\Service\User as UserService;

use Notes\Model\User as UserModel;

use Notes\Response\Response as Response;

use Notes\Model\Model as Model;

class User
{
    
    protected $request;
    public $message="Ok";
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
        } catch (\InvalidArgumentException $e) {
            $this->message = $e->getMessage();
        }
        catch (\Exception $e) {
            print_r($this->message = $e->getMessage());
        }
    
        $objectResponse= new Response(200, $this->message, "1.0.0", $userModel->toArray());
        return $objectResponse->getResponse();
    }
    
    public function update()
    {
        
        $data_array = $this->request->getData();
        $data       = $data_array['data'];
        
        $userModel = new UserModel();
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
        }
        $objectResponse= new Response(200, $this->message, "1.0.0", $userModel->toArray());
        return $objectResponse->getResponse();
    }
}
