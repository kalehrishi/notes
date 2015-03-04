<?php
namespace Notes\Factory;

use Notes\Model\User as UserModel;

class UserFactory
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
    
    
    public function read($input)
    {
        $userModel = new UserModel();
        $userModel->setId($input['id']);
        return $userModel;
    }
    public function readByUsernameandPassword($input)
    {
        $userModel = new UserModel();
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        return $userModel;
    }
    
    
    public function update($input)
    {
        $userModel = new UserModel();
        $userModel->setId($input['id']);
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        return $userModel;
    }
}
