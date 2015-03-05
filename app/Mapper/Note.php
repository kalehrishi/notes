<?php

namespace Notes\Mapper;

use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;
use Notes\Collection\NoteCollection as NoteCollection;

class Note
{
    public function create(NoteModel $noteModel)
    {
        $input     = array(
            'userId' => $noteModel->getUserId(),
            'title' => $noteModel->getTitle(),
            'body' => $noteModel->getBody()
        );
        $query     = "INSERT INTO Notes(userId, title, body) VALUES (:userId, :title, :body)";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $database  = new Database();
        $resultset = $database->post($params);
        if (!empty($resultset)) {
            $noteModel->setId($resultset['lastInsertId']);
            return $noteModel;
        } else {
            throw new \PDOException();
        }
    }
    
    public function delete(NoteModel $noteModel)
    {
        $input  = array(
            'id' => $noteModel->getId(),
            'isDeleted' => $noteModel->getIsDeleted()
        );
        $sql    = "UPDATE Notes SET isDeleted=:isDeleted WHERE id=:id";
        $params = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        try {
            $database  = new Database();
            $resultset = $database->update($params);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
        if (!empty($resultset)) {
            return $noteModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
    
    public function update(NoteModel $noteModel)
    {
        $input  = array(
            'id' => $noteModel->getId(),
            'title' => $noteModel->getTitle(),
            'body' => $noteModel->getBody()
        );
        $sql    = "UPDATE Notes SET title=:title, body=:body WHERE id=:id";
        $params = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        try {
            $database  = new Database();
            $resultset = $database->post($params);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
        if ($resultset['rowCount'] == 1) {
            return $noteModel ;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
    
    
    public function read(NoteModel $noteModel)
    {
        if (!empty($noteModel->userId)) {
            $input = array(
                'userId' => $noteModel->getUserId()
            );
            $query = "SELECT id, userId, title, body FROM Notes WHERE userId=:userId";
        } else {
            $input = array(
                'id' => $noteModel->getId()
            );
            $query = "SELECT id, userId, title, body FROM Notes WHERE id=:id";
        }
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
