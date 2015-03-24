<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

use Notes\Collection\Collection as Collection;

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
        $placeholder      = array(
            ':noteid' => $noteTagModel->getNoteId()
        );
        $query            = " SELECT id,noteId,userTagId,isDeleted FROM NoteTags WHERE noteId=:noteid and isDeleted=0";
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $noteTagModelbase = new Database();
        $resultset        = $noteTagModelbase->get($params);
        if (!empty($resultset)) {
            $noteTagcollection = new Collection();
            for ($i=0; $i < count($resultset); $i++) {
                $noteTagModel->setId($resultset[$i]['id']);
                $noteTagModel->setNoteId($resultset[$i]['noteId']);
                $noteTagModel->setUserTagId($resultset[$i]['userTagId']);
                $noteTagModel->setIsDeleted($resultset[$i]['isDeleted']);
            }
            $noteTagcollection->add($noteTagModel);
            return $noteTagcollection;
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
