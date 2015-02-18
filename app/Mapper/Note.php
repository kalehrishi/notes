<?php
namespace Notes\Mapper;

use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;

class Note
{
    public function create(NoteModel $noteModel)
    {
        try {
            $input = array(
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
            return $resultset;
        } catch (\PDOException $e) {
            $e = "Title Parameter Missing";
            return $e;
        }
    }
    
    public function delete(NoteModel $noteModel)
    {
        $input     = array(
            'id' => $noteModel->id,
            'isDeleted' => $noteModel->isDeleted
        );
        $database  = new Database();
        $sql       = "UPDATE Notes SET isDeleted=:isDeleted WHERE id=:id";
        $params    = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset = $database->delete($params);
        return $resultset;
        
    }
    
    public function update(NoteModel $noteModel)
    {
        $input = array(
            'id' => $noteModel->id,
            'title' => $noteModel->title,
            'body' => $noteModel->body
        );
        
        $database  = new Database();
        $sql       = "UPDATE Notes SET title=:title, body=:body WHERE id=:id";
        $params    = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset = $database->update($params);
        return $resultset;
    }
    
    public function read(NoteModel $noteModel)
    {
        
        $input = array(
            'id' => $noteModel->id
        );
        
        $database  = new Database();
        $query       = "SELECT id, title, body FROM Notes WHERE id=:id";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $resultset = $database->get($params);
        if (!empty($resultset)) {
            $noteModel->title = $resultset[0]['title'];
            $noteModel->body  = $resultset[0]['body'];
            return $noteModel;
        } else {
            return "Note Id Does Not Exists";
        }
    }
}
