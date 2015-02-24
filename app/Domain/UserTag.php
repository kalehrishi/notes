<?php

namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\UserTag as UserTagMapper;

use Notes\Model\UserTag as UserTagModel;

class UserTag
{
    public function validation($userTagModel)
    {
        $tag=$userTagModel->getTag();
        $userId=$userTagModel->getUserId();
        if (empty($tag)) {
            throw new \Exception("Column 'tag' cannot be null");
        }
        
        if (empty($userId)) {
            throw new \Exception("Column 'userId' cannot be null");
        }

        return $userTagModel;
    }
    public function create($userTagModel)
    {
        $this->validation($userTagModel);
        $userTagMpper = new UserTagMapper();
        $userTagModel = $userTagMpper->create($userTagModel);
        return $userTagModel;
    }
    public function read($userTagModel)
    {
        
        $userTagMpper = new UserTagMapper();
        $userTagModel = $userTagMpper->read($userTagModel);
        return $userTagModel;
    }
}
