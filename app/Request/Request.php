<?php

namespace Notes\Request;

class Request
{
	public function __construct($request)
    {
        $this->input = json_decode($request,true);
    }
    public function read()
    {
        return $this->input;
    }
}
