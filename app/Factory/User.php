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
        
        if (isset($input['id']) && isset($input['firstName']) && isset($input['lastName']) && isset($input['email'])
            && isset($input['password']) && isset($input['createdOn'])) {
            $userModel->setId($input['id']);
            $userModel->setFirstName($input['firstName']);
            $userModel->setLastName($input['lastName']);
            $userModel->setEmail($input['email']);
            $userModel->setPassword($input['password']);
            $userModel->setCreatedOn($input['createdOn']);
            
            if ($this->validator->notNull($userModel->getId())
                && $this->validator->notNull($userModel->getFirstName())
                && $this->validator->validString($userModel->getFirstName())
                && $this->validator->validString($userModel->getLastName())
                && $this->validator->validEmail($userModel->getEmail())
                && $this->validator->isValidPassword($userModel->getPassword())) {
                return $userModel;
            }
            
            
        } else {
            if (!isset($input['id']) && isset($input['firstName'])
                && isset($input['lastName']) && isset($input['email'])
                && isset($input['password']) && isset($input['createdOn'])) {
                $userModel->setFirstName($input['firstName']);
                $userModel->setLastName($input['lastName']);
                $userModel->setEmail($input['email']);
                $userModel->setPassword($input['password']);
                $userModel->setCreatedOn($input['createdOn']);
                
                return $userModel;
                
                
            }
        }
        if (isset($input['id'])) {
            $userModel->setId($input['id']);
            if ($this->validator->notNull($userModel->getId())) {
                return $userModel;
                
            }
            
        }
        
        
        if (isset($input['email']) && isset($input['password'])) {
            $userModel->setEmail($input['email']);
            $userModel->setPassword($input['password']);
            if ($this->validator->validEmail($userModel->getEmail())
            && $this->validator->isValidPassword($userModel->getPassword())) {
                return $userModel;
                
            }
        } else {
            if (isset($input['email']) && !isset($input['password'])) {
                throw new \InvalidArgumentException("Input should not be null");
                
            }
            
        }
              
        
    }
}
