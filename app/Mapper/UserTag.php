<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

class UserTag
{
    
    public function create($model)
    {
        $query       = "INSERT INTO UserTags(userId,tag) VALUES (:userId,:tag)";
        $placeholder = array(
            ':userId' => $model['id'],
            'tag' => $model['tag']
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
        $query       = " SELECT id,userId,tag,isDeleted FROM UserTags WHERE id=:id";
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
            return "UserTag is not Exit";
        }
    }
    
    public function update($model)
    {
        $query       = " UPDATE UserTags SET tag=:tag  WHERE id=:id";
        $placeholder = array(
            ':id' => $model['id'],
            ':tag' => $model['tag']
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        if ($result['rowCount'] > 0) {
            return "Successfuly Updated";
        } else {
            return "Updation Failed";
        }
        
    }
    
    public function delete($model)
    {
        $query       = " UPDATE UserTags SET isDeleted=1  WHERE id=:id";
        $placeholder = array(
            ':id' => $model['id']
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        if ($result['rowCount'] > 0) {
            return "Successfuly deleted";
        } else {
            return "Deletion Failed";
        }
        
    }
}
