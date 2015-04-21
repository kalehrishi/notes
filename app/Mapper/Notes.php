<?php

namespace Notes\Mapper;

use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;
use Notes\Collection\Collection as Collection;
use Notes\Collection\NoteCollection as NoteCollection;

class Notes
{
    public function findAllNotesByUserId(NoteModel $noteModel)
    {
        $input  = array(
            'userId' => $noteModel->getUserId()
        );
        $query  = "SELECT id, userId, title, body, createdOn, lastUpdateOn, isDeleted
                    FROM Notes 
                    WHERE userId=:userId AND isDeleted=0";
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
        $noteCollection = new NoteCollection($resultset);
        
        return $noteCollection;
    }
}
