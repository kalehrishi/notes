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
        foreach ($input as $key => $value) {
            if ($key == 'id') {
                if ($this->validator->notNull($input['id'])) {
                    $userModel->setId($input['id']);
                    
                }
            }
            if ($key == 'firstName') {
                if ($this->validator->notNull($input['firstName'])) {
                    $userModel->setFirstName($input['firstName']);
                    
                }
            }
            if ($key == 'lastName') {
                if ($this->validator->notNull($input['lastName'])) {
                    $userModel->setLastName($input['lastName']);
                }
            }
            if ($key == 'email') {
                if ($this->validator->validEmail($input['email'])) {
                    $userModel->setEmail($input['email']);
                    
                }
            }
            if ($key == 'password') {
                if ($this->validator->isValidPassword($input['password'])) {
                    $userModel->setPassword($input['password']);
                    
                }
                
            }
            if ($key == 'createdOn') {
                $userModel->setCreatedOn($input['createdOn']);
                
            }
            
            
            
            
        }
        return $userModel;
        
    }
}
