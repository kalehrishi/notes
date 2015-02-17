<?php

namespace Notes\Mapper;

use Notes\Model\Session as SessionModel;

use Notes\Database\Database as Database;

class Session
{
    
    public function read($id)
    {
        $session            = new SessionModel();
        $session->id        = $id;
        $query              = "select id,userId,createdOn,expiredOn,isExpired from Sessions where id=:id";
        $placeholder        = array(
            ':id' => $id
        );
        $params             = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database           = new DataBase();
        $resultset          = $database->get($params);
        $session->id        = $resultset[0]['id'];
        $session->userId    = $resultset[0]['userId'];
        $session->createdOn = $resultset[0]['createdOn'];
        $session->expiredOn = $resultset[0]['expiredOn'];
        $session->isExpired = $resultset[0]['isExpired'];
        return $session;
    }
    
    public function create($input)
    {
        $session = new SessionModel();
        
        $session->userId    = $input['userId'];
        $session->createdOn = $input['createdOn'];
        $session->expiredOn = $input['expiredOn'];
        $query              = "INSERT INTO Sessions (userId,createdOn,expiredOn)VALUES(:userId,:createdOn,:expiredOn)";
        $placeholder        = $input;
        $params             = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database           = new DataBase();
        $result             = $database->post($params);
        $session->id = $result['lastInsertId'];
        return $session->id;
    }
    
    public function delete($id)
    {
        $sessionModel            = new SessionModel();
        $sessionModel->id        = $id;
        $sessionModel->isExpired = 1;
        $input                   = array(
            'id' => $id,
            'isExpired' => 1
        );
        $db                      = new Database();
        $sql                     = "UPDATE Sessions SET isExpired=:isExpired WHERE id=:id";
        $params                  = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset               = $db->update($params);
        return $resultset;
    }
}
