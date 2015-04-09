<?php

namespace Notes\Response;

class Response
{
    private $status;
    private $message;
    private $version = '1.0.0';
    private $data;
    private $debugData;
    
    public function __construct($data = null, $status = '200', $message = 'OK', $debugData = null)
    {
        $this->status    = $status;
        $this->message   = $message;
        $this->data      = $data;
        $this->debugData = $debugData;
    }
    public function getResponse()
    {
        return json_encode(get_object_vars($this));
    }
}
