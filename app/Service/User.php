<?php

namespace Notes\Service;

use Notes\Domain\User  as UserDomain;

class User
{
  
    public function __construct()
    {
    
    }
    public function create($request)
    {
        $userDomain=new UserDomain();
        
        $response=$userDomain->create($request);

        return $response;

    }
}
