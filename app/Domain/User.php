<?php
namespace Notes\Domain;

use Notes\Model\User as UserModel;

use Notes\Mapper\User as UserMapper;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Validator\InputValidator as InputValidator;

use Notes\PasswordValidation\PasswordValidator as PasswordValidator;

use Notes\Factory\User as UserFactory;

class User
{
    
    public function __construct()
    {
        $this->validator = new InputValidator();
        
    }
    
    public function create($input)
    {
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        

        if ($this->validator->notNull($userModel->getFirstName())
            && $this->validator->notNull($userModel->getLastName())
            && $this->validator->notNull($userModel->getEmail())
            && $this->validator->notNull($userModel->getPassword())
            && $this->validator->validString($userModel->getFirstName())
            && $this->validator->validString($userModel->getLastName())
            && $this->validator->validEmail($userModel->getEmail())
            && $this->validator->isValidPassword($userModel->getPassword())) {
            $userMapper = new UserMapper();
            $userModel  = $userMapper->create($userModel);
            return $userModel;
            
        }
    }
    
    public function read($userModel)
    {
        
        if ($this->validator->notNull($userModel->getId())
            && $this->validator->validNumber($userModel->getId())) {
            $userMapper = new UserMapper();
            $userModel  = $userMapper->read($userModel);
            return $userModel;
        }
    }
    
    public function readByUsernameandPassword($userModel)
    {
        
        if ($this->validator->validEmail($userModel->getEmail())
            && $this->validator->notNull($userModel->getPassword())) {
            $userMapper = new UserMapper();
            $userModel  = $userMapper->read($userModel);
            return $userModel;
        }
    }
    public function update($userModel)
    {
        
        if ($this->validator->validString($userModel->getFirstName())
            && $this->validator->validString($userModel->getLastName())
            && $this->validator->validEmail($userModel->getEmail())
            && $this->validator->notNull($userModel->getPassword())) {
            $userMapper = new UserMapper();
            $userModel  = $userMapper->update($userModel);
            return $userModel;
        }
        
    }
}
