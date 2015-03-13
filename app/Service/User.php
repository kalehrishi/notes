<?php
namespace Notes\Service;

use Notes\Domain\User as UserDomain;

class User
{
    
    public function __construct()
    {
        
    }
    public function createUser($userModel)
    {
        $userDomain = new UserDomain();
        
        $user = $userDomain->create($userModel);
        
        return $user;
        
    }
}
