<?php
namespace Notes\Mapper;

use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Note
{
    public function create(NoteModel $noteModel)
    {
        $input     = array(
            'userId' => $noteModel->userId,
            'title' => $noteModel->title,
            'body' => $noteModel->body
        );
        $query     = "INSERT INTO Notes(userId, title, body) VALUES (:userId, :title, :body)";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $database  = new Database();
        $resultset = $database->post($params);
        if (!empty($resultset)) {
            $noteModel->id = $resultset['lastInsertId'];
            return $noteModel;
        } else {
            throw new \PDOException();
        }
    }
    
    public function delete(NoteModel $noteModel)
    {
        $input  = array(
            'id' => $noteModel->id,
            'isDeleted' => $noteModel->isDeleted
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
            $noteModel->id = $resultset['id'];
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
            'id' => $noteModel->id,
            'title' => $noteModel->title,
            'body' => $noteModel->body
        );
        $sql    = "UPDATE Notes SET title=:title, body=:body WHERE id=:id";
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
            return "Updated Successfully";
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
    
    
    public function read(NoteModel $noteModel)
    {
        $input = array(
            'id' => $noteModel->id
        );
        
        $query  = "SELECT id, title, body FROM Notes WHERE id=:id";
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
            $noteModel->id    = $resultset[0]['id'];
            $noteModel->title = $resultset[0]['title'];
            $noteModel->body  = $resultset[0]['body'];

            return $noteModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
}
