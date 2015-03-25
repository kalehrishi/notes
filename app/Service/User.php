<?php
namespace Notes\Service;

use Notes\Domain\User as UserDomain;

use Notes\Factory\User as UserFactory;


use Notes\Model\User as UserModel;

class User
{
    
    public function __construct()
    {
        
    }
    public function createUser($userInput)
    {
        $userDomain = new UserDomain();
        
        $user = $userDomain->create($userInput);
        
        return $user;
        
    }
    
    public function readUser($userInput)
    {
        $userDomain = new UserDomain();
        
        $user = $userDomain->readByUsernameandPassword($userInput);
        
        return $user;
    }
    
    public function updateUser($userInput)
    {
        $userDomain = new UserDomain();
        
        $user = $userDomain->update($userInput);
        
        return $user;
    }
}
