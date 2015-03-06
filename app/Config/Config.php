<?php

namespace Notes\Config;

class Config
{
    private $obj;
    
    public function __construct($path)
    {
        $this->obj = json_decode(file_get_contents(__dir__."/$path"), true);
    }
    public function get()
    {
        return $this->obj;
        
    }
}
