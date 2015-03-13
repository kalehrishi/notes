<?php

namespace Notes\Controller;

use Notes\Model\User as UserModel;

use Notes\Service\User as UserService;

class User
{
    public function __construct()
    {
        
    }
    public function create($request)
    {
        $userModel = new UserModel();
        $userModel->setFirstName($request['firstName']);
        $userModel->setLastName($request['lastName']);
        $userModel->setEmail($request['email']);
        $userModel->setPassword($request['password']);
        $userModel->setCreatedOn($request['createdOn']);
        try {
            $userService = new UserService();
            $response    = $userService->create($userModel);
        } catch (\InvalidArgumentException $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}
