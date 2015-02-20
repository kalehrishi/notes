<?php

namespace Notes\Mapper;

use Notes\Model\Session as SessionModel;

use Notes\Database\Database as Database;

class Session
{
    
    
    
    
    
    public function create(SessionModel $sessionModel)
    {
        $input     = array(
            'userId' => $sessionModel->userId,
            'createdOn' => $sessionModel->createdOn,
            'expiredOn' => $sessionModel->expiredOn
        );
        $query     = "INSERT INTO Sessions(userId,createdOn,expiredOn) VALUES (:userId, :createdOn, :expiredOn)";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $database  = new Database();
        $resultset = $database->post($params);
        
        return $sessionModel;
    }
    
  public function read(SessionModel $sessionModel)
    {
        $input = array(
            'id' => $sessionModel->id
        );
        
        $database  = new Database();
        $query     = "select id,userId,createdOn,expiredOn,isExpired from Sessions where id=:id";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $resultset = $database->get($params);
        if (!empty($resultset)) {
            $sessionModel->id        = $resultset[0]['id'];
            $sessionModel->userId    = $resultset[0]['userId'];
            $sessionModel->createdOn = $resultset[0]['createdOn'];
            $sessionModel->expiredOn = $resultset[0]['expiredOn'];
            $sessionModel->isExpired = $resultset[0]['isExpired'];
            
            return $resultset;
        } else {
            throw new \InvalidArgumentException('invalid user');
        }
        
    }

    public function delete(SessionModel $sessionModel)
    {
        $input = array(
            'id' => $sessionModel->id,
            'isExpired' => $sessionModel->isExpired
        );
        if (!isset($input['id'])) {
            throw new \InvalidArgumentException('id does not present');
        } else {
            $db = new Database();
            
            $sql       = "UPDATE Sessions SET isExpired=:isExpired WHERE id=:id";
            $params    = array(
                'dataQuery' => $sql,
                'placeholder' => $input
            );
            $resultset = $db->update($params);
            
            return $sessionModel;
        }
        
    }
    
    public function update(SessionModel $sessionModel)
    {
        $input = array(
            'id' => $sessionModel->id,
            'isExpired' => $sessionModel->isExpired,
            'userId' => $sessionModel->userId
        );
        
        if (!isset($input['id'])) {
            throw new \InvalidArgumentException('Parameter Missing');
        } else {
            $database  = new Database();
            $query     = "update Sessions set userId=:userId,isExpired=:isExpired,
                          expiredOn=:expiredOn where id=:id";
            $params    = array(
                'dataQuery' => $sql,
                'placeholder' => $input
            );
            $resultset = $database->update($params);
            return $sessionModel;
        }
    }
}
