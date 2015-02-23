<?php
namespace Notes\Model;

class Note
{
    public $id;
    public $userId;
    public $title;
    public $body;
    public $createdOn;
    public $lastUpdatedOn;
    public $isDeleted;
    
    public function __construct($params)
    {
        foreach ($params as $key => $val) {
            if (isset($key)) {
                $this->{$key} = $val;
            }
        }
    }
}
