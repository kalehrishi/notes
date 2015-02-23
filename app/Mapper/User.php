<?php
namespace Notes\Mapper;

use Notes\Model\User as UserModel;

use Notes\Database\Database as Database;

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
        } else {
            return "User Id cannot be null";
        }
        
    }
    public function read(UserModel $userModel)
    {
        $input = array(
            'id' => $userModel->getId()
        );
        
        $database  = new Database();
        $query     = "select id,firstName,lastName,email,password,createdOn from Users where id=:id";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $resultset = $database->get($params);
        if (!empty($resultset)) {
            $userModel->setId($resultset[0]['id']);
            $userModel->setFirstName($resultset[0]['firstName']);
            $userModel->setLastName($resultset[0]['lastName']);
            $userModel->setEmail($resultset[0]['email']);
            $userModel->setPassword($resultset[0]['password']);
            $userModel->setCreatedOn($resultset[0]['createdOn']);
            return $userModel;
        } else {
            return "User Id Does Not Exists";
        }
    }
    
    
    public function update(UserModel $userModel)
    {
        $input = array(
            'id'       => $userModel->getId(),
            'firstName' => $userModel->getFirstName(),
            'lastName' => $userModel->getLastName(),
            'email' => $userModel->getEmail(),
            'password' => $userModel->getPassword(),
            'createdOn' => $userModel->getCreatedOn()
        );
        
        $database  = new Database();
        $sql       = "UPDATE Users SET firstName=:firstName,lastName=:lastName,email=:email,
        password=:password,createdOn=:createdOn  WHERE id=:id";
        $params    = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset = $database->update($params);
        if ($resultset['rowCount'] == 1) {
            return $this->read($userModel);
            
        } else {
            return "Updation Record Failed";
        }
    }
}
