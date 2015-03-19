<?php

namespace Notes\Response;

class Response
{
    private $statusCode;
    private $message;
    private $version;
    private $data;
    private $debug_data;
    
    public function __construct($statusCode, $message, $version, $data, $debug_data)
    {
        $this->statusCode = $statusCode;
        $this->message    = $message;
        $this->version    = $version;
        $this->data       = $data;
        $this->debug_data = $debug_data;
    }
    public function getResponse()
    {
        return json_encode(get_object_vars($this));
    }
}
