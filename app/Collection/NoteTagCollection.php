<?php

namespace Notes\Collection;

use Notes\Model\NoteTag as NoteTagModel;

class NoteTagCollection extends Collection
{
    public function __construct($resultset)
    {
        parent::__construct($resultset);
        foreach ($resultset as $key => $value) {
            $noteTagModel = new NoteTagModel();
            $noteTagModel->setId($value['id']);
            $noteTagModel->setNoteId($value['noteId']);
            $noteTagModel->setUserTagId($value['userTagId']);
            $noteTagModel->setIsDeleted($value['isDeleted']);
            
            $this->add($noteTagModel);
        }
    }
}
