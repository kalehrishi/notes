<?php

namespace Notes\Mapper;

use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;
use Notes\Collection\NoteCollection as NoteCollection;

class Notes
{
    public function findAllNotesByUSerId(NoteModel $noteModel)
    {
        $input  = array(
            'userId' => $noteModel->getUserId()
        );
        $query  = "SELECT id, userId, title, body FROM Notes WHERE userId=:userId";
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        try {
            $database  = new Database();
            $resultset = $database->get($params);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
        
        if (!empty($resultset)) {
            return new NoteCollection($resultset);
            
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
}
