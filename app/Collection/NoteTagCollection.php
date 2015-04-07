<?php
namespace Notes\Collection;

use Notes\Model\UserTag as UserTagModel;
use Notes\Model\NoteTag as NoteTagModel;

class NoteTagCollection extends Collection
{
    public function __construct($resultset)
    {
        parent::__construct($resultset);
        for ($i = 0; $i < count($resultset); $i++) {
            $noteTagModel = new NoteTagModel();
            $noteTagModel->setId($resultset[$i]['id']);
            $noteTagModel->setNoteId($resultset[$i]['noteId']);
            $noteTagModel->setIsDeleted($resultset[$i]['isDeleted']);
            $userTagModel = new UserTagModel();
            $userTagModel->setId($resultset[$i]['userTag']['id']);
            $userTagModel->setTag($resultset[$i]['userTag']['tag']);
            $userTagModel->setUserId($resultset[$i]['userTag']['userId']);
            $userTagModel->setIsDeleted($resultset[$i]['userTag']['isDeleted']);
            $noteTagModel->setUserTagId($userTagModel->getId());
            $noteTagModel->setUserTag($userTagModel);
            $this->add($noteTagModel);
        }
    }
}
