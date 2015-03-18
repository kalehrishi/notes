<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    
    public function create($sessionModel)
    {
        
        $query       = "INSERT INTO Sessions(userId,authToken,createdOn,expiredOn) VALUES
                        (:userId, :authToken, :createdOn, :expiredOn)";
        $placeholder = array(
        ':userId'    => $sessionModel->getUserId(),
        ':authToken' => $sessionModel->getAuthToken(),
        ':createdOn' => $sessionModel->getCreatedOn(),
        ':expiredOn' => $sessionModel->getExpiredOn()
        );
        $params      = array(
        'dataQuery'  => $query,
        'placeholder'=> $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        $sessionModel->setId($result['lastInsertId']);
        return $sessionModel;
    }
    
    public function read($sessionModel)
    {
        if ($sessionModel->getId()) {
            $query       = "select id,userId,authToken,createdOn,expiredOn,isExpired from Sessions where id=:id";
            $placeholder = array(
                ':id'    => $sessionModel->getId()
            );
        } elseif ($sessionModel->getAuthToken() && $sessionModel->getUserId()) {
             $query       = "select id,userId,authToken,createdOn,expiredOn,isExpired from 
                            Sessions where userId=:userId And authToken = :authToken";
                            $placeholder = array(
            'userId'     => $sessionModel->getUserId(),
            'authToken'  => $sessionModel->getAuthToken()
            
            );
        }
            $params      = array(
            'dataQuery'  => $query,
            'placeholder'=> $placeholder
        );
            $database  = new Database();
            $resultset = $database->get($params);
        if (!empty($resultset)) {
            $sessionModel->setId($resultset[0]['id']);
            $sessionModel->setUserId($resultset[0]['userId']);
            $sessionModel->setAuthToken($resultset[0]['authToken']);
            $sessionModel->setCreatedOn($resultset[0]['createdOn']);
            $sessionModel->setExpiredOn($resultset[0]['expiredOn']);
            $sessionModel->setIsExpired($resultset[0]['isExpired']);
            return $sessionModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($sessionModel);
            throw $obj;
        }
    }
    
    public function update($sessionModel)
    {
        $query       = "update Sessions set userId=:userId,isExpired=1,
                        expiredOn=:expiredOn where id=:id";
        $placeholder = array(
            ':id'    => $sessionModel->getId(),
            ':userId'=> $sessionModel->getUserId(),
            ':expiredOn' => $sessionModel->getExpiredOn(),
            //':isExpired' => $sessionModel->getIsExpired()
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $resultset   = $database->post($params);
        
        if ($resultset['rowCount'] == 1) {
            return $this->read($sessionModel);
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($sessionModel);
            throw $obj;
        }
    }
}
