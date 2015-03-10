<?php
namespace Notes\Service;

use Notes\Mapper\User as UserMapper;

use Notes\Model\User as UserModel;

/**
*
*/
class User
{
  
    public function __construct()
    {
    
    }
    public function createUser($userInput)
    {
        $userMapper=new UserMapper();
        //how to convert user input to mode??
        //can we create model here?
        $user=new UserModel($userInput);
        $userMapper->create($user);
        return $user;
    }
}
