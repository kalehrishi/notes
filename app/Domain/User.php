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
        $userMapper = new UserMapper();
        $userModel  = $userMapper->create($userModel);
        return $userModel;
        
        
    }
    
    public function read($input)
    {
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
            $userMapper = new UserMapper();
            $userModel  = $userMapper->read($userModel);
            return $userModel;
        
    }
    
    public function readByUsernameandPassword($input)
    {
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
            $userMapper = new UserMapper();
            $userModel  = $userMapper->read($userModel);
            return $userModel;
        
    }
    public function update($input)
    {
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
            $userMapper = new UserMapper();
            $userModel  = $userMapper->update($userModel);
            return $userModel;
        
        
    }
}
