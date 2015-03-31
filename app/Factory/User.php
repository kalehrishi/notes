<?php
namespace Notes\Factory;

use Notes\Model\User as UserModel;
use Notes\Validator\InputValidator as InputValidator;

class User
{
    
    public function __construct()
    {
        $this->validator = new InputValidator();
        
    }
    public function create($input)
    {
        
        $userModel = new UserModel();
        if (((isset($input['firstName']) && $this->validator->validString($input['firstName']))
                && (isset($input['lastName']) && $this->validator->validString($input['lastName']))
                && (isset($input['email']) && $this->validator->notNull($input['email'])
                && $this->validator->validEmail($input['email']))
                && (isset($input['password']) && $this->validator->notNull($input['password'])
                && $this->validator->isValidPassword($input['password']))
                && (isset($input['createdOn'])))
            || ((isset($input['id']) && $this->validator->validNumber($input['id']))
                && (isset($input['firstName']) && $this->validator->validString($input['firstName']))
                && (isset($input['lastName']) && $this->validator->validString($input['lastName']))
                && (isset($input['email']) && $this->validator->notNull($input['email'])
                && $this->validator->validEmail($input['email'])) && (isset($input['password'])
                && $this->validator->notNull($input['password'])
                && $this->validator->isValidPassword($input['password']))
                && (isset($input['createdOn'])) && (!isset($input['id'])))
            || ((isset($input['id']) && $this->validator->validNumber($input['id'])))
            || ((isset($input['email']) && $this->validator->notNull($input['email'])
                && $this->validator->validEmail($input['email']))
                && (isset($input['password']) && $this->validator->notNull($input['password'])
                && $this->validator->isValidPassword($input['password'])))) {
            if (isset($input['id'])) {
                $userModel->setId($input['id']);
                
            }
            if (isset($input['firstName'])) {
                $userModel->setFirstName($input['firstName']);
                
                
            }
            if (isset($input['lastName'])) {
                $userModel->setLastName($input['lastName']);
                
                
            }
            if (isset($input['email'])) {
                $userModel->setEmail($input['email']);
                
                
            }
            if (isset($input['password'])) {
                $userModel->setPassword($input['password']);
                
            }
            if (isset($input['createdOn'])) {
                $userModel->setCreatedOn($input['createdOn']);
                
            }
            
        } else {
            throw new \InvalidArgumentException("Input should not be null");
            
        }
        
        return $userModel;
        
        
    }
}
