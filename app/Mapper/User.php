<?php
namespace Notes\Mapper;

use Notes\Model\User as UserModel;

use Notes\Database\Database as Database;

class User
{
    
    public function create($input)
    {
        $user            = new UserModel();
        $user->firstName = $input['firstName'];
        $user->lastName  = $input['lastName'];
        $user->email     = $input['email'];
        $user->password  = $input['password'];
        $user->createdOn = $input['createdOn'];
        $query           = "INSERT INTO Users (firstName,lastName,email,password,createdOn) VALUES (:firstName,:lastName,:email,:password,:createdOn)";
        $placeholder     = $input;
        $params          = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database        = new DataBase();
        $result          = $database->post($params);
        $user->userid    = $result['lastInsertId'];
        return $user->userid;
    }
    public function read($id)
    {
        $user            = new UserModel();
        $user->id        = $id;
        $query           = "select id,firstName,lastName,email,password,createdOn from Users where id=:id";
        $placeholder     = array(
            ':id' => $id
        );
        $params          = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database        = new DataBase();
        $resultset       = $database->get($params);
        $user->id        = $resultset[0]['id'];
        $user->firstName = $resultset[0]['firstName'];
        $user->lastName  = $resultset[0]['lastName'];
        $user->email     = $resultset[0]['email'];
        $user->password  = $resultset[0]['password'];
        $user->createdOn = $resultset[0]['createdOn'];
        return $user;
    }
    
    public function update($input)
    {
        $user            = new UserModel();
        $user->firstName = $input['firstName'];
        $user->id        = $input['id'];
        $query           = "update Users set firstName=:firstName where id=:id";
        $placeholder     = array(
            ':firstName' => $input['firstName'],
            ':id' => $input['id']
        );
        $params          = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database        = new Database();
        $result          = $database->post($params);
        if ($result['rowCount'] > 0) {
            return "Record Successfully Updated";
        } else {
            return "Record Not Updated";
        }
        
    }
    public function delete($input)
    {
        $user            = new UserModel();
        $user->firstName = $input['firstName'];
        $user->id        = $input['id'];
        $query           = "DELETE from Users where id=:id";
        $placeholder     = array(
            ':firstName' => $input['firstName'],
            ':id' => $input['id']
        );
        $params          = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database        = new Database();
        $result          = $database->post($params);
        if ($result['rowCount'] > 0) {
            return "Record Successfully Deleted";
        } else {
            return "Record Not Deleted";
        }
    }
}
