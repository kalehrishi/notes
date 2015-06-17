<?php

namespace Notes\Model;

class Session extends Model
{
    protected $id;
    protected $userId;
    protected $authToken;
    protected $createdOn;
    protected $expiredOn;
    protected $isExpired;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }
    
    public function getAuthToken()
    {
        return $this->authToken;
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
    public function createAuthToken($password, $randomNumber)
    {
        $authToken = md5($password.$randomNumber);
        $this->setAuthToken($authToken);
    }
}
