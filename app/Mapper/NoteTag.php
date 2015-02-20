<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

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
        } else {
            throw new \Exception("Column 'noteId' cannot be null");
        }
    }
    
    public function read($noteTagModel)
    {
        $query            = " SELECT id,noteId,userTagId,isDeleted FROM NoteTags WHERE id=:id";
        $placeholder      = array(
            ':id' => $noteTagModel->getId()
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
            throw new \Exception("NoteTagId Does Not Present");
        }
    }

    public function delete($noteTagModel)
    {
        $query            = " UPDATE NoteTags SET isDeleted=1  WHERE id=:id";
        $placeholder      = array(
            ':id' => $noteTagModel->getId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database = new Database();
        $result   = $database->post($params);
        if ($result['rowCount'] == 1) {
            $noteTagModel->setIsDeleted(1);
            return $noteTagModel;
        } else {
            throw new \Exception("NoteTagId Does Not Present");
        }
        
    }
}
