<?php

namespace Notes\Model;

class Session
{
    private $id;
    private $userId;
    private $createdOn;
    private $expiredOn;
    private $isExpired;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }
    
    public function getCreatedOn()
    {
        return $this->createdOn;
    }
    
    public function setExpiredOn($expiredOn)
    {
        $this->expiredOn = $expiredOn;
    }
    
    public function getExpiredOn()
    {
        return $this->expiredOn;
    }
    
    public function setIsExpired($isExpired)
    {
        $this->isExpired = $isExpired;
    }
    
    public function getIsExpired()
    {
        return $this->isExpired;
    }
    
}