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
        $this->validator = new InputValidator();
    }
    public function create($userTagModel)
    {
        $this->validator->notNull($userTagModel->getUserId());
        $this->validator->validNumber($userTagModel->getUserId());
        $this->validator->notNull($userTagModel->getTag());
        
        if ($userTagModel->getId() == null) {
            $userTagMpper = new UserTagMapper();
            $userTagModel = $userTagMpper->create($userTagModel);
        }
        
        return $userTagModel;
    }
    public function readTagsByUserId($userModel)
    {
        $this->validator->notNull($userModel->getId());
        $this->validator->validNumber($userModel->getId());
        
        $userTagModel = new UserTagModel();
        $userTagModel->setUserId($userModel->getId());
        
        $userTagMpper      = new UserTagMapper();
        $userTagCollection = $userTagMpper->readTagsByUserId($userTagModel);
        
        return $userTagCollection;
    }
    public function readTagById($userTagModel)
    {
        $this->validator->notNull($userTagModel->getId());
        $this->validator->validNumber($userTagModel->getId());
        
        $userTagMpper      = new UserTagMapper();
        $userTagCollection = $userTagMpper->readTagById($userTagModel);
        
        return $userTagCollection;
    }
}
