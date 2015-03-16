<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

use Notes\Collection\UserTagCollection as UserTagCollection;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class UserTag
{
    public function create($userTagModel)
    {
        $query            = "INSERT INTO UserTags(userId,tag) VALUES (:userId,:tag)";
        $placeholder      = array(
            ':userId' => $userTagModel->getUserId(),
            ':tag' => $userTagModel->getTag()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $result           = $userTagModelbase->post($params);
        if ($result['rowCount'] == 1) {
            $userTagModel->setId($result['lastInsertId']);
            return $userTagModel;
        }
    }
    
    public function read($userTagModel)
    {
        $query            = " SELECT id,userId,tag,isDeleted FROM UserTags WHERE userId=:userId";
        $placeholder      = array(
            ':userId' => $userTagModel->getUserId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $resultset        = $userTagModelbase->get($params);
        if (!empty($resultset)) {
            return new UserTagCollection($resultset);
        } else {
            $exception = new ModelNotFoundException();
            $exception->setModel($userTagModel);
            throw $exception;
        }
    }

    public function readByUserTagId($userTagModel)
    {
        $query            = " SELECT id,userId,tag,isDeleted FROM UserTags WHERE id=:id";
        $placeholder      = array(
            ':id' => $userTagModel->getId()
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $resultset        = $userTagModelbase->get($params);
        if (!empty($resultset)) {
            $userTagModel->setUserId($resultset[0]['userId']);
            $userTagModel->setTag($resultset[0]['tag']);
            $userTagModel->setIsDeleted($resultset[0]['isDeleted']);
            return $userTagModel;
        } else {
            $exception = new ModelNotFoundException();
            $exception->setModel($userTagModel);
            throw $exception;
        }
    }
  
    
    public function update($userTagModel)
    {
        $query            = " UPDATE UserTags SET tag=:tag,userId=:userId,isDeleted=:isDeleted WHERE id=:id" ;
        $placeholder      = array(
            ':id' => $userTagModel->getId(),
            ':tag' => $userTagModel->getTag(),
            ':userId'=> $userTagModel->getUserId(),
            ':isDeleted'=>$userTagModel->getIsDeleted(),
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $userTagModelbase = new Database();
        $result           = $userTagModelbase->post($params);
        if ($result['rowCount'] == 1) {
            return $userTagModel ;
        } else {
            $exception = new ModelNotFoundException();
            $exception->setModel($userTagModel);
            throw $exception;
        }
    }
}
