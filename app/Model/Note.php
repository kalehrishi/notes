<?php
namespace Notes\Model;

class Note
{
    public $id;
    public $userId;
    public $title;
    public $body;
    public $createdOn;
    public $lastUpdatedOn;
    public $isDeleted;
    public $noteTags;
    
    public function getNoteTags()
    {
        return $this->noteTags;
    }
    public function setNoteTags($noteTags)
    {
        $this->noteTags = $noteTags;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }


    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBody()
    {
        return $this->body;
    }
    public function setBody($body)
    {
        $this->body = $body;
    }


    public function getCreatedOn()
    {
        return $this->createdOn;
    }
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    public function getLastUpdatedOn()
    {
        return $this->lastUpdatedOn;
    }
    public function setLastUpdatedOn($lastUpdatedOn)
    {
        $this->lastUpdatedOn = $lastUpdatedOn;
    }


    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }
}
