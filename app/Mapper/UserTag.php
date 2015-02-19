<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

class UserTag
{
    public function create($data)
    {
        $query       = "INSERT INTO UserTags(userId,tag) VALUES (:userId,:tag)";
        $placeholder = array(
            ':userId' => $data->userId,
            ':tag' => $data->tag
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
            throw new \Exception("Column 'userId' cannot be null");
        }
    }
    
    public function read($data)
    {
        $query       = " SELECT id,userId,tag,isDeleted FROM UserTags WHERE id=:id";
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
            $data->userId    = $resultset[0]['userId'];
            $data->tag       = $resultset[0]['tag'];
            $data->isDeleted = $resultset[0]['isDeleted'];
            return $data;
        } else {
            throw new \Exception("UserTagId Does Not Present");
        }
    }
    
    public function update($data)
    {
        $query       = " UPDATE UserTags SET tag=:tag  WHERE id=:id";
        $placeholder = array(
            ':id' => $data->id,
            ':tag' => $data->tag
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        if ($result['rowCount'] == 1) {
            return "Successfuly Updated";
        } else {
            throw new \Exception("Updation Failed");
        }
        
    }
    
    public function delete($data)
    {
        $query       = " UPDATE UserTags SET isDeleted=1  WHERE id=:id";
        $placeholder = array(
            ':id' => $data->id
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        if ($result['rowCount'] == 1) {
            return "Successfuly deleted";
        } else {
            throw new \Exception("UserTagId Does Not Present");
        }
        
    }
}
