<?php
namespace Notes\Mapper;

use Notes\Model\User as UserModel;

use Notes\Database\Database as Database;

class User
{
    public function create(UserModel $userModel)
    {
        try {
            $input     = array(
                'firstName' => $userModel->firstName,
                'lastName' => $userModel->lastName,
                'email' => $userModel->email,
                'password' => $userModel->password,
                'createdOn' => $userModel->createdOn
            );
            $query     = "INSERT INTO Users (firstName,lastName,email,password,createdOn)
         VALUES (:firstName,:lastName,:email,:password,:createdOn)";
            $params    = array(
                'dataQuery' => $query,
                'placeholder' => $input
            );
            $database  = new Database();
            $resultset = $database->post($params);
            return $resultset;
        } catch (\PDOException $e) {
            $e = "Missing parameters";
            return $e;
        }
        
        
    }
    public function read(UserModel $userModel)
    {
        
        $input = array(
            'id' => $userModel->id
        );
        
        $database  = new Database();
        $query     = "select id,firstName,lastName,email,password,createdOn from Users where id=:id";
        $params    = array(
            'dataQuery' => $query,
            'placeholder' => $input
        );
        $resultset = $database->get($params);
        if (!empty($resultset)) {
            $userModel->id        = $resultset[0]['id'];
            $userModel->firstName = $resultset[0]['firstName'];
            $userModel->lastName  = $resultset[0]['lastName'];
            $userModel->email     = $resultset[0]['email'];
            $userModel->password  = $resultset[0]['password'];
            $userModel->createdOn = $resultset[0]['createdOn'];
            return $userModel;
        } else {
            return "User Does Not Exists";
        }
    }
    
    
    public function update(UserModel $userModel)
    {
        $input = array(
            'id' => $userModel->id,
            'firstName' => $userModel->firstName,
            'lastName' => $userModel->lastName,
            'email' => $userModel->email,
            'password' => $userModel->password,
            'createdOn' => $userModel->createdOn
        );
        
        $database  = new Database();
        $sql       = "UPDATE Users SET id=:id,firstName=:firstName,lastName=:lastName,email=:email,
        password=:password  WHERE id=:id";
        $params    = array(
            'dataQuery' => $sql,
            'placeholder' => $input
        );
        $resultset = $database->update($params);
        return $resultset;
    }
}
