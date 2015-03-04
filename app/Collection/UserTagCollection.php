<?php

namespace Notes\Collection;

use Notes\Model\UserTag as UserTagModel;

class UserTagCollection extends Collection
{
    public function __construct($resultset)
    {
        parent::__construct($resultset);
        foreach ($resultset as $key => $value) {
            $userTagModel = new UserTagModel();
            $userTagModel->setId($value['id']);
            $userTagModel->setUserId($value['userId']);
            $userTagModel->setTag($value['tag']);
            $userTagModel->setIsDeleted($value['isDeleted']);
            
            $this->add($userTagModel);
        }
    }
}
