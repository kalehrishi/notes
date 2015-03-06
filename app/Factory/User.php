<?php
namespace Notes\Factory;

use Notes\Model\User as UserModel;

class User
{
    
    public function create($input)
    {
        $userModel = new UserModel();
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        return $userModel;
    }
}
