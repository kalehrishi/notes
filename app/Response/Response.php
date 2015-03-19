<?php

namespace Notes\Response;

class Response
{
    public function __construct($code, $status, $data)
    {
        if ($status = "success") {
            $this->toJson($data);
        } else {
            $this->ErrorMessage();
        }
        
    }
    public function errorMessage()
    {
        
    }
    public function toJson()
    {
        
    }
}
