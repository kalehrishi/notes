<?php
namespace Notes\Service;

use Notes\Domain\Note as NoteDomain;
use Notes\Model\Note as NoteModel;

class Create
{
    public function post(NoteModel $noteModel)
    {
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->create($noteModel);
        return $noteModel;
    }
}
