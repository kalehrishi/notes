<?php

namespace Notes\Model;

class Session
{
    public $id;
    public $userId;
    public $createdOn;
    public $expiredOn;
    public $isExpired;

    public function __construct($params)
    {
        foreach ($params as $key => $val) {
            if (isset($key)) {
                $this->{$key} = $val;
            }
        }
    }
}
