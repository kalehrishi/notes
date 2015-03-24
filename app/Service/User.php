<?php

namespace Notes\Service;

use Notes\Domain\User as UserDomain;

class User
{
    
    public function __construct()
    {
        
    }
    public function create($userModel)
    {
        $userDomain = new UserDomain();
        
        $user = $userDomain->create($userModel);
        
        return $user;
        
    }
    public function update($userModel)
    {
        $userDomain = new UserDomain();
        
        $user = $userDomain->update($userModel);
        
        return $user;
        
    }

}
