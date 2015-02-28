<?php
namespace Notes\Mapper;

use Notes\Model\User as UserModel;

use Notes\Database\Database as Database;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class User
{
    public function create(UserModel $userModel)
    {
        
        $input = array(
            'firstName' => $userModel->getFirstName(),
            'lastName' => $userModel->getLastName(),
            'email' => $userModel->getEmail(),
            'password' => $userModel->getPassword(),
            'createdOn' => $userModel->getCreatedOn()
        );
        
        $query     = "INSERT INTO Users (firstName,lastName,email,password,createdOn)
         VALUES (:firstName,:lastName,:email,:password,:createdOn)";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $database  = new Database();
        $resultset = $database->post($params);
        if ($resultset['rowCount'] == 1) {
            $userModel->setId($resultset['lastInsertId']);
            return $userModel;
            
        }
        
    }
    public function read(UserModel $userModel)
    {
        
        $database = new Database();
        
        if ($userModel->getId()) {
            $input = array(
                'id' => $userModel->getId()
                
            );
            
            $query = "select id,firstName,lastName,email,password,createdOn from Users where id=:id";
        } elseif ($userModel->getEmail() && $userModel->getPassword()) {
            $input = array(
                
                'email' => $userModel->getEmail(),
                'password' => $userModel->getPassword()
            );
            $query = "select id,firstName,lastName,email,password,createdOn
             from Users where email=:email and password=:password";
        }
        
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        
        
        try {
            $database  = new Database();
            $resultset = $database->get($params);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
        
        if (!empty($resultset)) {
            $userModel->setId($resultset[0]['id']);
            $userModel->setFirstName($resultset[0]['firstName']);
            $userModel->setLastName($resultset[0]['lastName']);
            $userModel->setEmail($resultset[0]['email']);
            $userModel->setPassword($resultset[0]['password']);
            $userModel->setCreatedOn($resultset[0]['createdOn']);
            return $userModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($userModel);
            throw $obj;
        }
    }
    
    public function update(UserModel $userModel)
    {
        $database = new Database();
        $sql      = "UPDATE Users SET firstName=:firstName,lastName=:lastName,email=:email,
        password=:password,createdOn=:createdOn  WHERE id=:id";
        $input    = array(
            ':id' => $userModel->getId(),
            ':firstName' => $userModel->getFirstName(),
            ':lastName' => $userModel->getLastName(),
            ':email' => $userModel->getEmail(),
            ':password' => $userModel->getPassword(),
            ':createdOn' => $userModel->getCreatedOn()
        );
        $params   = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        try {
            $database  = new Database();
            $resultset = $database->update($params);
        } catch (\PDOException $e) {
            $e->getMessage();
        }
        
        if (!empty($resultset)) {
            return $userModel;
        } else {
            $obj = new ModelNotFoundException();
            $obj->setModel($userModel);
            throw $obj;
        }
    }
}
