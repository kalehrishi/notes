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
        foreach ($input as $key => $value) {
            if ($key == 'id') {
                if ($this->validator->notNull($input['id'])) {
                    $userModel->setId($input['id']);
                    
                }
            }
            if ($key == 'firstName') {
                if ($this->validator->notNull($input['firstName'])
                 && $this->validator->validString($input['firstName'])
                 && $this->validator->validString($input['lastName'])) {
                    $userModel->setFirstName($input['firstName']);
                    $userModel->setLastName($input['lastName']);
                    $userModel->setCreatedOn($input['createdOn']);
                    
                }
            }
            
            if ($key == 'email') {
                if ($this->validator->validEmail($input['email'])
                    && $this->validator->isValidPassword($input['password'])) {
                    $userModel->setEmail($input['email']);
                    $userModel->setPassword($input['password']);
                    
                    
                }
            }
            
            
            
        }
        return $userModel;
        
    }
}
