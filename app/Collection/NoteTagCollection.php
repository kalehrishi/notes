<?php

namespace Notes\Collection;

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
            $noteTagModel->setUserTagId($resultset[$i]['userTagId']);
            $noteTagModel->setIsDeleted($resultset[$i]['isDeleted']);
            
            $this->add($noteTagModel);
        }
    }
}
