<?php

namespace Notes\Mapper;

use Notes\Database\Database as Database;

class Session
{
    
    public function create($sessionModel)
    {
        
        $query       = "INSERT INTO Sessions(userId,createdOn,expiredOn) VALUES (:userId, :createdOn, :expiredOn)";
        $placeholder = array(
            ':userId' => $sessionModel->getUserId(),
            ':createdOn' => $sessionModel->getCreatedOn(),
            ':expiredOn' => $sessionModel->getExpiredOn()
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $result      = $database->post($params);
        $sessionModel->setId($result['lastInsertId']);
            return $sessionModel;
        
    }
    


    public function read($sessionModel)
    {
        
        $query       = "select id,userId,createdOn,expiredOn,isExpired from Sessions where id=:id";
        $placeholder = array(
            ':id' => $sessionModel->getId()
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $resultset   = $database->get($params);
        if (!empty($resultset)) {
            $sessionModel->setId($resultset[0]['id']);
            $sessionModel->setUserId($resultset[0]['userId']);
            $sessionModel->setCreatedOn($resultset[0]['createdOn']);
            $sessionModel->setExpiredOn($resultset[0]['expiredOn']);
            $sessionModel->setIsExpired($resultset[0]['isExpired']);
            
            return $sessionModel;
        } else {
            throw new \Exception('invalid user');
        }
        
    }
    
    public function delete($sessionModel)
    {
        
        $query        = "UPDATE Sessions SET isExpired=:isExpired WHERE id=:id";
        $placeholder = array(
            ':id' => $sessionModel->getId(),
            ':isExpired' => $sessionModel->getIsExpired()
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
            throw new \Exception('User not found');
        }
        
    }

  public function update($sessionModel)
    {
        
        $query       = "update Sessions set userId=:userId,isExpired=:isExpired,
                      expiredOn=:expiredOn where id=:id";
        $placeholder = array(
            ':id' => $sessionModel->getId(),
            ':userId' => $sessionModel->getUserId(),
            ':expiredOn' => $sessionModel->getExpiredOn(),
            ':isExpired' => $sessionModel->getIsExpired(),
        );
        $params           = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database    = new Database();
        $resultset   = $database->post($params);
        if ($resultset['rowCount'] == 1) {
            return $this->read($sessionModel);
        } else {
            throw new \InvalidArgumentException("Updation Failed");
        }
        
    }
}
