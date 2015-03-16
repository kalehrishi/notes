<?php

namespace Notes\Config;

class Config
{
    private $obj;
    
    public function __construct($fileName)
    {
        $this->obj = json_decode(file_get_contents(__dir__."/$fileName"), true);
    }
    public function get()
    {
        return $this->obj;
        
    }
}
