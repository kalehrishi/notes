<?php
namespace Notes\Mapper;

use Notes\Mapper\Note as NoteMapper;
use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Note
{
    public function create(NoteModel $noteModel)
    {
        $noteModel->setCreatedOn(date("Y-m-d H:i:s"));
        $query     = "INSERT INTO Notes(userId, title, body, createdOn) VALUES (:userId, :title, :body, :createdOn)";
        $input     = array(
            'userId' => $noteModel->getUserId(),
            'title' => $noteModel->getTitle(),
            'body' => $noteModel->getBody(),
            'createdOn' => $noteModel->getCreatedOn()
        );
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
        
    public function update(NoteModel $noteModel)
    {
        $noteModel->setLastUpdatedOn(date("Y-m-d H:i:s"));
        $input  = array(
            'id' => $noteModel->getId(),
            'userId' => $noteModel->getUserId(),
            'title' => $noteModel->getTitle(),
            'body' => $noteModel->getBody(),
            'isDeleted' => $noteModel->getIsDeleted(),
            'lastUpdateOn' => $noteModel->getLastUpdatedOn()
        );
        $sql    = "UPDATE Notes SET 
                    userId=:userId, title=:title, body=:body, isDeleted=:isDeleted, lastUpdateOn=:lastUpdateOn
                    WHERE id=:id";
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
        if ($resultset == 1) {
            return $noteModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
    
    
    public function read(NoteModel $noteModel)
    {
        $input = array(
                'id' => $noteModel->getId()
            );
            $query = "SELECT id, userId, title, body, createdOn, lastUpdateOn, isDeleted
                        FROM Notes
                        WHERE id=:id AND isDeleted=0";
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
            $noteModel->setId($resultset[0]['id']);
            $noteModel->setUserId($resultset[0]['userId']);
            $noteModel->setTitle($resultset[0]['title']);
            $noteModel->setBody($resultset[0]['body']);
            $noteModel->setCreatedOn($resultset[0]['createdOn']);
            $noteModel->setLastUpdatedOn($resultset[0]['lastUpdateOn']);
            $noteModel->setIsDeleted($resultset[0]['isDeleted']);
            
            return $noteModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($noteModel);
            throw $obj;
        }
    }
}
