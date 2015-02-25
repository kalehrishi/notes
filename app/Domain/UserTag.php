<?php

namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\UserTag as UserTagMapper;

use Notes\Model\UserTag as UserTagModel;

use Notes\Validator\InputValidator as InputValidator;

class UserTag
{
    public function __construct()
    {
       $this->validator=new InputValidator();
    } 
    public function create($userTagModel)
    {
        
        if($this->validator->isEmpty($userTagModel->getUserId()) && $this->validator->validId($userTagModel->getUserId())
            &&  $this->validator->isEmpty($userTagModel->getTag()))      
        $userTagMpper = new UserTagMapper();
        $userTagModel = $userTagMpper->create($userTagModel);
        return $userTagModel;
    }
    public function read($userTagModel)
    {
        
        if($this->validator->isEmpty($userTagModel->getId()) && $this->validator->validId($userTagModel->getId()))  
        $userTagMpper = new UserTagMapper();
        $userTagModel = $userTagMpper->read($userTagModel);
        return $userTagModel;
    }
}
