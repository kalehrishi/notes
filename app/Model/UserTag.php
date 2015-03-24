<?php

namespace Notes\Model;

use Notes\Model\User as UserModel;

class UserTag extends Model
{
    protected $id;
    protected $userId;
    protected $tag;
    protected $isDeleted;
    
    
    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getTag()
    {
        return $this->tag;
    }
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }
}
