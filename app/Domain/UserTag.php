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
            $obj = new ModelNotFoundException();
            $obj->setModel($userTagModel);
            throw $obj;
        }
        
        if (empty($userId)) {
            $obj = new ModelNotFoundException();
            $obj->setModel($userTagModel);
            throw $obj;
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

    public function update($userTagModel)
    {
        $this->validation($userTagModel);
        $userTagMpper = new UserTagMapper();
        $userTagModel = $userTagMpper->update($userTagModel);
        return $userTagModel;
    }
    public function delete($userTagModel)
    {
        $this->validation($userTagModel);
        $userTagModel->setIsDeleted(1);
        $userTagMpper = new UserTagMapper();
        $userTagModel = $userTagMpper->update($userTagModel);
        //Update NoteTag Domain
        return $userTagModel;
    }
}
