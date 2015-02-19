<?php

namespace Notes\Model;

use Notes\Model\User as UserModel;

class UserTag
{
    public $id;
    public $userId;
    public $tag;
    public $isDeleted;
    
    public function __construct()
    {
        $args = func_get_args();
        foreach ($args as $index => $key) {
            foreach ($key as $key => $value) {
                switch ($key) {
                    case 'id':
                        $this->id = $value;
                        break;
                    case 'userId':
                        $this->userId = $value;
                        break;
                    case 'tag':
                        $this->tag = $value;
                        break;
                    case 'isDeleted':
                        $this->isDeleted = $value;
                        break;
                }
            }
        }
    }
    public function get()
    {
        
    }
    public function set($input)
    {
        $this->id = $input['id'];
        
    }
}
