<?php

namespace Notes\Model;

use Notes\Model\Note as NoteModel;

use Notes\Model\UserTag as UserTagModel;

class NoteTag
{
    public $id;
    public $noteId;
    public $userTagId;
    
    public function __construct()
    {
        $args = func_get_args();
        foreach ($args as $index => $key) {
            foreach ($key as $key => $value) {
                switch ($key) {
                    case 'id':
                        $this->id = $value;
                        break;
                    case 'noteId':
                        $this->noteId = $value;
                        break;
                    case 'userTagId':
                        $this->userTagId = $value;
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
