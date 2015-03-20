<?php
namespace Notes\Collection;

use Notes\Model\Note as NoteModel;

class NoteCollection extends Collection
{
    public function __construct($resultset)
    {
        parent::__construct($resultset);
        for ($i = 0; $i < count($resultset); $i++) {
            $noteModel = new NoteModel();
            $noteModel->setId($resultset[$i]['id']);
            $noteModel->setUserId($resultset[$i]['userId']);
            $noteModel->setTitle($resultset[$i]['title']);
            $noteModel->setBody($resultset[$i]['body']);
            $noteModel->setIsDeleted($resultset[$i]['isDeleted']);
            $this->add($noteModel);
        }
    }
}
