<?php

namespace Notes\Factory;

use Notes\Model\User as UserModel;
use Notes\Validator\InputValidator as InputValidator;

class User
{
    protected $userModel;
    protected $validator;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validator = new InputValidator();
    }
    
    
    private function doesContainOnlyId($input)
    {
        if (isset($input['id']) && !(isset($input['firstName'])
            || isset($input['lastName'])
            || isset($input['email'])
            || isset($input['password']))) {
            $this->validator->validNumber($input['id']);
            return true;
            
        } else {
            return false;
        }
        
    }
    private function doesContainsFirstNameLastNameEmailAndPassword($input)
    {
        if (isset($input['firstName']) && isset($input['lastName'])
              && isset($input['email']) && isset($input['password'])
              && !(isset($input['id']))) {
            $this->validator->validString($input['firstName']);
            $this->validator->validString($input['lastName']);
            $this->validator->validEmail($input['email']);
            $this->validator->isValidPassword($input['password']);
            return true;
            
        } else {
            return false;
        }
        
        
    }
    private function doesContainsAllProperties($input)
    {
        if (isset($input['id']) && isset($input['firstName'])
              && isset($input['lastName']) && isset($input['email'])
              && isset($input['password'])) {
            $this->validator->validNumber($input['id']);
            $this->validator->validString($input['firstName']);
            $this->validator->validString($input['lastName']);
            $this->validator->validEmail($input['email']);
            $this->validator->isValidPassword($input['password']);
            
            return true;
            
        } else {
            return false;
        }
    }
    
    private function doesContainsOnlyEmailAndPassword($input)
    {
        if (isset($input['email']) && isset($input['password'])
              && !(isset($input['firstName']) || isset($input['lastName'])
                    || isset($input['createdOn']) || isset($input['id']))) {
             $this->validator->validEmail($input['email']);
            $this->validator->isValidPassword($input['password']);

            return true;
            
        } else {
            return false;
        }
    }
    private function set($input)
    {
        if (isset($input['id'])) {
            $this->userModel->setId($input['id']);
            
        }
        if (isset($input['firstName'])) {
            $this->userModel->setFirstName($input['firstName']);
            
            
        }
        if (isset($input['lastName'])) {
            $this->userModel->setLastName($input['lastName']);
            
            
        }
        if (isset($input['email'])) {
            $this->userModel->setEmail($input['email']);
            
            
        }
        if (isset($input['password'])) {
            $this->userModel->setPassword($input['password']);
            
        }
        if (isset($input['createdOn'])) {
            $this->userModel->setCreatedOn($input['createdOn']);
            
        }
        
    }
    public function create($input)
    {
        if ($this->doesContainOnlyId($input)
              || $this->doesContainsFirstNameLastNameEmailAndPassword($input)
              || $this->doesContainsOnlyEmailAndPassword($input)
              || $this->doesContainsAllProperties($input)) {
            $this->set($input);
            return $this->userModel;

        } else {
            throw new \InvalidArgumentException("Input should not be null");
        }
    }
}
