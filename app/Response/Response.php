<?php

namespace Notes\Response;

class Response
{
    private $statusCode;
    private $message;
    private $version;
    private $data;
    private $debugData;
    
    public function __construct($status, $message, $version, $data=null, $debugData=null)
    {
        $this->status = $status;
        $this->message    = $message;
        $this->version    = $version;
        $this->data       = $data;
        $this->debugData = $debugData;
    }
    public function getResponse()
    {
        return json_encode(get_object_vars($this));
    }
}
