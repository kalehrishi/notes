<?php
namespace Notes\Service;

use Notes\Domain\UserTag as UserTagDomain;
use Notes\Model\UserTag as UserTagModel;

class UserTag
{
    public function get($userModel)
    {
        $userTagDomain = new UserTagDomain();
        $userTagModel = $userTagDomain->readTagsByUserId($userModel);
        return $userTagModel;
    }
}
