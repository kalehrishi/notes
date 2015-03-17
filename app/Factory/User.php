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
        
        
        if ((isset($input['id']) && $this->validator->notNull($input['id']))
            && (isset($input['firstName']) && $this->validator->validString($input['firstName']))
            && (isset($input['lastName']) && $this->validator->validString($input['lastName']))
            && (isset($input['email']) && $this->validator->validString($input['email']))
            && (isset($input['password']) && $this->validator->isValidPassword($input['password']))
            && (isset($input['createdOn']))) {
            $userModel->setId($input['id']);
            $userModel->setFirstName($input['firstName']);
            $userModel->setLastName($input['lastName']);
            $userModel->setEmail($input['email']);
            $userModel->setPassword($input['password']);
            $userModel->setCreatedOn($input['createdOn']);
            
            return $userModel;
            
        }
        
        
        if ((!isset($input['id'])) && (isset($input['firstName'])
            && $this->validator->validString($input['firstName'])) && (isset($input['lastName'])
            && $this->validator->validString($input['lastName'])) && (isset($input['email'])
            && $this->validator->validString($input['email'])) && (isset($input['password'])
            && $this->validator->isValidPassword($input['password'])) && (isset($input['createdOn']))) {
            $userModel->setFirstName($input['firstName']);
            $userModel->setLastName($input['lastName']);
            $userModel->setEmail($input['email']);
            $userModel->setPassword($input['password']);
            $userModel->setCreatedOn($input['createdOn']);
            
            return $userModel;
            
            
        }
        
        if ((isset($input['id']) && $this->validator->notNull($input['id']))) {
            $userModel->setId($input['id']);
            return $userModel;
            
        }
        
        if ((isset($input['email']) && $this->validator->validString($input['email']))
            && (isset($input['password']) && $this->validator->isValidPassword($input['password']))) {
            $userModel->setEmail($input['email']);
            $userModel->setPassword($input['password']);
            
            return $userModel;
            
        }
        
        
        
        $userModel->setId($input['id']);
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        
        if (isset($input['id']) && $this->validator->notNull($input['id'])) {
             return $userModel;
        }
        if (isset($input['firstName']) && $this->validator->validString($input['firstName'])) {
             return $userModel;
            
        } if (isset($input['lastName']) && $this->validator->validString($input['lastName'])) {
              return $userModel;
        }
        if (isset($input['email']) && $this->validator->validString($input['email'])) {
              return $userModel;
            
        }
        if (isset($input['password']) && $this->validator->isValidPassword($input['password'])) {
            return $userModel;
        }
        if (isset($input['createdOn']) && $this->validator->isValidPassword($input['createdOn'])) {
            return $userModel;
        } else {
            throw new \InvalidArgumentException("Input should not be null");
            
        }
        
        
        
    }
}
