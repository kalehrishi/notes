<?php
namespace Notes\Controller;

use Notes\Model\User as UserModel;

use Notes\Service\User as UserService;

class User
{

    public function create($request)
    {
        
        $userModel = new UserModel();
        $userModel->setFirstName($request[0]);
        $userModel->setLastName($request[1]);
        $userModel->setEmail($request)[2];
        $userModel->setPassword($request[3]);
        $userModel->setCreatedOn($request[4]);
        
        $userService = new UserService();
        $user=$userService->create($userModel);
        return $user;
    }
}
