<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

class NoteTag
{
    
    public function create($model)
    {
        $query       = "INSERT INTO NoteTags(noteId,userTagId) VALUES (:noteId,:userTagId)";
        $placeholder = array(
            ':noteId' => $model['noteId'],
            ':userTagId' => $model['userTagId']
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        if ($result['rowCount'] == 1) {
            return $result['lastInsertId'];
        } else {
            return "Inserting Failed";
        }
    }
    
    public function read($model)
    {
        $query       = " SELECT id,noteId,userTagId FROM NoteTags WHERE id=:id";
        $placeholder = array(
            ':id' => $model['id']
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $resultset   = $database->get($params);
        if (!empty($resultset)) {
            return $resultset;
        } else {
            return "NoteTag is not Exit";
        }
    }
}
