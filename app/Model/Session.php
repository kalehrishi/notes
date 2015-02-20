<?php

namespace Notes\Model;

class Session
{
    public $id;
    public $userId;
    public $createdOn;
    public $expiredOn;
    public $isExpired;
/*
public function __construct($value)
{
if (isset($id)) {
   $this->id=$value['id'];
 }
if (isset($userId)) {
$this->userId=$value['userId'];
}
if (isset($createdOn)){
$this->createdOn=$value['createdOn'];
}
if (isset($expiredOn)){
$this->expiredOn=$value['expiredOn'];
}
if (isset($isExpired))
{
$this->isExpired=$value['isExpired'];
}
}*/
public function __construct($params)
    {
        foreach ($params as $key => $val) {
            if (isset($key)) {
                $this->{$key} = $val;
            }
        }
    }
}
