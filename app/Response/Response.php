<?php

namespace Notes\Response;

class Response
{
    private $status;
    private $message;
    private $version;
    private $data;
    private $debugData;
    
    public function __construct($status, $message, $version, $data = null, $debugData = null)
    {
        $this->status    = $status;
        $this->message   = $message;
        $this->version   = $version;
        $this->data      = $data;
        $this->debugData = $debugData;
        $this->setProtocolVersion('1.0.1');
    }
    public function getResponse()
    {
        return json_encode(get_object_vars($this));
    }

    public function setProtocolVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    
    public function getProtocolVersion()
    {
        return $this->version;
    }
}
