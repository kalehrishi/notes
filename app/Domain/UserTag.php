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
        
        if ($this->validator->notNull($userTagModel->getUserId())
            && $this->validator->validNumber($userTagModel->getUserId())
            && $this->validator->notNull($userTagModel->getTag())) {
            $userTagMpper = new UserTagMapper();
            $userTagModel = $userTagMpper->create($userTagModel);
            return $userTagModel;
        }
    }
    public function readAllTag($userTagModel)
    {
        
        if ($this->validator->notNull($userTagModel->getUserId())
            && $this->validator->validNumber($userTagModel->getUserId())) {
            $userTagMpper = new UserTagMapper();
            $userTagCollection = $userTagMpper->read($userTagModel);
            return $userTagCollection;
        }
    }

    public function readByUserTagId($userTagModel)
    {
        
        if ($this->validator->notNull($userTagModel->getId())
            && $this->validator->validNumber($userTagModel->getId())) {
            $userTagMpper = new UserTagMapper();
            $userTagModel = $userTagMpper->readByUserTagId($userTagModel);
            return $userTagModel;
        }
    }
}
