<?php
namespace Notes\Service;

use Notes\Domain\Note as NoteDomain;
use Notes\Model\Note as NoteModel;

class Note
{
    public function get($noteModel)
    {
        $noteDomain = new NoteDomain();
        $noteModel = $noteDomain->read($noteModel);
        return $noteModel;
    }
    public function delete($noteModel)
    {
        $noteModel->setIsDeleted('1');
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->update($noteModel);
        return $noteModel;
    }
    public function post($noteModel)
    {
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->create($noteModel);
        return $noteModel;
    }
}
