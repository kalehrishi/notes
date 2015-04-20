<?php
namespace Notes\Service;

use Notes\Domain\Note as NoteDomain;
use Notes\Model\Note as NoteModel;
use Notes\Mapper\Notes as NotesMapper;

class Notes
{
    public function get($userModel)
    {
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->findAllNotesByUserId($userModel);
        return $noteModel;
    }
}
