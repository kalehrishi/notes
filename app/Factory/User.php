<?php
namespace Notes\Factory;

use Notes\Model\User as UserModel;

use Notes\Validator\InputValidator as InputValidator;

use Notes\PasswordValidation\PasswordValidator as PasswordValidator;

class User
{
    
    public function __construct()
    {
        $this->validator = new InputValidator();
        
    }
    public function create($input)
    {
        $userModel = new UserModel();
        
        
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        
        if ($this->validator->notNull($userModel->getFirstName())
            && $this->validator->notNull($userModel->getLastName())
            && $this->validator->notNull($userModel->getEmail())
            && $this->validator->notNull($userModel->getPassword())
            && $this->validator->validString($userModel->getFirstName())
            && $this->validator->validString($userModel->getLastName())
            && $this->validator->validEmail($userModel->getEmail())
            && $this->validator->isValidPassword($userModel->getPassword())) {
            return $userModel;
        }
    }
}
