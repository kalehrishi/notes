<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

class NoteTag
{
    
    public function create($data)
    {
        $query       = "INSERT INTO NoteTags(noteId,userTagId) VALUES (:noteId,:userTagId)";
        $placeholder = array(
            ':noteId' => $data->noteId,
            ':userTagId' => $data->userTagId
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        if ($result['rowCount'] == 1) {
            $data->id = $result['lastInsertId'];
            return $data;
        } else {
            throw new \Exception("Column 'noteId' cannot be null");
        }
    }
    
    public function read($data)
    {
        $query       = " SELECT id,noteId,userTagId FROM NoteTags WHERE id=:id";
        $placeholder = array(
            ':id' => $data->id
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $resultset   = $database->get($params);
        if (!empty($resultset)) {
            $data->id        = $resultset[0]['id'];
            $data->noteId    = $resultset[0]['noteId'];
            $data->userTagId = $resultset[0]['userTagId'];
            return $data;
        } else {
            throw new \Exception("NoteTagId Does Not Present");
        }
    }
}
