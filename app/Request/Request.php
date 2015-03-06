<?php

namespace Notes\Request;

class Request
{
    public function __construct($request)
    {
        $this->input = explode(" ", $request);
        
    }
    public function get()
    {
        return $this->input;
    }
}
