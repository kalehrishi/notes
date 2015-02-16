<?php

namespace Notes\Config;

class Config
{
    private $obj;
    
    public function __construct()
    {
        
        $this->obj = json_decode(file_get_contents(dirname(__FILE__) . '/config.json'), true);
    }
    public function get()
    {
        return $this->obj;
        
    }
}
