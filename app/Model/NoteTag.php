<?php

namespace Notes\Model;

use Notes\Model\Note as NoteModel;

use Notes\Model\UserTag as UserTagModel;

class NoteTag
{
    private $id;
    private $noteId;
    private $userTagId;
    
    
    public function getId()
    {
        return $this->id;
    }
    public function getNoteId()
    {
        return $this->noteId;
    }
    public function getUserTagId()
    {
        return $this->userTagId;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNoteId($noteId)
    {
        $this->noteId = $noteId;
    }
    public function setUserTagId($userTagId)
    {
        $this->userTagId = $userTagId;
    }
}
