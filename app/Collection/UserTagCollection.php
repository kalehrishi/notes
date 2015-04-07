<?php

namespace Notes\Collection;

use Notes\Model\UserTag as UserTagModel;

class UserTagCollection extends Collection
{
    public function __construct($resultset)
    {
        parent::__construct($resultset);
        for ($i = 0; $i < count($resultset); $i++) {
            $userTagModel = new UserTagModel();
            $userTagModel->setId($resultset[$i]['id']);
            $userTagModel->setUserId($resultset[$i]['userId']);
            $userTagModel->setTag($resultset[$i]['tag']);
            $userTagModel->setIsDeleted($resultset[$i]['isDeleted']);
            $this->add($userTagModel);
        }
    }
}
