<?php

namespace Notes\Request;

class Request
{
    protected $request;
    
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function data()
    {
        return json_decode($this->request->getBody(), true);
    }
    public function version()
    {
        return $this->request->getScheme();
    }
    public function cookies()
    {
        return $this->request->cookies;
    }
}
