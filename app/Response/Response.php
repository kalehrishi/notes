<?php

namespace Notes\Response;

class Response
{
    private $status;
    private $message;
    private $version;
    private $data;
    private $debugData;
    
    public function __construct($status, $message, $data = null, $debugData = null, $version = "1.0.1")
    {
        $this->status    = $status;
        $this->message   = $message;
        $this->version   = $version;
        $this->data      = $data;
        $this->debugData = $debugData;
    }
    public function getResponse()
    {
        return json_encode(get_object_vars($this));
    }
}
