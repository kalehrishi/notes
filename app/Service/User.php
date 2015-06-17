<?php

namespace Notes\Service;

use Notes\Domain\User  as UserDomain;

class User
{
  
    public function __construct()
    {
    
    }
    public function create($input)
    {
        $userDomain=new UserDomain();
        
        $response=$userDomain->create($input);

        return $response;

    }
}
