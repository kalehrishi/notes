<?php

namespace Notes\Mappers;

use Notes\Models\UserModel as UserModel;

use Notes\Database\Database as Database;

class UserMapper
{
    public function read($id)
    {
        $user         = new UserModel();
        $user->userid = $id;
        $query        = "select userid,name,age from user where userid=:id";
        $placeholder  = array(
            ':id' => $id
        );
        $params       = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database     = new DataBase();
        $resultset    = $database->get($params);
        $user->userid = $resultset[0]['userid'];
        $user->name   = $resultset[0]['name'];
        $user->age    = $resultset[0]['age'];
        return $user;
    }
    public function create($input)
    {
        $user         = new UserModel();
        $user->name   = $input['name'];
        $user->age    = $input['age'];
        $query        = "INSERT INTO user (name,age) VALUES (:name,:age)";
        $placeholder  = $input;
        $params       = array(
            'dataQuery'=> $query,
            'placeholder'=> $placeholder
        );
        $database     = new DataBase();
        $result = $database->post($params);
        $user->userid=$result['lastInsertId'];
        return $user->userid;
    }
    public function update($input)
    {
        $user         = new UserModel();
        $user->name   = $input['name'];
        $user->userid    = $input['id'];
        $query    = "update user set name=:name where userid=:id";
        $placeholder=array(
            ':name' => $input['name'],
            ':id' => $input['id']
            );
        $params   = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $database = new Database();
        $result     = $database->post($params);
        if ($result['rowCount']>0) {
            return "Record Successfully Updated";
        } else {
            return "Record Not Update";
        }

    }
}
