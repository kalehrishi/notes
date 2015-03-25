<?php

namespace Notes\Controller;

use Notes\Service\User as UserService;

use Notes\Model\User as UserModel;

class User
{
    
    protected $request;
    
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
        return $response;
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
        return $response;
    }
}
