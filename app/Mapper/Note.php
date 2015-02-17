<?php
namespace Notes\Mapper;

use Notes\Model\Note as NoteModel;
use Notes\Database\Database as Database;

class Note
{
    public function create($input)
    {
        $noteModel         = new NoteModel();
        $noteModel->userId = $input['userId'];
        $noteModel->title  = $input['title'];
        $noteModel->body   = $input['body'];
        
        $sql       = "INSERT INTO Notes(userId, title, body) VALUES (:userId, :title, :body)";
        $params    = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $db        = new Database();
        $resultset = $db->post($params);
        return $resultset;
    }
    
    public function delete($id)
    {
        $noteModel            = new NoteModel();
        $noteModel->id        = $id;
        $noteModel->isDeleted = 1;
        $input                = array(
            'id' => $id,
            'isDeleted' => 1
        );
        $db                   = new Database();
        $sql                  = "UPDATE Notes SET isDeleted=:isDeleted WHERE id=:id";
        $params               = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset            = $db->delete($params);
        return $resultset;
    }
    
    public function update($id)
    {
        $noteModel = new NoteModel();
        $input     = array(
            'id' => $id,
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        $db        = new Database();
        $sql       = "UPDATE Notes SET body=:body WHERE id=:id";
        $params    = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset = $db->update($params);
        return $resultset;
    }
    
    public function read($id)
    {
        $noteModel        = new NoteModel();
        $noteModel->id    = $id;
        $input            = array(
            'id' => $id
        );
        $db               = new Database();
        $sql              = "SELECT id, title, body FROM Notes WHERE id=:id";
        $params           = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset        = $db->get($params);
        $noteModel->title = $resultset[0]['title'];
        $noteModel->body  = $resultset[0]['body'];
        return $noteModel;
    }
}
