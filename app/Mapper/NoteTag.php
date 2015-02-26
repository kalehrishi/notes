<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class NoteTag
{
    
    public function create($noteTagModel)
    {
        $query            = "INSERT INTO NoteTags(noteId,userTagId) VALUES (:noteId,:userTagId)";
        $placeholder      = array(
            ':noteId' => $noteTagModel->getNoteId(),
            ':userTagId' => $noteTagModel->getUserTagId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $noteTagModelbase = new Database();
        $result           = $noteTagModelbase->post($params);
        if ($result['rowCount'] == 1) {
            $noteTagModel->setId($result['lastInsertId']);
            return $noteTagModel;
        }
    }
    
    public function read($noteTagModel)
    {
        $query            = " SELECT id,noteId,userTagId,isDeleted FROM NoteTags WHERE noteId=:noteid";
        $placeholder      = array(
            ':noteid' => $noteTagModel->getNoteId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $noteTagModelbase = new Database();
        $resultset        = $noteTagModelbase->get($params);
        if (!empty($resultset)) {
            $noteTagModel->setId($resultset[0]['id']);
            $noteTagModel->setNoteId($resultset[0]['noteId']);
            $noteTagModel->setUserTagId($resultset[0]['userTagId']);
            $noteTagModel->setIsDeleted($resultset[0]['isDeleted']);
            return $noteTagModel;
        } else {
            $exception = new ModelNotFoundException();
            $exception->setModel($noteTagModel);
            throw $exception;
        }
    }

    public function update($noteTagModel)
    {
        $query= " UPDATE NoteTags SET id=:id,noteId=:noteId,userTagId=:userTagId,isDeleted=:isDeleted WHERE id=:id";
        $placeholder      = array(
            ':id' => $noteTagModel->getId(),
            ':noteId'=>$noteTagModel->getNoteId(),
            ':userTagId'=>$noteTagModel->getUserTagId(),
            ':isDeleted'=>$noteTagModel->getIsDeleted(),
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database = new Database();
        $result   = $database->post($params);
        if ($result['rowCount'] == 1) {
            return $noteTagModel;
        } else {
            $exception = new ModelNotFoundException();
            $exception->setModel($noteTagModel);
            throw $exception;
        }
        
    }
}
